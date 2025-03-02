<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Classes\Faker;

class UserSeeder extends Seeder
{
    private $faker;

    public function __construct() {
        $this->faker = new Faker();
    }
    public function run()
    {
        // Create admin user
        User::factory()->create([
            'name' => $this->faker->words(),
            'email' => $this->faker->email(),
            'password' => Hash::make($this->faker->words(10)),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

        // Create instructor
        User::factory()->create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make($this->faker->words(10)),
            'is_instructor' => true,
            'email_verified_at' => now()
        ]);

        // Create regular user
        User::factory()->create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make($this->faker->email()),
            'email_verified_at' => now()
        ]);

        // Create additional users
        User::factory()
            ->count(3)
            ->create();
    }
}