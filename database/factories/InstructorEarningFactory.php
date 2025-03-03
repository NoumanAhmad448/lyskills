<?php

namespace Database\Factories;

use App\Models\InstructorEarning;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorEarningFactory extends Factory
{
    protected $model = InstructorEarning::class;

    public function definition()
    {
        return [
            'ins_id' => User::factory()->create(['is_instructor' => 1])->id,
            'user_id' => User::factory()->create(['is_student' => 1])->id,
            'course_id' => Course::factory(),
            'earning' => fake()->randomFloat(2, 10, 1000),
            'created_at' => fake()->dateTimeBetween('-6 months')
        ];
    }
} 