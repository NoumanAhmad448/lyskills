<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\InstructorEarning;
use App\Models\CourseHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class InstructorEarningTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        $this->markTestSkipped('This entire test class is skipped.');

        
        $this->instructor = User::factory()->create(['is_instructor' => 1]);
        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);
    }

    /** @test */
    public function instructor_can_view_earnings()
    {
        $this->actingAs($this->instructor);

        InstructorEarning::factory()->count(3)->create([
            'ins_id' => $this->instructor->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->get(route('instructor.earnings'));

        $response->assertStatus(200);
        $response->assertViewHas([
            'total_earnings',
            'monthly_earnings',
            'pending_payments'
        ]);
    }

    /** @test */
    public function instructor_can_view_earning_details()
    {
        $this->actingAs($this->instructor);

        $courseHistory = CourseHistory::factory()->create([
            'ins_id' => $this->instructor->id,
            'course_id' => $this->course->id,
            'amount' => 99.99
        ]);

        $response = $this->get(route('instructor.earning.details', $courseHistory));

        $response->assertStatus(200);
        $response->assertViewHas('transaction');
        $response->assertSee('99.99');
    }

    /** @test */
    public function instructor_can_filter_earnings_by_date()
    {
        $this->actingAs($this->instructor);

        // Create earnings for different dates
        InstructorEarning::factory()->create([
            'ins_id' => $this->instructor->id,
            'created_at' => now()->subMonths(2)
        ]);

        InstructorEarning::factory()->create([
            'ins_id' => $this->instructor->id,
            'created_at' => now()
        ]);

        $response = $this->get(route('instructor.earnings', [
            'start_date' => now()->subMonth()->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d')
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('earnings');
        // Should only show 1 earning within date range
        $this->assertEquals(1, $response->viewData('earnings')->count());
    }

    /** @test */
    public function instructor_cannot_view_other_instructors_earnings()
    {
        $this->actingAs($this->instructor);

        $otherInstructor = User::factory()->create(['is_instructor' => 1]);
        $earning = InstructorEarning::factory()->create([
            'ins_id' => $otherInstructor->id
        ]);

        $response = $this->get(route('instructor.earning.details', $earning));

        $response->assertStatus(403);
    }
} 