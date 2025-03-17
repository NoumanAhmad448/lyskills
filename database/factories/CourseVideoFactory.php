<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseVideo>
 */
class CourseVideoFactory extends Factory
{
    protected $model = CourseVideo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "course_id" => Course::factory()->create()->id,
            "vid_path" => 'media/default-' . uniqid() . '.mp4',
            "video_name" => $this->faker->uuid() . '.mp4',
            "video_type" => "video/mp4",
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
