<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Share;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ShareControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);
    }

    /** @test */
    public function instructor_can_share_course()
    {
        $this->actingAs($this->instructor);
        
        $response = $this->post(route('share.course'), [
            'course_id' => $this->course->id,
            'platform' => 'facebook',
            'share_url' => 'https://facebook.com/share/123'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('shares', [
            'course_id' => $this->course->id,
            'platform' => 'facebook'
        ]);
    }

    /** @test */
    public function non_instructor_cannot_share_course()
    {
        $user = User::factory()->create(['is_instructor' => 0]);
        $this->actingAs($user);

        $response = $this->post(route('share.course'), [
            'course_id' => $this->course->id,
            'platform' => 'facebook'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function share_requires_valid_platform()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('share.course'), [
            'course_id' => $this->course->id,
            'platform' => 'invalid_platform'
        ]);

        $response->assertSessionHasErrors('platform');
    }
} 