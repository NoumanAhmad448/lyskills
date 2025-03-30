<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
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
            'user_id' => $instructor->id,
            "status" => config("setting.course_status.published")
        ]);
    }

    /** @test */
    public function enrolled_student_can_comment()
    {
        $this->actingAs($this->user);
        $message = $this->faker->sentence;
        $response = $this->post(route('laoshi-commentPost'), [
            'course_slug' => $this->course->id,
            'message' =>  $message
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'comment' => $message
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

        $response = $this->patch(route('laoshi-commentUpdate'), [
            "comm_id" => $comment->id,
            'new_msg' => 'Updated comment'
        ]);

        $response->assertStatus(302);
        $this->assertEquals('Updated comment', $comment->fresh()->comment);
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

        $response = $this->patch(route('laoshi-commentUpdate', $comment), [
            'new_msg' => 'Trying to update'
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

        $response = $this->post(route('laoshi-commentDelete'), [
            'message_id' => $comment->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
