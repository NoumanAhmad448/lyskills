<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Price;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $instructor = User::factory()->create(['is_instructor' => 1]);
        
        $this->course = Course::factory()->create([
            'user_id' => $instructor->id
        ]);

        Price::factory()->create([
            'course_id' => $this->course->id,
            'pricing' => 19.99
        ]);
    }

    /** @test */
    public function user_can_initiate_payment()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('payment.initiate'), [
            'course_id' => $this->course->id,
            'payment_method' => 'stripe'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['payment_intent', 'client_secret']);
    }

    /** @test */
    public function payment_requires_valid_course()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('payment.initiate'), [
            'course_id' => 999,
            'payment_method' => 'stripe'
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function payment_requires_valid_payment_method()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('payment.initiate'), [
            'course_id' => $this->course->id,
            'payment_method' => 'invalid_method'
        ]);

        $response->assertSessionHasErrors('payment_method');
    }

    /** @test */
    public function successful_payment_enrolls_user()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('payment.complete'), [
            'course_id' => $this->course->id,
            'payment_intent_id' => 'pi_test_123',
            'payment_method' => 'stripe'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('course_enrollments', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id
        ]);
    }
} 