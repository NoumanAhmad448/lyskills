<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $blogger;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->blogger = User::factory()->create(['is_blogger' => 1]);
    }

    /** @test */
    public function blogger_can_create_post()
    {
        $this->actingAs($this->blogger);

        $thumbnail = UploadedFile::fake()->image('post.jpg');

        $response = $this->post(route('blog.store'), [
            'title' => 'Test Blog Post',
            'content' => 'This is a test blog post content',
            'thumbnail' => $thumbnail,
            'tags' => ['education', 'technology'],
            'status' => 'published'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Blog Post',
            'user_id' => $this->blogger->id
        ]);
    }

    /** @test */
    public function blogger_can_update_post()
    {
        $this->actingAs($this->blogger);

        $post = Post::factory()->create([
            'user_id' => $this->blogger->id
        ]);

        $response = $this->patch(route('blog.update', $post), [
            'title' => 'Updated Title',
            'content' => 'Updated content'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Title', $post->fresh()->title);
    }

    /** @test */
    public function users_can_comment_on_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create([
            'status' => 'published'
        ]);

        $response = $this->post(route('blog.comments.store', $post), [
            'content' => 'Great post!'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
    }

    /** @test */
    public function blogger_can_moderate_comments()
    {
        $this->actingAs($this->blogger);

        $post = Post::factory()->create([
            'user_id' => $this->blogger->id
        ]);

        $comment = Comment::factory()->create([
            'post_id' => $post->id
        ]);

        $response = $this->delete(route('blog.comments.destroy', $comment));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /** @test */
    public function can_filter_posts_by_tag()
    {
        Post::factory()->create([
            'tags' => ['education'],
            'status' => 'published'
        ]);

        Post::factory()->create([
            'tags' => ['technology'],
            'status' => 'published'
        ]);

        $response = $this->get('/blog?tag=education');

        $response->assertStatus(200);
        $response->assertSee('education');
        $response->assertDontSee('technology');
    }
} 