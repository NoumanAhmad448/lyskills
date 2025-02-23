<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run()
    {
        // Get enrolled students for each course
        Course::with('enrollments.user')->each(function ($course) {
            // 70% of enrolled students leave a rating
            $course->enrollments->each(function ($enrollment) use ($course) {
                if (rand(1, 100) <= 70) {
                    Rating::factory()->create([
                        'user_id' => $enrollment->user_id,
                        'course_id' => $course->id
                    ]);
                }
            });
        });

        // Create some high ratings
        Rating::factory()
            ->count(10)
            ->highRating()
            ->create();

        // Create some low ratings
        Rating::factory()
            ->count(5)
            ->lowRating()
            ->create();
    }
} 