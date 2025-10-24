<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Language;
use App\Models\EmailTemplateType;
use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CompanySeeder::class,
            EmailTemplateTypeSeeder::class,
            PlatformEmailTemplateSeeder::class,
            CompanyEmailTemplateSeeder::class,
            UserSeeder::class,
        ]);

        // Display seeding statistics
        $this->displaySeedingStats();
    }

    /**
     * Display statistics about what was seeded
     */
    private function displaySeedingStats(): void
    {
        $companies = Company::count();
        $languages = Language::count();
        $emailTypes = EmailTemplateType::count();
        $platformTemplates = EmailTemplate::whereNull('company_id')->count();
        $companyTemplates = EmailTemplate::whereNotNull('company_id')->count();
        $users = User::count();

        // Get user count per company
        $usersPerCompany = Company::withCount('users')->get();

        echo "\n" . str_repeat("=", 60) . "\n";
        echo "SEEDING COMPLETED SUCCESSFULLY!\n";
        echo str_repeat("=", 60) . "\n";
        echo "DATABASE STATISTICS:\n";
        echo str_repeat("-", 60) . "\n";
        echo "Companies: {$companies}\n";
        echo "Languages: {$languages}\n";
        echo "Email Types: {$emailTypes}\n";
        echo "Platform Templates: {$platformTemplates}\n";
        echo "Company Templates: {$companyTemplates}\n";
        echo "Total Users: {$users}\n";
        echo str_repeat("-", 60) . "\n";
        echo "USERS PER COMPANY:\n";

        foreach ($usersPerCompany as $company) {
            echo "   • {$company->name}: {$company->users_count} users\n";
        }

        echo str_repeat("=", 60) . "\n";
        echo "Ready to test email templates!\n";
        echo "Visit: http://localhost:8080/email-test\n";
        echo str_repeat("=", 60) . "\n\n";
    }
}
