<?php

namespace Tests\Feature;

use App\Models\Certificate;
use Tests\TestCase;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


/**
 * @group global-tests
 */
class CertificateControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $student;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->student = User::factory()->create();
        $instructor = User::factory()->create(['is_instructor' => 1]);

        $this->course = Course::factory()->create([
            'user_id' => $instructor->id
        ]);

        config(["setting.cert_img_path" => "https://www.101certificatetemplates.com/wp-content/uploads/2020/11/Certificate-Template-Word-1.jpg"]);
    }

    /** @test */
    /** @test */
    public function student_down_certificate()
    {
        $this->actingAs($this->student);
        $response = $this->get(route('down-cert', [
            "slug" => $this->course->slug,
        ]));

        $response->assertOk();
    }


    /** @test **/
    public function can_verify_certificate()
    {
        $this->actingAs($this->student);

        Certificate::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'code' => 'CERT123'
        ]);

        $response = $this->get(route('certificates.verify', [
            'code' => 'CERT123',
            "slug" => $this->course->slug
        ]));

        $response->assertJsonStructure([
            'status'
        ]);
    }

    /** @test */
    public function can_download_certificate_pdf()
    {
        $this->actingAs($this->student);

        $certificate = Certificate::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->get(route('verification.get', $certificate->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    /** @test */
    public function certificate_has_unique_verification_code()
    {
        $this->actingAs($this->student);

        $certificate1 = Certificate::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $certificate2 = Certificate::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $this->assertNotEquals(
            $certificate1->code,
            $certificate2->code
        );
    }
}
