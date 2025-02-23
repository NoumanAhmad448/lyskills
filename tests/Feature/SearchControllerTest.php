<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create some test data
        Categories::factory()->create(['name' => 'Web Development']);
        
        Course::factory()->count(5)->create([
            'course_title' => 'PHP Course',
            'status' => 'published'
        ]);

        Course::factory()->count(3)->create([
            'course_title' => 'JavaScript Course',
            'status' => 'published'
        ]);
    }

    /** @test */
    public function can_search_courses_by_title()
    {
        $response = $this->get('/search?q=PHP');

        $response->assertStatus(200);
        $response->assertViewHas('courses');
        $response->assertSee('PHP Course');
        $response->assertDontSee('JavaScript Course');
    }

    /** @test */
    public function can_filter_courses_by_category()
    {
        $response = $this->get('/search?category=web-development');

        $response->assertStatus(200);
        $response->assertViewHas('courses');
    }

    /** @test */
    public function can_filter_courses_by_price_range()
    {
        $response = $this->get('/search?min_price=10&max_price=50');

        $response->assertStatus(200);
        $response->assertViewHas('courses');
    }

    /** @test */
    public function can_sort_courses()
    {
        $response = $this->get('/search?sort=price_asc');

        $response->assertStatus(200);
        $response->assertViewHas('courses');
    }

    /** @test */
    public function search_excludes_unpublished_courses()
    {
        Course::factory()->create([
            'course_title' => 'Draft Course',
            'status' => 'draft'
        ]);

        $response = $this->get('/search?q=Draft');

        $response->assertStatus(200);
        $response->assertDontSee('Draft Course');
    }
} 