<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Faker\Factory;

class UserSeeder extends Seeder
{

    public function __construct() {
    }
    public function run()
    {
        $fakeEmail = fake()->email();
        echo $fakeEmail; // Outputs something like "john.doe@example.com"
        // Get admin user or create one if doesn't exist

        // Create admin user
        User::factory()->create([
            'name' => fake()->words(),
            'email' => fake()->unique()->email,
            'password' => Hash::make(fake()->words(1)),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

        $fakeEmail = fake()->email();
        echo $fakeEmail; // Outputs something like "john.doe@example.com"
        // Get admin user or create one if doesn't exist

        debug_logs("here");

        // Create instructor
        User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'password' => Hash::make(fake()->words(10)),
            'is_instructor' => true,
            'email_verified_at' => now()
        ]);

        $fakeEmail = fake()->unique()->email();
        debug_logs("here");
        // Get admin user or create one if doesn't exist


        // Create regular user
        User::factory()->create([
            'name' => fake()->name(),
            'email' => $fakeEmail,
            'password' => Hash::make(fake()->email()),
            'email_verified_at' => now()
        ]);

        // Create additional users
        User::factory()
            ->count(3)
            ->create();
    }
}