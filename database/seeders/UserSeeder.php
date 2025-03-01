<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $fakeEmail = $faker->unique()->email;
        echo $fakeEmail; // Outputs something like "john.doe@example.com"
        // Get admin user or create one if doesn't exist


        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => $fakeEmail,
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

        $faker = Factory::create();
        $fakeEmail = $faker->unique()->email;
        echo $fakeEmail; // Outputs something like "john.doe@example.com"
        // Get admin user or create one if doesn't exist


        // Create instructor
        User::factory()->create([
            'name' => 'Test Instructor',
            'email' => $fakeEmail,
            'password' => Hash::make('password'),
            'is_instructor' => true,
            'email_verified_at' => now()
        ]);

        $faker = Factory::create();
        $fakeEmail = $faker->unique()->email;
        echo $fakeEmail; // Outputs something like "john.doe@example.com"
        // Get admin user or create one if doesn't exist


        // Create regular user
        User::factory()->create([
            'name' => 'Test User',
            'email' => $fakeEmail,
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        // Create additional users
        User::factory()
            ->count(3)
            ->create();
    }
} 