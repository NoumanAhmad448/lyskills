<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class MediaControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        
        $this->instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);
    }

    /** @test */
    public function instructor_can_upload_media()
    {
        $this->actingAs($this->instructor);

        $file = UploadedFile::fake()->image('course-media.jpg');

        $response = $this->post(route('media.store'), [
            'course_id' => $this->course->id,
            'media' => $file,
            'type' => 'image'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('media', [
            'course_id' => $this->course->id,
            'type' => 'image'
        ]);
        Storage::disk('public')->assertExists('media/' . $file->hashName());
    }

    /** @test */
    public function instructor_can_delete_own_media()
    {
        $this->actingAs($this->instructor);

        $media = Media::factory()->create([
            'course_id' => $this->course->id
        ]);

        $response = $this->delete(route('media.destroy', $media));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }

    /** @test */
    public function instructor_cannot_delete_others_media()
    {
        $otherInstructor = User::factory()->create(['is_instructor' => 1]);
        $otherCourse = Course::factory()->create(['user_id' => $otherInstructor->id]);
        
        $this->actingAs($this->instructor);

        $media = Media::factory()->create([
            'course_id' => $otherCourse->id
        ]);

        $response = $this->delete(route('media.destroy', $media));

        $response->assertStatus(403);
        $this->assertDatabaseHas('media', ['id' => $media->id]);
    }
} 