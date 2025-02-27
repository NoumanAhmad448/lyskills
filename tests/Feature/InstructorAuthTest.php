<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class InstructorAuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_can_view_instructor_register_page()
    {
        $response = $this->get(route('instructor.register'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.instructor.register');
    }

    /** @test */
    public function guest_can_view_instructor_login_page()
    {
        $response = $this->get(route('instructor.login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.instructor.login');
    }

    /** @test */
    public function instructor_cannot_register_without_captcha()
    {
        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'expertise' => 'Web Development',
            'teaching_experience' => 5,
            'qualification' => 'Masters in CS'
        ]);

        $response->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function instructor_cannot_login_without_captcha()
    {
        $response = $this->post(route('instructor.login'), [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function instructor_cannot_register_with_invalid_email()
    {
        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'expertise' => 'Web Development',
            'teaching_experience' => 5,
            'qualification' => 'Masters in CS',
            'g-recaptcha-response' => 'test-token'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function instructor_cannot_register_with_weak_password()
    {
        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'test@example.com',
            'password' => '123', // too short
            'password_confirmation' => '123',
            'expertise' => 'Web Development',
            'teaching_experience' => 5,
            'qualification' => 'Masters in CS',
            'g-recaptcha-response' => 'test-token'
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function instructor_cannot_register_with_mismatched_passwords()
    {
        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
            'expertise' => 'Web Development',
            'teaching_experience' => 5,
            'qualification' => 'Masters in CS',
            'g-recaptcha-response' => 'test-token'
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function instructor_cannot_register_with_existing_email()
    {
        // Create a user first
        User::factory()->create(['email' => 'test@example.com']);

        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'test@example.com', // same email
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'expertise' => 'Web Development',
            'teaching_experience' => 5,
            'qualification' => 'Masters in CS',
            'g-recaptcha-response' => 'test-token'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function instructor_cannot_login_with_invalid_credentials()
    {
        $response = $this->post(route('instructor.login'), [
            'email' => 'nonexistent@example.com',
            'password' => 'wrong-password',
            'g-recaptcha-response' => 'test-token'
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function regular_user_cannot_login_as_instructor()
    {
        // Create regular user
        $user = User::factory()->create([
            'is_instructor' => 0
        ]);

        $response = $this->post(route('instructor.login'), [
            'email' => $user->email,
            'password' => 'password',
            'g-recaptcha-response' => 'test-token'
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function logged_in_instructor_is_redirected_from_register()
    {
        $instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $response = $this->actingAs($instructor)
            ->get(route('instructor.register'));

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function logged_in_instructor_is_redirected_from_login()
    {
        $instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $response = $this->actingAs($instructor)
            ->get(route('instructor.login'));

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function remember_me_functionality_works()
    {
        $instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $response = $this->post(route('instructor.login'), [
            'email' => $instructor->email,
            'password' => 'password',
            'remember' => 'on',
            'g-recaptcha-response' => 'test-token'
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertNotNull($this->app['cookie']->get('remember_web'));
    }

    /** @test */
    public function instructor_registration_creates_verified_user()
    {
        $response = $this->post(route('instructor.register'), [
            'name' => 'Test Instructor',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'expertise' => 'Web Development',
            'teaching_experience' => 5,
            'qualification' => 'Masters in CS',
            'g-recaptcha-response' => 'test-token'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'is_instructor' => 1,
            'email_verified_at' => now()
        ]);
    }
} 