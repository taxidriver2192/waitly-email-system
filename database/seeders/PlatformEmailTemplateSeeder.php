<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\EmailTemplateType;
use App\Models\EmailTemplateTranslation;
use App\Models\Language;
use Illuminate\Database\Seeder;

class PlatformEmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating platform email templates...\n";

        $welcomeType = EmailTemplateType::where('key', 'welcome_user')->first();
        $passwordResetType = EmailTemplateType::where('key', 'password_reset')->first();

        $da = Language::where('code', 'da')->first();
        $en = Language::where('code', 'en')->first();
        $es = Language::where('code', 'es')->first();
        $fr = Language::where('code', 'fr')->first();

        // Platform default: Welcome User (DA + EN + ES + FR)
        $welcomeTemplate = EmailTemplate::create([
            'company_id' => null,
            'email_template_type_id' => $welcomeType->id,
            'is_default' => true,
            'is_active' => true,
        ]);
        echo "  - Welcome User template (platform default)\n";

        // Danish translation
        EmailTemplateTranslation::create([
            'email_template_id' => $welcomeTemplate->id,
            'language_id' => $da->id,
            'subject' => 'Velkommen til Waitly, {{ user_name }}!',
            'html_body' => '<h1>Velkommen {{ user_name }}!</h1><p>Tak fordi du tilsluttede dig {{ company_name }}.</p><a href="{{ login_url }}">Log ind nu</a>',
            'preheader' => 'Kom i gang med Waitly',
        ]);
        echo "    - Danish translation\n";

        // English translation
        EmailTemplateTranslation::create([
            'email_template_id' => $welcomeTemplate->id,
            'language_id' => $en->id,
            'subject' => 'Welcome to Waitly, {{ user_name }}!',
            'html_body' => '<h1>Welcome {{ user_name }}!</h1><p>Thanks for joining {{ company_name }}.</p><a href="{{ login_url }}">Login Now</a>',
            'preheader' => 'Get started with Waitly',
        ]);
        echo "    - English translation\n";

        // Spanish translation
        EmailTemplateTranslation::create([
            'email_template_id' => $welcomeTemplate->id,
            'language_id' => $es->id,
            'subject' => '¡Bienvenido a Waitly, {{ user_name }}!',
            'html_body' => '<h1>¡Bienvenido {{ user_name }}!</h1><p>Gracias por unirte a {{ company_name }}.</p><a href="{{ login_url }}">Iniciar Sesión</a>',
            'preheader' => 'Comienza con Waitly',
        ]);
        echo "    - Spanish translation\n";

        // French translation
        EmailTemplateTranslation::create([
            'email_template_id' => $welcomeTemplate->id,
            'language_id' => $fr->id,
            'subject' => 'Bienvenue chez Waitly, {{ user_name }} !',
            'html_body' => '<h1>Bienvenue {{ user_name }} !</h1><p>Merci de rejoindre {{ company_name }}.</p><a href="{{ login_url }}">Se connecter maintenant</a>',
            'preheader' => 'Commencez avec Waitly',
        ]);
        echo "    - French translation\n";

        // Platform default: Password Reset (DA + EN)
        $passwordTemplate = EmailTemplate::create([
            'company_id' => null,
            'email_template_type_id' => $passwordResetType->id,
            'is_default' => true,
            'is_active' => true,
        ]);
        echo "  - Password Reset template (platform default)\n";

        // Danish translation
        EmailTemplateTranslation::create([
            'email_template_id' => $passwordTemplate->id,
            'language_id' => $da->id,
            'subject' => 'Nulstil din adgangskode',
            'html_body' => '<h1>Nulstil adgangskode</h1><p>Hej {{ user_name }}, klik nedenfor for at nulstille din adgangskode:</p><a href="{{ reset_link }}">Nulstil adgangskode</a><p>Linket udløber om {{ expiry_time }}.</p>',
        ]);
        echo "    - Danish translation\n";

        // English translation
        EmailTemplateTranslation::create([
            'email_template_id' => $passwordTemplate->id,
            'language_id' => $en->id,
            'subject' => 'Reset your password',
            'html_body' => '<h1>Password Reset</h1><p>Hi {{ user_name }}, click below to reset your password:</p><a href="{{ reset_link }}">Reset Password</a><p>Link expires in {{ expiry_time }}.</p>',
        ]);
        echo "    - English translation\n";

        // French translation
        EmailTemplateTranslation::create([
            'email_template_id' => $passwordTemplate->id,
            'language_id' => $fr->id,
            'subject' => 'Réinitialisez votre mot de passe',
            'html_body' => '<h1>Réinitialisation du mot de passe</h1><p>Bonjour {{ user_name }}, cliquez ci-dessous pour réinitialiser votre mot de passe :</p><a href="{{ reset_link }}">Réinitialiser le mot de passe</a><p>Le lien expire dans {{ expiry_time }}.</p>',
        ]);
        echo "    - French translation\n";
    }
}
