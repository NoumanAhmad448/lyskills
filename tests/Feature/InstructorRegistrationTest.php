<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;

class InstructorRegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function welcome_page_has_become_instructor_section()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Become An Instructor');
        $response->assertSee('Start Teaching Now');
    }

    /** @test */
    public function instructor_link_redirects_to_registration()
    {
        $response = $this->get('/');
        
        $response->assertSee(route('instructor.register'));
    }

    /** @test */
    public function instructor_registration_page_shows_correct_form()
    {
        $response = $this->get(route('instructor.register'));

        $response->assertStatus(200);
        $response->assertSee(__('instructor.fields.expertise'));
        $response->assertSee(__('instructor.fields.teaching_experience'));
        $response->assertSee(__('instructor.fields.qualification'));
    }

    /** @test */
    public function can_register_as_instructor()
    {
        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'instructor@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'expertise' => 'Web Development',
            'teaching_experience' => 5,
            'qualification' => 'Masters in Computer Science'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'instructor@test.com',
            'is_instructor' => 1
        ]);

        $response->assertRedirect(route('instructor.dashboard'));
    }

    /** @test */
    public function registration_requires_all_instructor_fields()
    {
        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'instructor@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // Missing required instructor fields
        ]);

        $response->assertSessionHasErrors(['expertise', 'teaching_experience', 'qualification']);
    }

    /** @test */
    public function logged_in_user_cannot_access_instructor_registration()
    {
        // Create and login a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Try to access registration page
        $response = $this->get(route('instructor.register'));

        // Should redirect to dashboard
        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function logged_in_user_cannot_access_instructor_login()
    {
        // Create and login a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Try to access login page
        $response = $this->get(route('instructor.login'));

        // Should redirect to dashboard
        $response->assertRedirect(route('dashboard'));
    }
} 