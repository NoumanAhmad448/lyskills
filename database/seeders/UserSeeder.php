<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@lyskills.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

        // Create instructor
        User::factory()->create([
            'name' => 'Test Instructor',
            'email' => 'instructor@lyskills.com',
            'password' => Hash::make('password'),
            'is_instructor' => true,
            'email_verified_at' => now()
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@lyskills.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        // Create additional users
        User::factory()
            ->count(3)
            ->create();
    }
} 