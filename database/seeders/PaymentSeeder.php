<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;  // Import the Faker Factory class

class PaymentSeeder extends Seeder
{
    public function __construct() {
        $this->faker = Faker::create();  // Manually instantiate the Faker object

    }
    public function run()
    {
        // Get all students
        $students = User::where('is_student', true)->get();
        
        // Get all courses
        $courses = Course::all();

        // Create successful payments
        $students->each(function ($student) use ($courses) {
            $courses->random(rand(1, 3))->each(function ($course) use ($student) {
                Payment::factory()->create([
                    'user_id' => $student->id,
                    'course_id' => $course->id
                ]);
            });
        });

        // Create some pending payments
        Payment::factory()
            ->count(5)
            ->pending()
            ->create();

        // Create some failed payments
        Payment::factory()
            ->count(3)
            ->failed()
            ->create();
    }
} 