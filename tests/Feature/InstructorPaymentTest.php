<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\InstructorAnn;
use App\Models\InstructorEarning;
use App\Models\MonthlyPaymentModel;
use App\Models\CourseHistory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class InstructorPaymentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $instructor;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['is_admin' => 1]);
        $this->instructor = User::factory()->create([
            'is_instructor' => 1,
            'is_admin' => null,
            'is_blogger' => null,
            'is_super_admin' => null
        ]);
    }

    /** @test */
    public function admin_can_view_instructor_payment_page()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('viewPayment'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.i_payment');
        $response->assertViewHas('users');
        $response->assertViewHas('title', 'i_payment');
    }

    /** @test */
    public function admin_can_view_instructor_payment_details()
    {
        $this->actingAs($this->admin);

        // Create earnings for current and previous months
        InstructorEarning::factory()->create([
            'ins_id' => $this->instructor->id,
            'earning' => 100,
            'created_at' => now()
        ]);

        InstructorEarning::factory()->create([
            'ins_id' => $this->instructor->id,
            'earning' => 50,
            'created_at' => now()->subMonth()
        ]);

        $response = $this->get(route('viewInstructorDetail', $this->instructor));

        $response->assertStatus(200);
        $response->assertViewIs('admin.monthly_detail');
        $response->assertViewHas([
            'title',
            'user',
            'payment_detail',
            'payment',
            'payment_history',
            'total_earning',
            'current_month_earning'
        ]);
    }

    /** @test */
    public function admin_can_create_instructor_announcement()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('createInfo'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.i_ann');
        $response->assertViewHas('title', 'i_ann');

        $response = $this->post(route('postInfo'), [
            'message' => 'Test announcement message'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('s_info'));
        $this->assertDatabaseHas('instructor_anns', [
            'message' => 'Test announcement message'
        ]);
    }

    /** @test */
    public function admin_can_view_instructor_announcements()
    {
        $this->actingAs($this->admin);

        InstructorAnn::factory()->count(3)->create();

        $response = $this->get(route('showInfo'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.s_ann');
        $response->assertViewHas(['title', 'instructors']);
    }

    /** @test */
    public function admin_can_edit_instructor_announcement()
    {
        $this->actingAs($this->admin);

        $announcement = InstructorAnn::factory()->create([
            'message' => 'Original message'
        ]);

        $response = $this->get(route('showEdit', $announcement->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.show_edit_ann');

        $response = $this->post(route('edit', $announcement), [
            'message' => 'Updated message'
        ]);

        $response->assertStatus(302);
        $this->assertEquals('Updated message', $announcement->fresh()->message);
    }

    /** @test */
    public function admin_can_delete_instructor_announcement()
    {
        $this->actingAs($this->admin);

        $announcement = InstructorAnn::factory()->create();

        $response = $this->delete(route('delete', $announcement));

        $response->assertStatus(200);
        $response->assertJson('successful');
        $this->assertDatabaseMissing('instructor_anns', ['id' => $announcement->id]);
    }

    /** @test */
    public function admin_can_view_payment_history()
    {
        $this->actingAs($this->admin);

        CourseHistory::factory()->count(3)->create([
            'ins_id' => $this->instructor->id
        ]);

        $response = $this->get(route('paymentHistory'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.payment_history');
        $response->assertViewHas(['title', 'course_history']);
    }

    /** @test */
    public function non_admin_cannot_access_payment_management()
    {
        $this->actingAs($this->instructor);

        $response = $this->get(route('viewPayment'));
        $response->assertStatus(403);

        $response = $this->get(route('paymentHistory'));
        $response->assertStatus(403);

        $response = $this->post(route('postInfo'), [
            'message' => 'Test message'
        ]);
        $response->assertStatus(403);
    }
} 