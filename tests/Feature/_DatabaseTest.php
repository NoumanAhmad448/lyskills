<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Categories;
use Database\Seeders\CategoriesSeeder;

class DatabaseTest extends TestCase
{
    /** @test */
    public function ensure_using_test_database()
    {
        $this->assertEquals(
            config('database.testing_db'),
            \DB::connection()->getDatabaseName(),
            'Not using test database!'
        );
    }

    /** @test */
    public function create_a_single_random_category()
    {
        $category = Categories::factory()->create();
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    /** @test */
    public function create_multiple_categories()
    {
        $categories = Categories::factory()->count(5)->create();
        $this->assertDatabaseCount('categories', 5);
    }

    /** @test */
    public function create_an_inactive_category()
    {
        $inactiveCategory = Categories::factory()->inactive()->create();
        $this->assertDatabaseHas('categories', ['id' => $inactiveCategory->id, 'status' => 'inactive']);
    }

    /** @test */
    public function create_an_it_category()
    {
        $itCategory = Categories::factory()->itCategory()->create();
        $this->assertDatabaseHas('categories', ['id' => $itCategory->id, 'name' => 'Information Technology', 'value' => 'it']);
    }

    /** @test */
    public function create_a_business_category()
    {
        $businessCategory = Categories::factory()->businessCategory()->create();
        $this->assertDatabaseHas('categories', ['id' => $businessCategory->id, 'name' => 'Business', 'value' => 'business']);
    }

    /** @test */
    public function categories_are_seeded_correctly()
    {
        // Run the seeder
        $this->seed(CategoriesSeeder::class);

        // Assert the categories exist
        $this->assertDatabaseHas('categories', [
            'name' => 'Information Technology',
            'value' => 'it'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Business',
            'value' => 'business'
        ]);
    }
} 