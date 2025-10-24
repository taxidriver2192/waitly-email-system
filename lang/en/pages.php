<?php

return [
    'users' => [
        'title' => 'Users by Company',
        'description' => 'Manage and view users across all companies',
        'active' => 'Active',
        'users_count' => 'users',
    ],
    'email_test' => [
        'title' => 'Test Email System',
        'description' => 'Test the 4-tier fallback logic with different companies and languages',
        'company' => 'Company',
        'company_help' => 'Choose a company to test fallback logic',
        'email_type' => 'Email Type',
        'email_type_help' => 'Select the type of email to send',
        'language' => 'Language',
        'language_help' => 'Test fallback to English if not available',
        'recipient_email' => 'Recipient Email',
        'recipient_email_help' => 'Email will be logged to storage/logs/laravel.log',
        'send_button' => 'Send Test Email',
        'preview_button' => 'Preview Email',
        'preview_title' => 'Email Preview',
        'template_source' => 'Template Source',
        'fallback_info' => [
            'title' => 'Fallback Logic Test',
            'level1' => 'Level 1: Company template in requested language',
            'level2' => 'Level 2: Company template in English (fallback)',
            'level3' => 'Level 3: Platform default in requested language',
            'level4' => 'Level 4: Platform default in English (guaranteed)',
        ],
    ],
];
