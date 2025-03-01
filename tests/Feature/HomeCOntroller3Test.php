<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Faq;
use App\Models\Course;
use App\Models\Page;
use App\Models\Categories;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;

class HomeController2Test extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Categories::factory()->create(); // For homepage categories
    }
    /** @test */
    public function can_upload_image_for_editor()
    {
        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post('/upload', [
            'upload' => $file,
            'CKEditorFuncNum' => 1
        ]);

        $response->assertStatus(200);
        $this->assertStringContainsString('Image uploaded successfully', $response->getContent());
    }

    /** @test */
    public function can_search_courses_by_keyword()
    {
        $course = Course::factory()->create([
            'course_title' => 'PHP Programming',
            'status' => 'published',
            'is_deleted' => null
        ]);

        $response = $this->get('/user-search?search_course=PHP');

        $response->assertRedirect(route('s-search-page', ['keyword' => 'PHP']));
    }

    /** @test */
    public function xss_attempts_are_sanitized()
    {
        $maliciousInputs = [
            '<script>alert("xss")</script>',
            'javascript:alert("xss")',
            '<img src="x" onerror="alert(\'xss\')">',
            '<svg onload="alert(\'xss\')">',
            '"onclick="alert(\'xss\')"'
        ];

        foreach ($maliciousInputs as $input) {
            $response = $this->get('/show-search-course/' . $input);
            
            // Check that the output is properly escaped
            $response->assertDontSee($input, false);
            $response->assertSee(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'), false);
            $response->assertStatus(200);
        }
    }

}