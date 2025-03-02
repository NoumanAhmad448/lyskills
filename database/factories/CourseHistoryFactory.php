<?php

namespace Database\Factories;

use App\Models\CourseHistory;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseHistoryFactory extends Factory
{
    protected $model = CourseHistory::class;
    private $faker;
    public function __construct() {
    }


    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'ins_id' => User::factory()->create(['is_instructor' => 1])->id,
            'user_id' => User::factory(),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'pay_method' => fake()->randomElement(['stripe', 'paypal', 'bank_transfer']),
            'created_at' => fake()->dateTimeBetween('-1 year')
        ];
    }
} 