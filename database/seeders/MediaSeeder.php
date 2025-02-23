<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Course;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        Course::all()->each(function ($course) {
            // Create preview video
            Media::factory()
                ->preview()
                ->create([
                    'course_id' => $course->id
                ]);

            // Create regular videos
            Media::factory()
                ->count(5)
                ->create([
                    'course_id' => $course->id
                ]);

            // Create some images
            Media::factory()
                ->image()
                ->count(2)
                ->create([
                    'course_id' => $course->id
                ]);
        });
    }
} 