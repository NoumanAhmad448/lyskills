<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = \App\Models\Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->sentence,
            'user_id' => \App\Models\User::factory()->create()->id,
            'course_id' => \App\Models\Course::factory()->create(['status' => config("setting.course_status.published")])->id,
            "created_at" => dbDate(now()),
            "updated_at" => dbDate(now())
        ];
    }
}
