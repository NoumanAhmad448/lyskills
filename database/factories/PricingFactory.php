<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Pricing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PricingFactory extends Factory
{
    protected $model = Pricing::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "course_id" => Course::factory()->create()->id,
            "pricing" => $this->faker->randomDigit(),
            "is_free" => false,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
