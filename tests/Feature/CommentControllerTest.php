<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $instructor = User::factory()->create(['is_instructor' => 1]);
        
        $this->course = Course::factory()->create([
            'user_id' => $instructor->id
        ]);
    }

    /** @test */
    public function enrolled_student_can_comment()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('comments.store'), [
            'course_id' => $this->course->id,
            'content' => 'Great course!'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'content' => 'Great course!'
        ]);
    }

    /** @test */
    public function user_can_edit_own_comment()
    {
        $this->actingAs($this->user);

        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->patch(route('comments.update', $comment), [
            'content' => 'Updated comment'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated comment', $comment->fresh()->content);
    }

    /** @test */
    public function user_cannot_edit_others_comment()
    {
        $otherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'course_id' => $this->course->id
        ]);

        $this->actingAs($this->user);

        $response = $this->patch(route('comments.update', $comment), [
            'content' => 'Trying to update'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function instructor_can_delete_any_comment()
    {
        $instructor = User::factory()->create(['is_instructor' => 1]);
        $this->actingAs($instructor);

        $comment = Comment::factory()->create([
            'course_id' => $this->course->id
        ]);

        $response = $this->delete(route('comments.destroy', $comment));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
} 