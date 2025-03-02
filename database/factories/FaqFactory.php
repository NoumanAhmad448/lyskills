<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FaqFactory extends Factory
{
    protected $model = Faq::class;
    private $faker;
    public function __construct() {
    }
    public function definition()
    {
        $title = fake()->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'message' => fake()->paragraphs(),
            'email' => User::factory()->create()->email,
            'status' => 'published',
            'upload_img' => 'faqs/default.jpg',
            'f_name' => 'default.jpg',
            'is_published' => true,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}