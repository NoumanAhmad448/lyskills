<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
class ShareControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();

        $this->instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);
    }

    /** @test */
    public function share_course_link()
    {
        $response = $this->get(route("user-course", ["slug" => $this->course->slug]));
        $response->assertSee("Share");
    }
    /** @test */
    public function disabled_share()
    {
        config(["setting.course_desc_share_btn" => false]);
        $response = $this->get(route("user-course", ["slug" => $this->course->slug]));
        $response->assertViewMissing("Share");
    }
}
