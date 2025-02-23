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
            'course_id' => Course::factory(),
            'earning' => $this->faker->randomFloat(2, 10, 1000),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now')
        ];
    }
} 