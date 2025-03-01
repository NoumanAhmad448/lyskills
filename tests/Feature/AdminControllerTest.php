<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Post;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'is_admin' => 1
        ]);
    }

    /** @test */
    public function non_admin_cannot_access_admin_panel()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function admin_can_manage_courses()
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.course.update', $course), [
                'status' => 'published'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'status' => 'published'
        ]);
    }

    /** @test */
    public function admin_can_manage_users()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.user.update', $user), [
                'is_blocked' => 1
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_blocked' => 1
        ]);
    }

    /** @test */
    public function admin_can_manage_posts()
    {
        $post = Post::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.post.update', $post), [
                'status' => 'published'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'published'
        ]);
    }
}