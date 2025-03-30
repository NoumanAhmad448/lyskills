<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Post;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
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


    public function non_admin_cannot_access_admin_panel()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('a_home'));

        $response->assertRedirectToRoute("index");
    }

    /** @test */
    public function admin_can_view_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route('a_home'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_manage_courses()
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('change_course_status', $course), [
                'status' => 'p',
                "course_no" => $course->id
            ]);

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
            ->post(route('admin.user.update', $user->id), [
                'status' => 1
            ]);

        $response->assertStatus(200); // Ensure the request is successful

        $user = $user->fresh();
        if ($user->is_blocked == 0) {
            $this->fail('User is not blocked ' . $user);
        }
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
            ->post(route('admin_cs_p', $post), [
                'status' => 1
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'published'
        ]);
    }
}
