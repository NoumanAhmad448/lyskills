<?php

namespace Tests\Feature;

use App\Classes\ResponseKeys;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group global-tests
 */
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
            ResponseKeys::STATUS => Course::PUBLISHED_STATUS
        ]);
    }

    /** @test */
    public function student_can_enroll_in_free_course()
    {
        $this->actingAs($this->student);

        $response = $this->post(route('enroll-now', [
            'course' => $this->course->id
        ]));

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHas("status");
        $this->assertDatabaseHas(config("table.course_enrollments"), [
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

        $response = $this->post(route('enroll-now',[
            'course' => $this->course->id
        ]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(config("table.course_enrollments"), [
                'user_id' => $this->student->id,
                'course_id' => $this->course->id
            ]);
        }

    /** @test */
    public function student_can_unenroll_from_course()
    {
        CourseEnrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $this->actingAs($this->student);

        $response = $this->deleteJson(route('un-enroll-now', $this->course->id));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing(config("table.course_enrollments"), [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function cannot_enroll_in_unpublished_course()
    {
        $this->course->update([ResponseKeys::STATUS => Course::COURSE_STATUS['draft']]);

        $this->actingAs($this->student);

        $response = $this->post(route('enroll-now', [
            'course' => $this->course->id
        ]));

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseMissing(config("table.course_enrollments"), [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);    }
}
