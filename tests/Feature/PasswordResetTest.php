<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_password_reset_request_form()
    {
        $response = $this->get(route('password.request'));
        
        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
    }

    /** @test */
    public function user_receives_email_with_password_reset_link()
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post(route('password.email'), [
            'email' => $user->email
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
        $response->assertSessionHas('status', trans('passwords.sent'));
    }

    /** @test */
    public function user_can_view_password_reset_form()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get(route('password.reset', $token));

        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password');
    }

    /** @test */
    public function user_can_reset_password_with_valid_token()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
        $response->assertSessionHas('status', trans('passwords.reset'));
    }

    /** @test */
    public function user_cannot_reset_password_with_invalid_token()
    {
        $user = User::factory()->create();

        $response = $this->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertFalse(Hash::check('newpassword123', $user->fresh()->password));
    }

    /** @test */
    public function user_cannot_reset_password_without_providing_new_password()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => ''
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cannot_reset_password_with_mismatch_password_confirmation()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'differentpassword'
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cannot_reset_password_with_invalid_email()
    {
        $response = $this->post(route('password.email'), [
            'email' => 'nonexistent@example.com'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function password_reset_token_expires_after_configured_time()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        // Simulate token expiration by modifying the token creation time
        // This might need adjustment based on your actual implementation
        $this->travel(config('auth.passwords.users.expire') + 1)->minutes();

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertSessionHasErrors('email');
    }
} 