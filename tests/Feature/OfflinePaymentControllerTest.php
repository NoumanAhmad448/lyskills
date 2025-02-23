<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\OfflinePayment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

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

        $response = $this->post(route('offline-payment.store'), [
            'course_id' => $this->course->id,
            'amount' => 99.99,
            'payment_method' => 'bank_transfer',
            'receipt' => $receipt,
            'transaction_id' => 'TXN123456'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('offline_payments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function admin_can_approve_offline_payment()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $this->actingAs($admin);

        $payment = OfflinePayment::factory()->create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'status' => 'pending'
        ]);

        $response = $this->patch(route('offline-payment.approve', $payment->id));

        $response->assertStatus(200);
        $this->assertEquals('approved', $payment->fresh()->status);
        
        // Check if student is enrolled after approval
        $this->assertDatabaseHas('course_enrollments', [
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function admin_can_reject_offline_payment()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $this->actingAs($admin);

        $payment = OfflinePayment::factory()->create([
            'status' => 'pending'
        ]);

        $response = $this->patch(route('offline-payment.reject', $payment->id), [
            'rejection_reason' => 'Invalid receipt'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('rejected', $payment->fresh()->status);
    }

    /** @test */
    public function non_admin_cannot_approve_payment()
    {
        $this->actingAs($this->student);

        $payment = OfflinePayment::factory()->create([
            'status' => 'pending'
        ]);

        $response = $this->patch(route('offline-payment.approve', $payment->id));

        $response->assertStatus(403);
        $this->assertEquals('pending', $payment->fresh()->status);
    }
} 