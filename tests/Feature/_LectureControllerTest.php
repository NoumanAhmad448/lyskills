<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Section;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LectureControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $course;
    protected $section;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        
        $this->instructor = User::factory()->create(['is_instructor' => 1]);
        
        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $this->section = Section::factory()->create([
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function instructor_can_create_lecture()
    {
        $this->actingAs($this->instructor);

        $video = UploadedFile::fake()->create('lecture.mp4', 5000);

        $response = $this->post(route('lectures.store'), [
            'section_id' => $this->section->id,
            'title' => 'Introduction to Laravel',
            'description' => 'Learn the basics',
            'video' => $video,
            'duration' => 3600,
            'is_preview' => true
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('lectures', [
            'section_id' => $this->section->id,
            'title' => 'Introduction to Laravel'
        ]);
    }

    /** @test */
    public function instructor_can_update_lecture()
    {
        $this->actingAs($this->instructor);

        $lecture = Lecture::factory()->create([
            'section_id' => $this->section->id
        ]);

        $response = $this->patch(route('lectures.update', $lecture), [
            'title' => 'Updated Title',
            'description' => 'Updated description'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Title', $lecture->fresh()->title);
    }

    /** @test */
    public function instructor_can_reorder_lectures()
    {
        $this->actingAs($this->instructor);

        $lectures = Lecture::factory()->count(3)->create([
            'section_id' => $this->section->id
        ]);

        $newOrder = $lectures->pluck('id')->reverse()->values();

        $response = $this->post(route('lectures.reorder'), [
            'lecture_order' => $newOrder->toArray()
        ]);

        $response->assertStatus(200);
        $this->assertEquals($newOrder[0], Lecture::where('sort_order', 1)->first()->id);
    }

    /** @test */
    public function instructor_can_toggle_preview_status()
    {
        $this->actingAs($this->instructor);

        $lecture = Lecture::factory()->create([
            'section_id' => $this->section->id,
            'is_preview' => false
        ]);

        $response = $this->patch(route('lectures.toggle-preview', $lecture));

        $response->assertStatus(200);
        $this->assertTrue($lecture->fresh()->is_preview);
    }
} 