<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        $amount = $this->faker->randomFloat(2, 10, 200);
        
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'amount' => $amount,
            'payment_method' => $this->faker->randomElement(['stripe', 'paypal', 'bank']),
            'transaction_id' => $this->faker->uuid,
            'status' => 'completed',
            'currency' => 'USD',
            'payment_date' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending'
            ];
        });
    }

    public function failed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'failed'
            ];
        });
    }
} 