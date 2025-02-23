<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_view_notifications()
    {
        $this->actingAs($this->user);

        Notification::factory()->count(3)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get(route('notifications.index'));

        $response->assertStatus(200);
        $response->assertViewHas('notifications');
    }

    /** @test */
    public function user_can_mark_notification_as_read()
    {
        $this->actingAs($this->user);

        $notification = Notification::factory()->create([
            'user_id' => $this->user->id,
            'read_at' => null
        ]);

        $response = $this->patch(route('notifications.mark-as-read', $notification));

        $response->assertStatus(200);
        $this->assertNotNull($notification->fresh()->read_at);
    }

    /** @test */
    public function user_can_mark_all_notifications_as_read()
    {
        $this->actingAs($this->user);

        Notification::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'read_at' => null
        ]);

        $response = $this->post(route('notifications.mark-all-as-read'));

        $response->assertStatus(200);
        $this->assertEquals(0, Notification::where('user_id', $this->user->id)
                                         ->whereNull('read_at')
                                         ->count());
    }
} 