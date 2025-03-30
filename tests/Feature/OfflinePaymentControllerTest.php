<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Pricing;
use App\Models\Setting as ModelsSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Setting;

/**
 * @group global-tests
 */
class OfflinePaymentControllerTest extends TestCase
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
    public function student_can_submit_offline_payment()
    {
        $this->actingAs($this->student);

        $receipt = UploadedFile::fake()->image('receipt.jpg');

        $response = $this->post(route('enroll-now', [
            'course' => $this?->course?->id,
        ]));

        $response->assertStatus(302);
        $this->assertDatabaseHas('course_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
        ]);
    }

    /** @test */
    public function admin_can_approve_offline_payment()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $this->actingAs($admin);

        Pricing::factory()->create([
            'course_id' => $this->course->id,
            'pricing' => 100,
            'is_free' => false
        ]);

        $response = $this->post(route('n_en_p', ["user" => $this->student->id, "course" => $this->course?->id]));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('offline_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
        ]);

        $this->assertDatabaseHas('course_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
        ]);

        Pricing::factory()->create([
            'course_id' => $this->course->id,
            'pricing' => 100,
            'is_free' => false
        ]);
        $this->assertDatabaseHas('course_histories', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'pay_method' => "offline payment",
            'amount' => 100,
            'ins_id' => $this->course->user_id
        ]);

        ModelsSetting::factory()->create([
            'payment_share_enable' => true,
            'instructor_share' => 50
        ]);
        $policy = ModelsSetting::select('payment_share_enable', 'instructor_share')->first();

        if ($policy && $policy->count() && $policy['payment_share_enable']) {
            // Check if student is enrolled after approval
            $this->assertDatabaseHas('instructor_earnings', [
                'user_id' => $this->student->id,
                'course_id' => $this->course->id,
                'earning' => ((int) $policy['instructor_share'] * 100) / 100,
                'ins_id' => $this->course->user_id
            ]);
        }
    }

    /** @test */
    public function set_50_percentant_payment()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $this->actingAs($admin);

        Pricing::factory()->create([
            'course_id' => $this->course->id,
            'pricing' => 100,
            'is_free' => false
        ]);

        $response = $this->post(route('n_en_p', ["user" => $this->student->id, "course" => $this->course?->id]));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('offline_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
        ]);

        $this->assertDatabaseHas('course_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
        ]);

        Pricing::factory()->create([
            'course_id' => $this->course->id,
            'pricing' => 100,
            'is_free' => false
        ]);
        $this->assertDatabaseHas('course_histories', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'pay_method' => "offline payment",
            'amount' => 100,
            'ins_id' => $this->course->user_id
        ]);


        $policy = ModelsSetting::select('payment_share_enable', 'instructor_share')->first();

        if (!($policy && $policy->count() && $policy['payment_share_enable'])) {
            // Check if student is enrolled after approval
            $this->assertDatabaseHas('instructor_earnings', [
                'user_id' => $this->student->id,
                'course_id' => $this->course->id,
                'earning' => ((int) 50 * 100) / 100,
                'ins_id' => $this->course->user_id
            ]);
        }
    }

    /** @test */
    public function non_admin_cannot_approve_payment()
    {
        $this->actingAs($this->student);

        $response = $this->post(route('n_en_p', ["user" => $this->student->id, "course" => $this->course?->id]));
        $response->assertRedirectToRoute("index");

    }

    /** @test */
    public function student_can_send_offline_payment()
    {
        $this->actingAs($this->student);
        $response = $this->post(route('offline-payment'), [
            "slug" => $this->course->slug
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('offline_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
        ]);
    }
    /** @test */
    public function every_student_can_access_course()
    {
        $response = $this->get(route('user-course', [
            "slug" => $this->course->slug
        ]));

        $response->assertViewIs(config("setting.show_course_blade"));
    }
}
