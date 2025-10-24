<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating companies...\n";

        Company::create([
            'name' => 'Acme Corporation',
            'slug' => 'acme',
            'domain' => 'acme.waitly.test',
            'is_active' => true,
        ]);
        echo "  - Acme Corporation (acme.waitly.test)\n";

        Company::create([
            'name' => 'Global Industries',
            'slug' => 'global',
            'domain' => 'global.waitly.test',
            'is_active' => true,
        ]);
        echo "  - Global Industries (global.waitly.test)\n";

        Company::create([
            'name' => 'TechStart Inc',
            'slug' => 'techstart',
            'domain' => 'techstart.waitly.test',
            'is_active' => true,
        ]);
        echo "  - TechStart Inc (techstart.waitly.test)\n";
    }
}
