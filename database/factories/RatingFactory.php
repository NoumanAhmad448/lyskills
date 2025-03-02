<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = Rating::class;
    private $faker;

    public function __construct() {
    }

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'review' => fake()->paragraph(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function highRating()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(4, 5)
            ];
        });
    }

    public function lowRating()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(1, 2)
            ];
        });
    }
} 