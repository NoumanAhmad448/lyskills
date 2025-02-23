<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ReviewControllerTest extends TestCase
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
            'user_id' => $instructor->id
        ]);
    }

    /** @test */
    public function enrolled_student_can_leave_review()
    {
        $this->actingAs($this->student);

        $response = $this->post(route('reviews.store'), [
            'course_id' => $this->course->id,
            'rating' => 5,
            'review' => 'Excellent course!',
            'pros' => ['Great content', 'Clear explanations'],
            'cons' => ['Could have more exercises']
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'rating' => 5
        ]);
    }

    /** @test */
    public function student_can_update_review()
    {
        $this->actingAs($this->student);

        $review = Review::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->patch(route('reviews.update', $review), [
            'rating' => 4,
            'review' => 'Updated review content'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated review content', $review->fresh()->review);
    }

    /** @test */
    public function instructor_can_respond_to_review()
    {
        $instructor = User::factory()->create(['is_instructor' => 1]);
        $this->actingAs($instructor);

        $review = Review::factory()->create([
            'course_id' => $this->course->id
        ]);

        $response = $this->post(route('reviews.respond', $review), [
            'response' => 'Thank you for your feedback!'
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($review->fresh()->instructor_response);
    }

    /** @test */
    public function admin_can_moderate_reviews()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $this->actingAs($admin);

        $review = Review::factory()->create([
            'course_id' => $this->course->id,
            'is_approved' => false
        ]);

        $response = $this->patch(route('reviews.moderate', $review), [
            'is_approved' => true
        ]);

        $response->assertStatus(200);
        $this->assertTrue($review->fresh()->is_approved);
    }

    /** @test */
    public function review_requires_minimum_length()
    {
        $this->actingAs($this->student);

        $response = $this->post(route('reviews.store'), [
            'course_id' => $this->course->id,
            'rating' => 5,
            'review' => 'OK' // Too short
        ]);

        $response->assertStatus(422);
    }
} 