<?php

namespace Database\Factories;

use App\Classes\LyskillsCarbon;
use App\Models\Media;
use App\Models\Course;
use App\Models\CourseImage;
use App\Models\CourseVideo;
use App\Models\Lecture;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    protected $model = Media::class;


    public function definition()
    {
        $lecture = Lecture::factory()->create();
        return [
            'course_id' => Course::factory(),
            'f_name' => $this->faker->uuid() . '.mp4',
            'f_mimetype' => "video/mp4",
            'duration' => $this->faker->numberBetween(300, 3600), // 5-60 minutes
            'created_at' => now(),
            'updated_at' => now(),
            "time_in_mili" => $this->faker->numberBetween(300, 3600),
            "is_free" => $this->faker->boolean(),
            "is_download" => $this->faker->boolean(),
            "access_duration" => LyskillsCarbon::now()->addDays($this->faker->numberBetween(1, 30)),
            "lecture_id" => $lecture->id,
            "lec_name" => "uploads/".$this->faker->name()

        ];
    }

    public function free()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_free' => true
            ];
        });
    }

    public function is_download()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_download' => true
            ];
        });
    }
    public function set_lecture($course_id)
    {
        return $this->state(function (array $attributes) use ($course_id) {
            $lecture = Lecture::factory()->create([
                'course_id' => $course_id
            ]);
            return [
                'lecture_id' => $lecture->id
            ];
        });
    }
    public function set_course_video($course_id)
    {
        CourseVideo::factory()->create([
            'course_id' => $course_id
        ]);
    }
    public function set_course_image($course_id)
    {
        CourseImage::factory()->create([
            'course_id' => $course_id
        ]);
    }
}
