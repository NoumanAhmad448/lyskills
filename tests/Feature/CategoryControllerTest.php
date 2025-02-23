<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

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

        $response = $this->post(route('categories.store'), [
            'name' => 'Programming',
            'description' => 'Learn programming languages',
            'slug' => 'programming'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => 'Programming'
        ]);
    }

    /** @test */
    public function admin_can_update_category()
    {
        $this->actingAs($this->admin);
        $category = Categories::factory()->create();

        $response = $this->patch(route('categories.update', $category), [
            'name' => 'Updated Category',
            'description' => 'Updated description'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Category', $category->fresh()->name);
    }

    /** @test */
    public function admin_can_delete_category()
    {
        $this->actingAs($this->admin);
        $category = Categories::factory()->create();

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function admin_can_reorder_categories()
    {
        $this->actingAs($this->admin);
        $categories = Categories::factory()->count(3)->create();

        $newOrder = $categories->pluck('id')->reverse()->values();

        $response = $this->post(route('categories.reorder'), [
            'category_order' => $newOrder->toArray()
        ]);

        $response->assertStatus(200);
        $this->assertEquals($newOrder[0], Categories::where('sort_order', 1)->first()->id);
    }

    /** @test */
    public function admin_can_manage_subcategories()
    {
        $this->actingAs($this->admin);
        $category = Categories::factory()->create();

        $response = $this->post(route('subcategories.store'), [
            'category_id' => $category->id,
            'name' => 'PHP',
            'description' => 'Learn PHP'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('sub_categories', [
            'name' => 'PHP',
            'categories_id' => $category->id
        ]);
    }
} 