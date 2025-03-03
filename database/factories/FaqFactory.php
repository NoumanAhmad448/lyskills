<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition()
    {
        $title = $this->faker->title();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'message' => implode("\n\n", $this->faker->paragraphs(3)), // ✅ Convert array to string
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