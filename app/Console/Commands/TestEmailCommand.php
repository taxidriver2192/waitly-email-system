<?php

namespace App\Console\Commands;

use App\Mail\DynamicTemplateMail;
use App\Models\Company;
use App\Models\User;
use App\Services\EmailTemplateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    protected $signature = 'email:test
                            {company : Company slug}
                            {type : Email type (welcome_user, password_reset)}
                            {language : Language code (en, da, es, fr)}';

    protected $description = 'Test email template resolution with fallback logic';

    public function handle(EmailTemplateService $service)
    {
        $company = Company::where('slug', $this->argument('company'))->first();

        if (!$company) {
            $this->error("Company not found: {$this->argument('company')}");
            return 1;
        }

        $type = $this->argument('type');
        $language = $this->argument('language');

        $this->info("Resolving template...");
        $this->info("Company: {$company->name} (ID: {$company->id})");
        $this->info("Type: {$type}");
        $this->info("Language: {$language}");
        $this->newLine();

        $result = $service->resolveTemplate($company->id, $type, $language);

        if (!$result) {
            $this->error("No template found!");
            return 1;
        }

        $template = $result['template'];
        $translation = $template->translations->first();

        $this->info("Template resolved!");
        $this->info("Source: {$result['source_info']}");
        $this->info("Language: {$translation->language->name} ({$translation->language->code})");
        $this->newLine();

        $this->info("Subject: {$translation->subject}");
        $this->newLine();

        // Get a random user from the company (same as web form)
        $user = $company->users()->inRandomOrder()->first();

        if (!$user) {
            $this->error("No users found for company: {$company->name}");
            return 1;
        }

        $this->info("Sender: {$company->name} <no-reply@{$company->domain}>");
        $this->info("Recipient: {$user->name} <{$user->email}>");
        $this->newLine();

        if ($this->confirm('Send test email?', true)) {
            Mail::to($user->email)->send(
                new DynamicTemplateMail($template, [
                    'user_name' => $user->name,
                    'company_name' => $company->name,
                    'login_url' => 'https://example.com/login',
                    'reset_link' => 'https://example.com/reset',
                    'expiry_time' => '24 hours',
                ], $company->name, $company->domain)
            );

            $this->info("Email sent to {$user->email}");
            $this->info("Check storage/logs/laravel.log for email content");
        }

        return 0;
    }
}
