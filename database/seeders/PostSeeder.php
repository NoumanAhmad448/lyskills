<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
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
                    'email' => 'admin@lyskills.com'
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