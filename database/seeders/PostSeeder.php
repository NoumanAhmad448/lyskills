<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

use Faker\Factory;

class PostSeeder extends Seeder
{
    private $faker;
    public function __construct() {
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        $fakeEmail = $faker->unique()->email;
        echo $fakeEmail; // Outputs something like "john.doe@example.com"
        // Get admin user or create one if doesn't exist

        $admin = User::where('is_admin', true)->first() ??
                User::factory()->create([
                    'is_admin' => true,
                    'email' => fake()->email()
                ]);

        // Create published posts
        Post::factory()
            ->count(5)
            ->create([
                'email' => $admin->email,
                'status' => 'published'
            ]);

        // Create featured posts
        Post::factory()
            ->count(2)
            ->create([
                'email' => $admin->email,
                'status' => 'published',
                'title' => 'Featured: ' . fake()->sentence(),
            ]);
    }
}