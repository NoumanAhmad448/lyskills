<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class EnrollmentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $student;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->student = User::factory()->create();
        $instructor = User::factory()->create(['is_instructor' => 1]);
        
        $this->course = Course::factory()->create([
            'user_id' => $instructor->id,
            'status' => 'published'
        ]);
    }

    /** @test */
    public function student_can_enroll_in_free_course()
    {
        $this->actingAs($this->student);

        $response = $this->post(route('enrollment.store'), [
            'course_id' => $this->course->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('course_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function student_cannot_enroll_twice()
    {
        CourseEnrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $this->actingAs($this->student);

        $response = $this->post(route('enrollment.store'), [
            'course_id' => $this->course->id
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function student_can_unenroll_from_course()
    {
        CourseEnrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $this->actingAs($this->student);

        $response = $this->delete(route('enrollment.destroy', $this->course->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('course_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function cannot_enroll_in_unpublished_course()
    {
        $this->course->update(['status' => 'draft']);
        
        $this->actingAs($this->student);

        $response = $this->post(route('enrollment.store'), [
            'course_id' => $this->course->id
        ]);

        $response->assertStatus(404);
    }
} 