<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class WishlistControllerTest extends TestCase
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
            'user_id' => $instructor->id,
            'status' => 'published'
        ]);
    }

    /** @test */
    public function user_can_add_course_to_wishlist()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('wishlist.store'), [
            'course_id' => $this->course->id
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function user_can_remove_course_from_wishlist()
    {
        $this->actingAs($this->user);

        Wishlist::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->delete(route('wishlist.destroy', $this->course->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function user_can_view_wishlist()
    {
        $this->actingAs($this->user);

        Wishlist::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id
        ]);

        $response = $this->get(route('wishlist.index'));

        $response->assertStatus(200);
        $response->assertViewHas('wishlist_items');
        $response->assertSee($this->course->course_title);
    }

    /** @test */
    public function guest_cannot_access_wishlist()
    {
        $response = $this->get(route('wishlist.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function cannot_add_unpublished_course_to_wishlist()
    {
        $this->actingAs($this->user);
        
        $this->course->update(['status' => 'draft']);

        $response = $this->post(route('wishlist.store'), [
            'course_id' => $this->course->id
        ]);

        $response->assertStatus(404);
    }
} 