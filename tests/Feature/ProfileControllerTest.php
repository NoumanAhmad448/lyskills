<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
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

        $response = $this->put(route('user-profile-information.update'), [
            'name' => 'John Updated',
            'bio' => 'New bio content',
            'website' => 'https://example.com',
            'twitter' => '@johnupdated'
        ]);

        $response->assertFound();
    }

    /** @test */
    public function user_can_update_profile_picture()
    {
        $this->actingAs($this->user);
        $this->get(route('i-profile'))->assertOk()->assertViewIs("lms::instructor.profile");
    }


    /** @test */
    public function instructor_can_update_profile()
    {
        $this->actingAs($this->user);
        $sentence = fake()->sentence(1);
        $response = $this->post(route('i-profile-post'), [
            'name' => 'John Updated',
            'headline' => "New headline",
            'bio' => $sentence
        ]);

        $response->assertFound();

        $this->assertDatabaseHas("profiles",[
            'headline' => "New headline",
            'bio' => $sentence,
            "user_id" => $this->user->id
        ]);

        $this->assertDatabaseHas("users",[
            'name' => 'John Updated',
        ]);
    }
}
