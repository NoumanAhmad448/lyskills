<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
class BlogControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $blogger;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->blogger = User::factory()->create(['is_blogger' => 1]);
        $this->admin = User::factory()->create(['is_admin' => 1]);
        Setting::factory()->create();
    }

    /** @test */
    public function blogger_can_create_post()
    {
        $this->actingAs($this->blogger);

        $thumbnail = UploadedFile::fake()->image('post.jpg');
        $title = fake()->title();

        $response = $this->post(route('blogger_s_p'), [
            'title' => $title,
            'message' => "\n\n" . fake()->sentence(4),
            'upload_img' => $thumbnail,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', [
            'title' => $title,
            'status' => 'unpublished',
            'email' => $this->blogger->email
        ]);
    }

    /** @test */
    public function blogger_can_update_post()
    {
        $this->actingAs($this->blogger);

        $post = Post::factory()->create([
            'email' => $this->blogger->email
        ]);

        $new_title = fake()->title();
        $response = $this->put(route('blogger_update_p', $post->id), [
            'title' =>  $new_title,
            'message' => fake()->paragraph(4),
        ]);

        $response->assertStatus(302);
        $this->assertEquals($new_title, $post->fresh()->title);
    }

    /** @test */
    public function blogger_can_change_status()
    {
        $this->actingAs($this->blogger);

        $post = Post::factory()->create([
            'email' => $this->blogger->email
        ]);

        $response = $this->post(route('blogger_cs_p', $post->id), [
            'status' => 'published'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', [
            'status' => "published"
        ]);
    }

    /** @test */
    public function blogger_cannot_delete_post()
    {
        $this->actingAs($this->blogger);

        $post = Post::factory()->create([
            'email' => $this->blogger->email
        ]);

        $response = $this->delete(route('blogger_p_delete', $post->id));

        $response->assertStatus(403);
    }
    public function admin_can_delete_post()
    {

        $this->actingAs($this->admin);

        $thumbnail = UploadedFile::fake()->image('post.jpg');

        $post = Post::factory()->create([
            "upload_img" => $thumbnail
        ]);

        $response = $this->delete(route('blogger_p_delete', $post->id));

        $response->assertStatus(403);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id
        ]);
    }
}
