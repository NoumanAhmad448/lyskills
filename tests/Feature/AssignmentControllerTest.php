<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmition;
use App\Models\CourseEnrollment;
use App\Models\Lecture;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
class AssignmentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $student;
    protected $course;
    protected $assignment;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->instructor = User::factory()->create(['is_instructor' => 1]);
        $this->student = User::factory()->create();

        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $this->assignment = Assignment::factory()->create([
            'course_no' => $this->course->id
        ]);

        CourseEnrollment::factory()->create([
            "course_id" => $this->course->id,
            "user_id" => $this->student->id
        ]);

    }

    /** @test */
    public function instructor_can_create_assignment()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('assign', $this->course->id), [
            'ass_title' => 'Test Assignment',
            "lec_no" => Lecture::factory()->create([
                "course_id" => $this->course->id
            ])->id,
            'due_date' => now()->addDays(7),
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('assignments', [
            'course_no' => $this->course->id,
        ]);
    }

    /** @test */
    public function student_can_submit_assignment()
    {
        $this->actingAs($this->student);

        $file = UploadedFile::fake()->create('assignment.pdf', 500);

        $response = $this->post(route('assignments.submit', $this->assignment->id), [
            'submission_file' => $file,
            'comments' => 'Here is my submission',
            "course_id" => $this->course->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('assignments_submission', [
            'student_id' => $this->student->id,
            'assignment_id' => $this->assignment->id
        ]);
    }

    /** @test */
    public function instructor_can_grade_submission()
    {
        $this->actingAs($this->instructor);

        $submission = AssignmentSubmition::factory()->create([
            'assignment_id' => $this->assignment->id,
            "student_id" => $this->student->id
        ]);

        $response = $this->post(route('assignments.grade', $submission->id), [
            'score' => 85,
            'feedback' => 'Good work!'
        ]);

        $response->assertStatus(200);
        $this->assertEquals(85, $submission->fresh()->score);
    }

    /** @test */
    public function submission_is_marked_late_after_due_date()
    {
        $this->actingAs($this->student);

        $this->assignment->update([
            'due_date' => now()->subDays(1)
        ]);

        $file = UploadedFile::fake()->create('late.pdf', 500);

        $response = $this->post(route('assignments.submit', $this->assignment->id), [
            'submission_file' => $file,
            "course_id" => $this?->course?->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('assignments_submission', [
            'student_id' => $this->student->id,
            'assignment_id' => $this->assignment->id,
            'is_late' => true
        ]);
    }
}