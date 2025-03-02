<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class CourseFactory extends Factory
{
    protected $model = Course::class;
    private $faker;
    public function __construct() {
    }

    public function definition()
    {
        $title = fake()->sentence(2);
        return [
            'course_title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraphs(),
            'user_id' => User::factory(),
            'categories_selection' => Categories::factory(),
            'c_level' => fake()->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'status' => 'published',
            'is_draft' => false,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
                'is_draft' => true
            ];
        });
    }
}