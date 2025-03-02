<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Classes\Faker;

class PostSeeder extends Seeder
{
    private $faker;
    public function __construct() {
        $this->faker = new Faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get admin user or create one if doesn't exist
        $admin = User::where('is_admin', true)->first() ??
                User::factory()->create([
                    'is_admin' => true,
                    'email' => $this->faker->email()
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