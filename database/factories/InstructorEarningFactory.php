<?php

namespace Database\Factories;

use App\Models\InstructorEarning;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorEarningFactory extends Factory
{
    private $faker;
    protected $model = InstructorEarning::class;

    public function __construct() {
    }

    public function definition()
    {
        return [
            'ins_id' => User::factory()->create(['is_instructor' => 1])->id,
            'course_id' => Course::factory(),
            'earning' => fake()->randomFloat(2, 10, 1000),
            'created_at' => fake()->dateTimeBetween('-6 months')
        ];
    }
} 