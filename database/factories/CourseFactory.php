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

    public function definition()
    {
        $title = $this->faker->sentence(1);
        return [
            'course_title' => $title,
            'slug' => Str::slug($title),
            'description' => implode("\n\n",$this->faker->paragraphs()),
            'user_id' => User::factory(),
            'categories_selection' => Categories::factory(),
            'c_level' => $this->faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
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