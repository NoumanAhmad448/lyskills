<?php

namespace Database\Factories;

use App\Models\CronJobs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CronJobs>
 */
class CronJobsFactory extends Factory
{
    protected $model = CronJobs::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "w_name" => $this->faker->name(),
            "status" => $this->faker->randomElement([
                "idle",
                "successed",
                "error",
            ]),
            "message" => $this->faker->sentence(),
            "starts_at" => $this->faker->dateTimeBetween("-1 month", "now"),
            "ends_at" => $this->faker->dateTimeBetween("now", "+1 month"),
        ];
    }
}
