<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        echo "Creating users...\n";

        $companies = Company::all();
        $faker = Faker::create();

        foreach ($companies as $company) {
            // Create random number of users between 4-12
            $userCount = $faker->numberBetween(4, 12);
            echo "  - {$company->name}: {$userCount} users\n";

            for ($i = 0; $i < $userCount; $i++) {
                User::create([
                    'company_id' => $company->id,
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'password' => Hash::make($faker->password()),
                ]);
            }
        }
    }
}
