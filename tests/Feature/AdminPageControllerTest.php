<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPageControllerTest extends TestCase
{
    use RefreshDatabase; // Ensures fresh DB for each test

    protected $adminUser;
    protected $regularUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->regularUser = User::factory()->create(['is_admin' => false]);
    }

    /** @test */
    public function it_displays_the_pages_list_for_admin()
    {
        Page::factory()->count(5)->create();
        $response = $this->actingAs($this->adminUser)->get(route('admin_v_page'));
        $response->assertStatus(200)->assertViewHas('pages');
    }

    /** @test */
    public function non_admin_users_cannot_access_pages_list()
    {
        $response = $this->actingAs($this->regularUser)->get(route('admin_v_page'));
        $response->assertStatus(403); // Forbidden
    }

    /** @test */
    public function unauthenticated_users_cannot_access_pages_list()
    {
        $response = $this->get(route('admin_v_page'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_allows_admin_to_create_a_page()
    {
        Storage::fake('public');
        $data = [
            'title' => 'Test Page',
            'message' => 'This is a test message',
            'upload_img' => UploadedFile::fake()->image('test.jpg')
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin_save_page'), $data);
        $response->assertRedirect(route('admin_v_page'));
        $this->assertDatabaseHas('pages', ['title' => 'Test Page']);
    }

    /** @test */
    public function non_admin_users_cannot_create_pages()
    {
        $data = ['title' => 'Unauthorized Page', 'message' => 'You should not be able to do this.'];

        $response = $this->actingAs($this->regularUser)->post(route('admin_save_page'), $data);
        $response->assertStatus(403);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_page()
    {
        $data = ['title' => '', 'message' => ''];
        $response = $this->actingAs($this->adminUser)->post(route('admin_save_page'), $data);
        $response->assertSessionHasErrors(['title', 'message']);
    }

    /** @test */
    public function it_prevents_xss_attacks_in_page_title()
    {
        $data = [
            'title' => '<script>alert("Hacked!")</script>',
            'message' => 'Testing XSS',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin_save_page'), $data);
        $response->assertRedirect(route('admin_v_page'));
        $this->assertDatabaseMissing('pages', ['title' => '<script>alert("Hacked!")</script>']);
    }

    /** @test */
    public function it_generates_unique_slug_for_duplicate_titles()
    {
        Page::factory()->create(['title' => 'Unique Title']);
        $data = ['title' => 'Unique Title', 'message' => 'Another Page'];

        $response = $this->actingAs($this->adminUser)->post(route('admin_save_page'), $data);
        $this->assertDatabaseHas('pages', ['slug' => 'unique-title-1']);
    }

    /** @test */
    public function it_fails_when_uploading_invalid_image_formats()
    {
        Storage::fake('public');
        $data = [
            'title' => 'Invalid Image Upload',
            'message' => 'Testing file validation',
            'upload_img' => UploadedFile::fake()->create('invalid.txt', 200)
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin_save_page'), $data);
        $response->assertSessionHasErrors('upload_img');
    }

    /** @test */
    public function it_allows_admin_to_edit_a_page()
    {
        $page = Page::factory()->create();
        $response = $this->actingAs($this->adminUser)->get(route('admin_edit_page', $page));
        $response->assertStatus(200)->assertViewHas('page');
    }

    /** @test */
    public function non_admin_users_cannot_edit_pages()
    {
        $page = Page::factory()->create();
        $response = $this->actingAs($this->regularUser)->get(route('admin_edit_page', $page));
        $response->assertStatus(403);
    }

    /** @test */
    public function it_updates_a_page_successfully()
    {
        $page = Page::factory()->create();
        $data = ['title' => 'Updated Title', 'message' => 'Updated message'];

        $response = $this->actingAs($this->adminUser)->put(route('admin_update_page', $page), $data);
        $response->assertRedirect(route('admin_edit_page', $page));
        $this->assertDatabaseHas('pages', ['id' => $page->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function it_changes_page_status_correctly()
    {
        $page = Page::factory()->create(['status' => 'unpublished']);
        $response = $this->actingAs($this->adminUser)->post(route('admin_change_status', $page));
        $response->assertRedirect(route('admin_v_page'));
        $this->assertEquals('published', $page->fresh()->status);
    }

    /** @test */
    public function non_admin_users_cannot_change_page_status()
    {
        $page = Page::factory()->create(['status' => 'unpublished']);
        $response = $this->actingAs($this->regularUser)->post(route('admin_change_status', $page));
        $response->assertStatus(403);
    }

    /** @test */
    public function it_deletes_a_page_successfully()
    {
        $page = Page::factory()->create();
        $response = $this->actingAs($this->adminUser)->delete(route('admin_delete_page', $page));
        $response->assertRedirect();
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    /** @test */
    public function non_admin_users_cannot_delete_pages()
    {
        $page = Page::factory()->create();
        $response = $this->actingAs($this->regularUser)->delete(route('admin_delete_page', $page));
        $response->assertStatus(403);
    }

    /** @test */
    public function it_removes_associated_images_on_page_deletion()
    {
        Storage::fake('public');
        $page = Page::factory()->create(['upload_img' => 'uploads/test.jpg']);
        Storage::disk('public')->put('uploads/test.jpg', 'fake content');

        $this->assertTrue(Storage::disk('public')->exists('uploads/test.jpg'));

        $this->actingAs($this->adminUser)->delete(route('admin_delete_page', $page));
        Storage::disk('public')->assertMissing('uploads/test.jpg');
    }
}
