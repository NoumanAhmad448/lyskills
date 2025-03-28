<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Lecture;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @group global-tests
 */
class ProgressControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $student;
    protected $course;
    protected $lecture;
    protected $media;
    protected $instructor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = User::factory()->create();
        $this->instructor = User::factory()->create(['is_instructor' => 1]);

        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $this->lecture = Lecture::factory()->create([
            'course_id' => $this->course->id
        ]);

        $this->media = Media::factory()->create([
            "course_id" => $this->course->id,
            "lecture_id" => $this->lecture->id
        ]);
    }

    /** @test */
    public function student_can_view_videos()
    {
        $this->actingAs($this->student);

        CourseEnrollment::factory([
            "course_id" => $this->course->id,
            "user_id" => $this->student->id
        ])->create();

        $response = $this->get(route('video-page', [
            "slug" => $this->course->slug,
            "video" => explode("/", $this->media->lec_name)[1],
        ]));

        $response->assertOk()->assertViewIs("lms::xuesheng.course-content")->assertViewHasAll([
            'course',
            'title',
            'media',
            'desc',
            'm_lec',
            'c_anns',
            'should_usr_hv_acs'
        ]);
    }

    /** @test **/
    public function ins_can_change_video_url()
    {
        $this->actingAs($this->instructor);
        $slug = fake()->name();
        $response = $this->post(
            route(
                'course-change-url',
                [
                    "course" => $this->course->id,
                ]
            ),
            ["slug" => $slug]
        );
        if (config("app.debug")) {
            $response->dump();
            dump($slug);
            dump("I am hr");
            dump(Course::find($this->course->id));
        }

        $response->assertFound()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas("courses", [
            "slug" => Str::slug($slug),
            "id" => $this->course->id,
            "has_u_update_url" => true
        ]);

        $slug = fake()->name();
        $response = $this->post(
            route(
                'course-change-url',
                [
                    "course" => $this->course->id,
                ]
            ),
            ["slug" => $slug]
        );

        $this->assertDatabaseMissing("courses", [
            "slug" => Str::slug($slug),
            "id" => $this->course->id,
            "has_u_update_url" => true
        ]);
    }

    /** @test * */
    public function set_all_videos_downable()
    {
        $this->actingAs($this->instructor);
        $response = $this->post(route("setVidDown", [
            "course" => $this->course->id
        ]), [
            "set_free" => true
        ]);

        $response->assertOk()
            ->assertJsonCount(2)->assertJsonStructure([
                "success",
                "debug"
            ]);

        $media = Media::where("course_id", $this->course->id)->get();
        if (config("app.debug")) {
            dump($media);
        }
        $media->each(function ($media) {
            $this->assertEquals($media->is_download, 1);
        });
    }

    /** @disabled */
    public function uploadingVideos()
    {

        $this->actingAs($this->instructor);
        $lec = Lecture::factory([
            "course_id" => $this->course->id
        ])->create();

        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->post(route("upload_vid_res", [
            "lec_id" => $lec->id
        ]), [
            "upload_video" =>  UploadedFile::fake()->create('video.mp4', 1024)
        ]);

        $response->assertOk()
            ->assertJsonCount(4)->assertJsonStructure([
                "path",
                "media",
                "delete",
                "f_name"
            ]);
    }
}
