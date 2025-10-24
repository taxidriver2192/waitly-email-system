<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Language;
use Illuminate\Support\Facades\Log;

class EmailTemplateService
{
    /**
     * Resolve email template with 4-tier fallback logic
     *
     * Fallback order:
     * 1. Company-specific template in requested language
     * 2. Company-specific template in English (fallback)
     * 3. Platform default in requested language
     * 4. Platform default in English (final fallback)
     *
     * @param int $companyId Company ID
     * @param string $type Email type key (e.g., 'welcome_user')
     * @param string $language Language code (e.g., 'en', 'es', 'fr')
     * @return array|null ['template' => EmailTemplate, 'source_info' => string]
     */
    public function resolveTemplate(int $companyId, string $type, string $language): ?array
    {
        // Level 1: Company-specific in requested language
        $template = $this->findTemplate($companyId, $type, $language);
        if ($template) {
            Log::info("Template resolved: Company {$companyId}, {$type}, {$language}");
            return [
                'template' => $template,
                'source_info' => "Company template in {$language}"
            ];
        }

        // Level 2: Company-specific in English (fallback)
        if ($language !== 'en') {
            $template = $this->findTemplate($companyId, $type, 'en');
            if ($template) {
                Log::info("Template resolved: Company {$companyId}, {$type}, en (company fallback)");
                return [
                    'template' => $template,
                    'source_info' => "Company template in English (fallback)"
                ];
            }
        }

        // Level 3: Platform default in requested language
        $template = $this->findTemplate(null, $type, $language);
        if ($template) {
            Log::info("Template resolved: Platform default, {$type}, {$language}");
            return [
                'template' => $template,
                'source_info' => "Platform default in {$language}"
            ];
        }

        // Level 4: Platform default in English (final fallback)
        $template = $this->findTemplate(null, $type, 'en');
        if ($template) {
            Log::info("Template resolved: Platform default, {$type}, en (final fallback)");
            return [
                'template' => $template,
                'source_info' => "Platform default in English (final fallback)"
            ];
        }

        Log::warning("No template found: Company {$companyId}, {$type}, {$language}");
        return null;
    }

    /**
     * Find template by specific criteria using Eloquent relationships
     *
     * @param int|null $companyId Company ID or null for platform defaults
     * @param string $type Email type key
     * @param string $language Language code
     * @return EmailTemplate|null
     */
    private function findTemplate(?int $companyId, string $type, string $language): ?EmailTemplate
    {
        return EmailTemplate::query()
            ->when($companyId, fn($q) => $q->where('company_id', $companyId))
            ->when(is_null($companyId), fn($q) => $q->whereNull('company_id')->where('is_default', true))
            ->whereHas('type', fn($q) => $q->where('key', $type))
            ->whereHas('translations', fn($q) =>
                $q->whereHas('language', fn($l) => $l->where('code', $language))
            )
            ->with(['translations' => fn($q) =>
                $q->whereHas('language', fn($l) => $l->where('code', $language))
            ])
            ->where('is_active', true)
            ->first();
    }

    /**
     * Replace template placeholders with actual data
     *
     * @param EmailTemplate $template Template with translations loaded
     * @param array $data Associative array of placeholder => value
     * @return array ['subject' => string, 'body' => string]
     */
    public function replacePlaceholders(EmailTemplate $template, array $data): array
    {
        $translation = $template->translations->first();

        if (!$translation) {
            return ['subject' => '', 'body' => ''];
        }

        $subject = $translation->subject;
        $body = $translation->html_body;

        // Replace {{ variable_name }} with actual values
        foreach ($data as $key => $value) {
            $subject = str_replace("{{ {$key} }}", $value, $subject);
            $body = str_replace("{{ {$key} }}", $value, $body);
        }

        return [
            'subject' => $subject,
            'body' => $body,
        ];
    }

}
