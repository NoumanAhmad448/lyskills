<?php

namespace Database\Factories;

use App\Models\MonthlyPaymentModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyPaymentModelFactory extends Factory
{
    protected $model = MonthlyPaymentModel::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['is_instructor' => 1])->id,
            'month' => $this->faker->numberBetween(1, 12),
            'payment' => $this->faker->randomFloat(2, 100, 5000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
} 