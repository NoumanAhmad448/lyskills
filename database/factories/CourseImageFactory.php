<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseImage>
 */
class CourseImageFactory extends Factory
{
    protected $model = CourseImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "course_id" => Course::factory()->create()->id,
            "image_path" => 'media/default-' . uniqid() . '.jpg',
            "image_name" => $this->faker->uuid() . '.jpg',
            "image_ex" => "jpg",
            "created_at" => now(),
            "updated_at" => now()

        ];
    }

    public function set_course($course_id)
    {
        return $this->state(function (array $attributes) use ($course_id) {
            return [
                'course_id' => $course_id
            ];
        });
    }
}
