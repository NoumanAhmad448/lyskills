<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "lecture_id" => $this->faker->randomDigit(),
            "title" => $this->faker->sentence(),
            "course_no" => $this->faker->randomDigit(),
            "ass_f_name" => $this->faker->word(),
            "ass_f_path" => $this->faker->filePath(),
            "ass_no" => $this->faker->randomDigit()
        ];
    }
}
