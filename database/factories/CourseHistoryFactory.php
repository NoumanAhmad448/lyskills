<?php

namespace Database\Factories;

use App\Models\CourseHistory;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseHistoryFactory extends Factory
{
    protected $model = CourseHistory::class;
   


    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'ins_id' => User::factory()->create(['is_instructor' => 1])->id,
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'pay_method' => $this->faker->randomElement(['stripe', 'paypal', 'bank_transfer']),
            'created_at' => $this->faker->dateTimeBetween('-1 year')
        ];
    }
} 