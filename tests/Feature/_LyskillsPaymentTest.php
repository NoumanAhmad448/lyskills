<?php

namespace Tests\Feature;

use App\Actions\Nouman\LyskillsPayment;
use App\Mail\InformInstructorMail;
use App\Mail\StudentEnrollmentMail;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\InstructorEarning;
use App\Models\Setting;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LyskillsPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $course;
    protected $payment;

    protected function setUp(): void
    {
        parent::setUp();

        // Creating mock user & course
        $this->user = User::factory()->create();
        $this->course = Course::factory()->create();

        // Initializing the payment action
        $this->payment = new LyskillsPayment($this->user->id, $this->course->id, 'paypal');
    }

    /** @test */
    public function it_should_enroll_user_in_a_course()
    {
        $response = $this->payment->courseEnrollment(100, 1, false);

        $this->assertTrue($response['status']);
        $this->assertDatabaseHas('course_enrollments', [
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_should_enroll_user_in_a_free_course_without_earning_entry()
    {
        $response = $this->payment->courseEnrollment(0, 1, true);

        $this->assertTrue($response['status']);
        $this->assertDatabaseMissing('instructor_earnings', [
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_should_calculate_instructor_earnings_correctly()
    {
        Setting::factory()->create([
            'payment_share_enable' => true,
            'instructor_share' => 70
        ]);

        $response = $this->payment->courseEnrollment(200, 1, false);

        $this->assertTrue($response['status']);
        $this->assertDatabaseHas('instructor_earnings', [
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
            'earning' => 140
        ]);
    }

    /** @test */
    public function it_should_default_to_50_percent_if_no_payment_policy()
    {
        $response = $this->payment->courseEnrollment(200, 1, false);

        $this->assertTrue($response['status']);
        $this->assertDatabaseHas('instructor_earnings', [
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
            'earning' => 100
        ]);
    }

    /** @test */
    public function it_should_return_false_if_enrollment_fails()
    {
        $response = (new LyskillsPayment(null, null, 'paypal'))->courseEnrollment(100, 1, false);

        $this->assertFalse($response['status']);
    }

    /** @test */
    public function it_should_send_enrollment_email()
    {
        Mail::fake();

        $this->payment->sendEmail('student@example.com', 'John Doe', 'course-slug', $this->course);

        Mail::assertQueued(StudentEnrollmentMail::class);
        Mail::assertQueued(InformInstructorMail::class);
    }

    /** @test */
    public function it_should_not_send_email_if_invalid_email()
    {
        Mail::fake();

        $this->payment->sendEmail('invalid-email', 'John Doe', 'course-slug', $this->course);

        Mail::assertNothingQueued();
    }

    /** @test */
    public function it_should_not_allow_negative_price_enrollment()
    {
        $response = $this->payment->courseEnrollment(-50, 1, false);

        $this->assertFalse($response['status']);
    }

    /** @test */
    public function it_should_not_duplicate_enrollment()
    {
        CourseEnrollment::create(['course_id' => $this->course->id, 'user_id' => $this->user->id]);

        $response = $this->payment->courseEnrollment(100, 1, false);

        $this->assertTrue($response['status']);
        $this->assertEquals(1, CourseEnrollment::where('user_id', $this->user->id)->count());
    }
}
