<?php

namespace Database\Factories;

use App\Models\MonthlyPaymentModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyPaymentModelFactory extends Factory
{
    protected $model = MonthlyPaymentModel::class;
    private $faker;
    public function __construct() {
    }

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['is_instructor' => 1])->id,
            'month' => fake()->numberBetween(1, 12),
            'payment' => fake()->randomFloat(2, 100, 5000),
            'created_at' => fake()->dateTimeBetween('-1 year')
        ];
    }
} 