<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\CourseProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ProgressControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $student;
    protected $course;
    protected $lecture;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->student = User::factory()->create();
        $instructor = User::factory()->create(['is_instructor' => 1]);
        
        $this->course = Course::factory()->create([
            'user_id' => $instructor->id
        ]);

        $this->lecture = Lecture::factory()->create([
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function student_can_mark_lecture_as_completed()
    {
        $this->actingAs($this->student);

        $response = $this->post(route('progress.mark-complete'), [
            'lecture_id' => $this->lecture->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('course_progress', [
            'user_id' => $this->student->id,
            'lecture_id' => $this->lecture->id,
            'completed' => true
        ]);
    }

    /** @test */
    public function student_can_track_overall_course_progress()
    {
        $this->actingAs($this->student);

        // Create multiple lectures
        $lectures = Lecture::factory()->count(4)->create([
            'course_id' => $this->course->id
        ]);

        // Mark some lectures as complete
        foreach($lectures->take(2) as $lecture) {
            CourseProgress::create([
                'user_id' => $this->student->id,
                'lecture_id' => $lecture->id,
                'completed' => true
            ]);
        }

        $response = $this->get(route('progress.show', $this->course));

        $response->assertStatus(200);
        $response->assertViewHas('progress_percentage', 50);
    }

    /** @test */
    public function student_can_resume_course()
    {
        $this->actingAs($this->student);

        $lastViewedLecture = Lecture::factory()->create([
            'course_id' => $this->course->id
        ]);

        CourseProgress::create([
            'user_id' => $this->student->id,
            'lecture_id' => $lastViewedLecture->id,
            'last_viewed_at' => now()
        ]);

        $response = $this->get(route('progress.resume', $this->course));

        $response->assertStatus(302);
        $response->assertRedirect(route('lectures.show', $lastViewedLecture));
    }

    /** @test */
    public function progress_is_synced_across_devices()
    {
        $this->actingAs($this->student);

        $response = $this->post(route('progress.sync'), [
            'lecture_id' => $this->lecture->id,
            'timestamp' => 300, // 5 minutes into video
            'device_id' => 'device_123'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('course_progress', [
            'user_id' => $this->student->id,
            'lecture_id' => $this->lecture->id,
            'timestamp' => 300
        ]);
    }
} 