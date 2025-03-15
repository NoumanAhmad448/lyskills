<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Course;
use App\Models\RatingModal;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = RatingModal::class;


    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function highRating()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(4, 5)
            ];
        });
    }

    public function lowRating()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(1, 2)
            ];
        });
    }
}
