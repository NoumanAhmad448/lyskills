<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_update_profile()
    {
        $this->actingAs($this->user);

        $response = $this->patch(route('profile.update'), [
            'name' => 'John Updated',
            'bio' => 'New bio content',
            'website' => 'https://example.com',
            'twitter' => '@johnupdated'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('John Updated', $this->user->fresh()->name);
    }

    /** @test */
    public function user_can_update_profile_picture()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post(route('profile.update.picture'), [
            'avatar' => $file
        ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }

    /** @test */
    public function user_can_change_password()
    {
        $this->actingAs($this->user);
        $currentPassword = 'current123';
        $newPassword = 'new123456';

        $this->user->update([
            'password' => Hash::make($currentPassword)
        ]);

        $response = $this->post(route('profile.password.update'), [
            'current_password' => $currentPassword,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]);

        $response->assertStatus(200);
        $this->assertTrue(Hash::check($newPassword, $this->user->fresh()->password));
    }

    /** @test */
    public function user_cannot_change_password_with_incorrect_current_password()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('profile.password.update'), [
            'current_password' => 'wrong_password',
            'password' => 'new_password',
            'password_confirmation' => 'new_password'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function user_can_update_notification_preferences()
    {
        $this->actingAs($this->user);

        $response = $this->patch(route('profile.notifications.update'), [
            'email_notifications' => false,
            'course_updates' => true,
            'marketing_emails' => false
        ]);

        $response->assertStatus(200);
        $this->assertFalse($this->user->fresh()->email_notifications);
    }
} 