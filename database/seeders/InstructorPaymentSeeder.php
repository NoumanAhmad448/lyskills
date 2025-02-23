<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\InstructorEarning;
use App\Models\CourseHistory;
use App\Models\InstructorAnn;
use App\Models\MonthlyPaymentModel;
use Illuminate\Database\Seeder;

class InstructorPaymentSeeder extends Seeder
{
    public function run()
    {
        // Create instructors
        $instructors = User::factory()->count(5)->create([
            'is_instructor' => 1,
            'is_admin' => null,
            'is_blogger' => null,
            'is_super_admin' => null
        ]);

        // Create courses for each instructor
        $instructors->each(function ($instructor) {
            $courses = Course::factory()->count(3)->create([
                'user_id' => $instructor->id
            ]);

            // Create earnings for each course
            $courses->each(function ($course) use ($instructor) {
                InstructorEarning::factory()->count(5)->create([
                    'ins_id' => $instructor->id,
                    'course_id' => $course->id
                ]);

                // Create course purchase history
                CourseHistory::factory()->count(3)->create([
                    'course_id' => $course->id,
                    'ins_id' => $instructor->id
                ]);
            });

            // Create monthly payments
            for ($month = 1; $month <= 12; $month++) {
                MonthlyPaymentModel::factory()->create([
                    'user_id' => $instructor->id,
                    'month' => $month
                ]);
            }
        });

        // Create instructor announcements
        InstructorAnn::factory()->count(10)->create();
    }
} 