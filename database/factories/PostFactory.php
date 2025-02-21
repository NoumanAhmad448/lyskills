<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'message' => $this->faker->paragraphs(3, true),
            'user_id' => User::factory(),
            'status' => 'published',
            'upload_img' => 'posts/default.jpg',
            'f_name' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft'
            ];
        });
    }
} 