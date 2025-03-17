<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Course;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{

    private $need_course_image = true;
    private $need_course_video = true;

    public function run()
    {
        Course::all()->each(function ($course) {
            // Create preview video
            $media = Media::factory()
                ->set_lecture($course->id);
            if ($this->need_course_video) {
                $media->set_course_video($course->id);
            }
            if ($this->need_course_image) {
                $media->set_course_image($course->id);
            }
            $media->count(5)
                ->create([
                    'course_id' => $course->id
                ]);
        });
    }
}
