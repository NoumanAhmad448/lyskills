<?php

namespace Database\Factories;

use App\Models\AssignmentSubmition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssignmentSubmition>
 */
class AssignmentSubmitionFactory extends Factory
{
    protected $model = AssignmentSubmition::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "submission_file" => $this->faker->filePath(),
            "submission_file_name" => $this->faker->name(200),
            "is_late" => false,
            "score" => $this->faker->numberBetween(1,100),
            "feedback" => $this->faker->sentence(100),
            "comments" => $this->faker->paragraph(),
        ];
    }
}
