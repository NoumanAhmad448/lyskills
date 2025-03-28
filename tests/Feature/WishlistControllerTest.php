<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Pricing;
use App\Models\WishList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
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

        $response = $this->post(route('wishlist-course-post', [
            'slug' => $this->course->slug
        ]));

        $response->assertFound()->assertRedirectToRoute('get-wishlist-course');
        $this->assertDatabaseHas(config("table.wishlist_tble"), [
            'user_id' => $this->user->id,
            'c_id' => $this->course->id
        ]);
    }

    /** @test */
    public function user_can_remove_course_from_wishlist()
    {
        $this->actingAs($this->user);

        WishList::create([
            'user_id' => $this->user->id,
            'c_id' => $this->course->id
        ]);

        $response = $this->delete(route('remove-wishlist-course', $this->course->slug));

        $response->assertFound();
        $this->assertDatabaseMissing(config("table.wishlist_tble"), [
            'user_id' => $this->user->id,
            'c_id' => $this->course->id
        ]);
    }

    /** @test */
    public function user_can_view_wishlist()
    {
        $this->actingAs($this->user);

        Pricing::factory()->create([
            "course_id" => $this->course->id
        ]);
        WishList::create([
            'user_id' => $this->user->id,
            'c_id' => $this->course->id
        ]);

        $response = $this->get(route("get-wishlist-course"));

        $response->assertStatus(200);
        $response->assertViewIs('lms::student.wish-list');
        $response->assertViewHas("title");
    }

    /** @test */
    public function guest_cannot_access_wishlist()
    {
        $response = $this->get(route("get-wishlist-course"));

        $response->assertRedirect(route('register'));
    }

    /** @test */
    public function cannot_add_unpublished_course_to_wishlist()
    {
        $this->actingAs($this->user);

        $this->course->update(['status' => 'draft']);

        $response = $this->post(route('wishlist-course-post', [
            'slug' => $this->course->slug
        ]));

        $response->assertFound();
        $this->assertDatabaseMissing(config("table.wishlist_tble"), [
            'user_id' => $this->user->id,
            'c_id' => $this->course->id
        ]);
    }
}
