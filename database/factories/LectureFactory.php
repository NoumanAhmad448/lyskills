<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecture>
 */
class LectureFactory extends Factory
{
    protected $model = Lecture::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "lec_name" => $this->faker->name(),
            "lec_no" => $this->faker->randomNumber(),
            "sec_no" => $this->faker->randomNumber(),
            "course_id" => Course::factory()->create()->id,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
