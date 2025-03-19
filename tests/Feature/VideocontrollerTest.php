<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideocontrollerTest extends TestCase
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
    public function checkIfVideoTimeWorking()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $getID3 = new \getID3;
        $file = UploadedFile::fake()->create('video.mp4', 1024); // 1024 KB = 1 MB
        Artisan::call("storage:link-custom");

        $file->store("uploads", "public");

        $this->post(route('upload_video', [
            'course_id' => $course->id,
            "lecture_id" => Lecture::factory([
                "course_id" => $course->id
            ])->create()->id
        ]), [
            'course_vid' => $file
        ]);
        $file = $getID3->analyze(public_path('storage/uploads/video.mp4'));

        $this->assertTrue($file['playtime_seconds']);
    }
}
