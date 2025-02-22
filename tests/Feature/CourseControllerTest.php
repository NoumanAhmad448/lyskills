<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseImage;
use App\Models\Price;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        
        $this->instructor = User::factory()->create([
            'is_instructor' => 1
        ]);
    }

    /** @test */
    public function non_instructor_cannot_create_course()
    {
        $user = User::factory()->create(['is_instructor' => 0]);
        $this->actingAs($user);

        $response = $this->post(route('course.store'), [
            'course_title' => 'Test Course'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function instructor_can_create_course()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('course.store'), [
            'course_title' => 'Test Course',
            'description' => 'Course Description',
            'categories_selection' => 'Web Development',
            'c_level' => 'Beginner',
            'price' => 29.99,
            'is_free' => 0
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('courses', [
            'course_title' => 'Test Course',
            'user_id' => $this->instructor->id
        ]);
    }

    /** @test */
    public function instructor_cannot_update_others_course()
    {
        $otherInstructor = User::factory()->create(['is_instructor' => 1]);
        $course = Course::factory()->create([
            'user_id' => $otherInstructor->id
        ]);

        $this->actingAs($this->instructor);

        $response = $this->put(route('course.update', $course), [
            'course_title' => 'Updated Course'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function instructor_can_update_own_course()
    {
        $this->actingAs($this->instructor);
        
        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $response = $this->put(route('course.update', $course), [
            'course_title' => 'Updated Course',
            'description' => 'Updated Description'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'course_title' => 'Updated Course'
        ]);
    }

    /** @test */
    public function instructor_can_soft_delete_course()
    {
        $this->actingAs($this->instructor);
        
        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $response = $this->delete(route('course.destroy', $course));

        $response->assertRedirect();
        $this->assertNotNull($course->fresh()->is_deleted);
    }

    /** @test */
    public function instructor_can_upload_course_image()
    {
        $this->actingAs($this->instructor);
        
        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $file = UploadedFile::fake()->image('course.jpg');

        $response = $this->post(route('course.image.upload', $course), [
            'image' => $file
        ]);

        $response->assertRedirect();
        $this->assertTrue(Storage::disk('public')->exists('courses/' . $file->hashName()));
        $this->assertDatabaseHas('course_images', [
            'course_id' => $course->id
        ]);
    }

    /** @test */
    public function course_requires_valid_data()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('course.store'), []);

        $response->assertSessionHasErrors([
            'course_title',
            'description',
            'categories_selection',
            'c_level'
        ]);
    }

    /** @test */
    public function course_can_be_published()
    {
        $this->actingAs($this->instructor);
        
        $course = Course::factory()->create([
            'user_id' => $this->instructor->id,
            'status' => 'draft'
        ]);

        $response = $this->put(route('course.publish', $course));

        $response->assertRedirect();
        $this->assertEquals('published', $course->fresh()->status);
    }

    /** @test */
    public function course_price_can_be_updated()
    {
        $this->actingAs($this->instructor);
        
        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        Price::factory()->create([
            'course_id' => $course->id,
            'pricing' => 19.99
        ]);

        $response = $this->put(route('course.price.update', $course), [
            'pricing' => 29.99
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('prices', [
            'course_id' => $course->id,
            'pricing' => 29.99
        ]);
    }

    /** @test */
    public function instructor_cannot_create_course_with_invalid_category()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('course.store'), [
            'course_title' => 'Test Course',
            'description' => 'Course Description',
            'categories_selection' => 'Invalid Category',
            'c_level' => 'Beginner'
        ]);

        $response->assertSessionHasErrors('categories_selection');
    }

    /** @test */
    public function instructor_cannot_create_course_with_invalid_level()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('course.store'), [
            'course_title' => 'Test Course',
            'description' => 'Course Description',
            'categories_selection' => 'Web Development',
            'c_level' => 'Invalid Level'
        ]);

        $response->assertSessionHasErrors('c_level');
    }

    /** @test */
    public function course_title_must_be_unique()
    {
        $this->actingAs($this->instructor);

        Course::factory()->create([
            'course_title' => 'Existing Course'
        ]);

        $response = $this->post(route('course.store'), [
            'course_title' => 'Existing Course',
            'description' => 'Course Description',
            'categories_selection' => 'Web Development',
            'c_level' => 'Beginner'
        ]);

        $response->assertSessionHasErrors('course_title');
    }
} 