<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Revenue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AnalyticsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->instructor = User::factory()->create(['is_instructor' => 1]);
        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);
    }

    /** @test */
    public function instructor_can_view_course_analytics()
    {
        $this->actingAs($this->instructor);

        // Create some enrollments
        CourseEnrollment::factory()->count(5)->create([
            'course_id' => $this->course->id
        ]);

        $response = $this->get(route('analytics.course', $this->course));

        $response->assertStatus(200);
        $response->assertViewHas([
            'total_students',
            'completion_rate',
            'average_rating',
            'revenue'
        ]);
    }

    /** @test */
    public function instructor_can_view_revenue_analytics()
    {
        $this->actingAs($this->instructor);

        Revenue::factory()->count(3)->create([
            'instructor_id' => $this->instructor->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->get(route('analytics.revenue'));

        $response->assertStatus(200);
        $response->assertViewHas([
            'total_revenue',
            'monthly_revenue',
            'revenue_by_course'
        ]);
    }

    /** @test */
    public function instructor_can_export_analytics()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('analytics.export'), [
            'type' => 'revenue',
            'date_range' => 'last_month',
            'format' => 'csv'
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv');
    }

    /** @test */
    public function instructor_can_view_student_engagement()
    {
        $this->actingAs($this->instructor);

        $response = $this->get(route('analytics.engagement', $this->course));

        $response->assertStatus(200);
        $response->assertViewHas([
            'video_completion_rate',
            'assignment_submission_rate',
            'quiz_participation_rate'
        ]);
    }

    /** @test */
    public function instructor_can_view_geographic_distribution()
    {
        $this->actingAs($this->instructor);

        $response = $this->get(route('analytics.geography', $this->course));

        $response->assertStatus(200);
        $response->assertViewHas([
            'students_by_country',
            'students_by_region'
        ]);
    }
} 