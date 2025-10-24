<?php

namespace Database\Seeders;

use App\Models\EmailTemplateType;
use Illuminate\Database\Seeder;

class EmailTemplateTypeSeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating email template types...\n";

        EmailTemplateType::create([
            'key' => 'welcome_user',
            'name' => 'Welcome User',
            'description' => 'Sent when a new user registers',
            'variables' => ['user_name', 'company_name', 'login_url'],
        ]);
        echo "  - Welcome User (welcome_user)\n";

        EmailTemplateType::create([
            'key' => 'password_reset',
            'name' => 'Password Reset',
            'description' => 'Sent when user requests password reset',
            'variables' => ['user_name', 'reset_link', 'expiry_time'],
        ]);
        echo "  - Password Reset (password_reset)\n";
    }
}
