<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Certificate;
use App\Models\CourseProgress;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

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
    }

    /** @test */
    public function student_gets_certificate_upon_course_completion()
    {
        $this->actingAs($this->student);

        // Mark course as completed
        CourseProgress::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'completion_percentage' => 100
        ]);

        $response = $this->post(route('certificates.generate', $this->course));

        $response->assertStatus(200);
        $this->assertDatabaseHas('certificates', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function cannot_get_certificate_for_incomplete_course()
    {
        $this->actingAs($this->student);

        CourseProgress::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'completion_percentage' => 50 // Not complete
        ]);

        $response = $this->post(route('certificates.generate', $this->course));

        $response->assertStatus(403);
    }

    /** @test */
    public function can_verify_certificate()
    {
        $certificate = Certificate::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'verification_code' => 'CERT123'
        ]);

        $response = $this->get(route('certificates.verify', [
            'code' => 'CERT123'
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('certificate', $certificate);
    }

    /** @test */
    public function can_download_certificate_pdf()
    {
        $this->actingAs($this->student);

        $certificate = Certificate::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->get(route('certificates.download', $certificate));

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
            $certificate1->verification_code,
            $certificate2->verification_code
        );
    }
} 