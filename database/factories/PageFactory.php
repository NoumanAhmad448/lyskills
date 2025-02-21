<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(5, true),
            'meta_description' => $this->faker->sentence(),
            'meta_keywords' => implode(',', $this->faker->words(5)),
            'status' => 'published',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
} 