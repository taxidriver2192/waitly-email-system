<?php

return [
    'users' => [
        'title' => 'Brugere efter Virksomhed',
        'description' => 'Administrer og se brugere på tværs af alle virksomheder',
        'active' => 'Aktiv',
        'users_count' => 'brugere',
    ],
    'email_test' => [
        'title' => 'Test E-mail System',
        'description' => 'Test 4-niveau fallback logik med forskellige virksomheder og sprog',
        'company' => 'Virksomhed',
        'company_help' => 'Vælg en virksomhed for at teste fallback logik',
        'email_type' => 'E-mail Type',
        'email_type_help' => 'Vælg typen af e-mail der skal sendes',
        'language' => 'Sprog',
        'language_help' => 'Test fallback til engelsk hvis ikke tilgængelig',
        'recipient_email' => 'Modtager E-mail',
        'recipient_email_help' => 'E-mail vil blive logget til storage/logs/laravel.log',
        'send_button' => 'Send Test E-mail',
        'preview_button' => 'Forhåndsvis E-mail',
        'preview_title' => 'E-mail Forhåndsvisning',
        'template_source' => 'Skabelon Kilde',
        'fallback_info' => [
            'title' => 'Fallback Logik Test',
            'level1' => 'Niveau 1: Virksomheds skabelon på ønsket sprog',
            'level2' => 'Niveau 2: Virksomheds skabelon på engelsk (fallback)',
            'level3' => 'Niveau 3: Platform standard på ønsket sprog',
            'level4' => 'Niveau 4: Platform standard på engelsk (garanteret)',
        ],
    ],
];
