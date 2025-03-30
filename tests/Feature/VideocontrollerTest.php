<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * @group global-tests
 */
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

        $file = UploadedFile::fake()->create('video.mp4', 1024); // 1024 KB = 1 MB

        $this->post(route('upload_video', [
            'course_id' => $course->id,
            "lecture_id" => Lecture::factory([
                "course_id" => $course->id
            ])->create()->id
        ]), [
            'upload_video' => $file
        ])->assertOk()->assertJsonStructure([
            "path",
            "media"
        ]);
    }
}
