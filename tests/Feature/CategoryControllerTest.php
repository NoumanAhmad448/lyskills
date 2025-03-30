<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
class CategoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => 1]);
    }

    /** @test */
    public function admin_can_create_category()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin_store_main_c'), [
            'name' => 'Programming'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('categories', [
            'name' => 'Programming'
        ]);
    }

    /** @test */
    public function admin_can_update_category()
    {
        $this->actingAs($this->admin);
        $category = Categories::factory()->create();

        $response = $this->patch(route('admin_update_main_c', $category->id), [
            'name' => 'Updated Category',
        ]);

        $response->assertStatus(302);
        $this->assertEquals('Updated Category', $category->fresh()->name);
    }

    /** @test */
    public function admin_can_delete_category()
    {
        $this->actingAs($this->admin);
        $category = Categories::factory()->create();

        $response = $this->delete(route('admin_delete_main_c', $category));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }


    /** @test */
    public function admin_can_manage_subcategories()
    {
        $this->actingAs($this->admin);
        $category = Categories::factory()->create();

        $response = $this->post(route('admin_store_sub_c'), [
            'sub_c' => $category->value,
            'name' => 'PHP',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('sub_categories', [
            'name' => 'PHP',
            'categories_id' => $category->id
        ]);
    }
}
