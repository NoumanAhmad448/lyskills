<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Price;
use App\Models\Pricing;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
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

        Pricing::factory()->create([
            'course_id' => $this->course->id,
            'pricing' => 19.99
        ]);
    }

    /** @test */
    public function user_can_see_available_payment()
    {
        $this->actingAs($this->user);
        Setting::first()?->paypal_is_enable ?? Setting::factory()->create([
            "paypal_is_enable" => true
        ]);
        $this->get(route("a_payment_methods", ["slug" => $this->course->slug]))->assertViewIs("lms::xuesheng.available_payment")
            ->assertViewHasAll([
                'title',
                'slug',
                'of_p_methods',
                'setting',
                'course',
                "extras",
            ]);
    }
    /** @test */
    public function user_can_see_stripe_page()
    {
        $this->actingAs($this->user);

        Setting::first()?->s_is_enable ?? Setting::factory()->create([
            "s_is_enable" => true
        ]);
        $this->get(route("credit_card_payment", ["slug" => $this->course->slug]))->assertViewIs("lms::xuesheng.credit-card")
            ->assertViewHasAll(['title', 'slug', 'course', "extras"]);
    }

    /** @test */
    public function user_can_see_payment_history()
    {
        $this->actingAs($this->user);

        $this->get(route("pay_his"))->assertOk();
    }
}
