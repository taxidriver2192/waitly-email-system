<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateType;
use App\Models\EmailTemplateTranslation;
use App\Models\Language;
use Illuminate\Database\Seeder;

class CompanyEmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating company email templates...\n";

        $acme = Company::where('slug', 'acme')->first();
        $welcomeType = EmailTemplateType::where('key', 'welcome_user')->first();
        $en = Language::where('code', 'en')->first();

        // Acme custom welcome (English only)
        $acmeWelcome = EmailTemplate::create([
            'company_id' => $acme->id,
            'email_template_type_id' => $welcomeType->id,
            'is_default' => false,
            'is_active' => true,
        ]);
        echo "  - Acme Corporation custom Welcome User template\n";

        EmailTemplateTranslation::create([
            'email_template_id' => $acmeWelcome->id,
            'language_id' => $en->id,
            'subject' => 'Welcome to Acme Corporation!',
            'html_body' => '<h1>Welcome to Acme!</h1><p>Hi {{ user_name }}, we\'re excited to have you on board at Acme Corporation!</p><a href="{{ login_url }}">Get Started</a>',
        ]);
        echo "    - English translation\n";
    }
}
