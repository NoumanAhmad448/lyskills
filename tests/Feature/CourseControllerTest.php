<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Pricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @group global-tests
 */
class CourseControllerTest extends TestCase
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
    public function instructor_can_upload_course_image()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $file = UploadedFile::fake()->image('course.jpg');

        $response = $this->post(route('course_img', ['course' => $course->id]), [
            'course_img' => $file
        ]);

        if (config("app.debug")) {
            $response->dump();
        }

        $response->assertJsonCount(2)->assertJsonFragment([
            'status' => 'saved'
        ]);
        $this->assertDatabaseHas('course_images', [
            'course_id' => $course->id
        ]);
    }

    /** @test */
    public function instructor_can_upload_course_video()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $file = UploadedFile::fake()->create('video.mp4', 1024); // 1024 KB = 1 MB

        $response = $this->post(route('course_vid', ['course' => $course->id]), [
            'course_vid' => $file
        ]);

        if (config("app.debug")) {
            $response->dump();
        }

        $response->assertJsonCount(2)->assertOk();
        $this->assertDatabaseHas('course_videos', [
            'course_id' => $course->id
        ]);
    }

    /** @test */
    public function course_requires_valid_data()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $response = $this->post(route('course_img', ['course' => $course->id]), [
            'course_img' => ""
        ]);

        $response->assertSessionHasErrors([
            'course_img'
        ]);
    }

    /** @test */
    public function course_cannot_be_published()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id,
            'status' => 'draft'
        ]);

        $response = $this->post(route('submitCourse', ['course' => $course->id]));

        $response->assertOk();
        $this->assertEquals('draft', $course->fresh()->status);
        $this->assertDatabaseHas('courses', [
            'status' => 'draft'
        ]);
    }

    /** @test */
    public function course_price_can_be_updated()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        Pricing::factory()->create([
            'course_id' => $course->id,
            'pricing' => 19.99
        ]);

        $response = $this->post(route('pricingPost', ["course" => $course?->id]), [
            'pricing' => 29.99
        ]);

        $response->assertOk()->assertJsonFragment([
            'status' => 'saved'
        ]);
        $this->assertDatabaseHas('pricings', [
            'course_id' => $course->id,
            'pricing' => 29.99
        ]);
    }

    /** @test */
    public function course_free_can_be_updated()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        Pricing::factory()->create([
            'course_id' => $course->id,
            'pricing' => 19.99
        ]);

        $response = $this->post(route('pricingPost', ["course" => $course?->id]), [
            'free' => true
        ]);

        $response->assertOk()->assertJsonFragment([
            'status' => 'saved'
        ]);
        $this->assertDatabaseHas('pricings', [
            'course_id' => $course->id,
            'is_free' => true
        ]);
    }
}
