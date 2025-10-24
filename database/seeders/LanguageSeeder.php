<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating languages...\n";

        Language::create([
            'code' => 'en',
            'name' => 'English',
            'is_default' => true,
            'is_active' => true,
        ]);
        echo "  - English (default)\n";

        Language::create([
            'code' => 'da',
            'name' => 'Danish',
            'is_active' => true,
        ]);
        echo "  - Danish\n";

        Language::create([
            'code' => 'es',
            'name' => 'Spanish',
            'is_active' => true,
        ]);
        echo "  - Spanish\n";

        Language::create([
            'code' => 'fr',
            'name' => 'French',
            'is_active' => true,
        ]);
        echo "  - French\n";
    }
}
