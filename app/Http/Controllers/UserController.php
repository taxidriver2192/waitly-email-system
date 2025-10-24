<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\EmailTemplateType;
use App\Models\Language;
use App\Services\EmailTemplateService;
use App\Mail\DynamicTemplateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $companies = Company::with('users')->get();
        return view('users.index', compact('companies'));
    }

    public function emailTestForm()
    {
        $companies = Company::with('users')->get();
        $types = EmailTemplateType::all();
        $languages = Language::where('is_active', true)->get();

        return view('emails.test-form', compact('companies', 'types', 'languages'));
    }

    public function sendTestEmail(Request $request, EmailTemplateService $service)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'email_type' => 'required|string',
            'language' => 'required|string|size:2',
            'recipient_user_id' => 'required|exists:users,id',
        ]);

        $result = $service->resolveTemplate(
            $validated['company_id'],
            $validated['email_type'],
            $validated['language']
        );

        if (!$result) {
            return back()->with('error', __('messages.email_sent_error'));
        }

        $template = $result['template'];
        $company = Company::find($validated['company_id']);
        $recipientUser = \App\Models\User::find($validated['recipient_user_id']);

        // Create the mailable instance
        $mailable = new DynamicTemplateMail($template, [
            'user_name' => $recipientUser->name,
            'company_name' => $company->name,
            'login_url' => 'https://example.com/login',
            'reset_link' => 'https://example.com/reset',
            'expiry_time' => '24 hours',
        ]);

        // Actually send the email through Mail system (same as CLI command)
        $mailableWithCompany = new DynamicTemplateMail($template, [
            'user_name' => $recipientUser->name,
            'company_name' => $company->name,
            'login_url' => 'https://example.com/login',
            'reset_link' => 'https://example.com/reset',
            'expiry_time' => '24 hours',
        ], $company->name, $company->domain);

        Mail::to($recipientUser->email)->send($mailableWithCompany);

        // Log the email for debugging (same as CLI command)
        Log::info("Web Form - Template resolved: {$result['source_info']}");
        Log::info("Web Form - Company: {$company->name}, Type: {$validated['email_type']}, Language: {$validated['language']}");
        Log::info("Web Form - Recipient: {$recipientUser->name} ({$recipientUser->email})");

        // Get the rendered email content for preview
        $renderedEmail = $mailableWithCompany->render();
        Log::debug("Web Form - Email Content:\n" . $renderedEmail);

        // Map source_info to fallback level
        $fallbackLevel = match(true) {
            str_contains($result['source_info'], 'Company template in ' . $validated['language']) => 1,
            str_contains($result['source_info'], 'Company template in English (fallback)') => 2,
            str_contains($result['source_info'], 'Platform default in ' . $validated['language']) => 3,
            str_contains($result['source_info'], 'Platform default in English') => 4,
            default => null
        };

        // Return to the form with success message and email preview
        return back()->with('success', "Email sent to {$recipientUser->email}! Check logs for details.")
                    ->with('email_preview', $renderedEmail)
                    ->with('email_data', [
                        'sender_name' => $company->name,
                        'sender_email' => 'no-reply@' . $company->domain,
                        'recipient_name' => $recipientUser->name,
                        'recipient_email' => $recipientUser->email,
                        'company' => $company->name,
                        'email_type' => $validated['email_type'],
                        'language' => $validated['language'],
                        'template_source' => $result['source_info'],
                        'fallback_level' => $fallbackLevel
                    ]);
    }

    public function switchLanguage(Request $request)
    {
        $locale = $request->input('locale');

        // Validate that the locale is supported
        $supportedLocales = ['da', 'en'];
        if (!in_array($locale, $supportedLocales)) {
            return back()->with('error', 'Unsupported language');
        }

        // Set the locale
        App::setLocale($locale);
        session(['locale' => $locale]);

        // Get language name for the message
        $languageNames = [
            'da' => 'Dansk',
            'en' => 'English'
        ];

        return back()->with('success', __('messages.language_changed', ['language' => $languageNames[$locale]]));
    }
}
