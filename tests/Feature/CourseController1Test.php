<?php

namespace Tests\Feature;

use App\Models\Categories;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\View;
use App\Models\Pricing;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/**
 * @group global-tests
 */

class CourseController1Test extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $student;
    protected $admin;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $this->student = User::factory()->create();
        $this->admin = User::factory()->create([
            'is_admin' => 1
        ]);

        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);
    }
    /** @test */
    public function instructor_can_view_price_page()
    {
        $this->actingAs($this->instructor);
        $response = $this->get(route('pricing', ["course" => $this->course?->id]));
        $response->assertViewIs("lms::courses.pricing")->assertViewHasAll(['course']);
        $response->assertOk();
    }

    /** @test */
    public function instructor_cannot_create_course_with_invalid_category()
    {
        $this->actingAs($this->instructor);

        $this->get(route('setting', ["course" => $this->course]))->assertOk()
            ->assertViewIs("lms::courses.change-course-status-setting")
            ->assertViewHasAll([
                'title',
                'course'
            ]);
    }

    /** @test */
    public function non_instructor_cannot_create_course_with_invalid_category()
    {
        $this->actingAs($this->student);

        $instructor = User::factory()->create([
            "is_instructor" => 1
        ]);
        $course = Course::factory()->create([
            'user_id' => $instructor->id
        ]);

        $this->post(route('post_setting', ["course" => $course], ["course" => $course?->id]))->assertSessionMissing("status");
        $this->get(route('setting', ["course" => $course]))->assertRedirect();
    }

    /** @test */
    public function unpublishing_the_course()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(
            route(
                'post_setting',
                ["course" => $this->course?->id]
            )
        );

        $response->assertFound();
        $this->assertDatabaseHas("courses", [
            "status" => Course::UNPUBLISH
        ]);
    }
}
