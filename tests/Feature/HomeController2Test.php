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
    
        /** @test */
        public function can_view_faq_list()
        {
            Faq::factory()->count(3)->create([
                'status' => 'published'
            ]);
    
            $response = $this->get('/faqs');
    
            $response->assertStatus(200);
            $response->assertViewHas('faqs');
            $response->assertViewHas('title', 'faq');
        }
    
        /** @test */
        public function can_view_blog_posts()
        {
            Post::factory()->count(3)->create([
                'status' => 'published'
            ]);
    
            $response = $this->get('/posts');
            
            $response->assertStatus(200);
            $response->assertViewHas(['posts', 'title', 'desc']);
        }
    
        /** @test */
        public function user_can_logout()
        {
            $user = User::factory()->create();
            $this->actingAs($user);
    
            $response = $this->post('/logout');
    
            $response->assertRedirect('/');
            $this->assertGuest();
        }

        /** @test */
    public function can_view_single_post()
    {
        $post = Post::factory()->create([
            'status' => 'published'
        ]);

        $response = $this->get("/post/{$post->slug}");
        
        $response->assertStatus(200);
        $response->assertViewHas(['post', 'title']);
    }

    /** @test */
    public function invalid_post_redirects_to_home()
    {
        $response = $this->get("/post/invalid-slug");
        $response->assertRedirect(route('index'));
    }

    /** @test */
    public function can_view_single_faq()
    {
        $faq = Faq::factory()->create([
            'status' => 'published'
        ]);

        $response = $this->get("/faq/{$faq->slug}");
        
        $response->assertStatus(200);
        $response->assertViewHas(['faq', 'title']);
    }

    /** @test */
    public function can_view_all_faqs()
    {
        Faq::factory()->count(5)->create([
            'status' => 'published'
        ]);

        $response = $this->get("/faqs");
        
        $response->assertStatus(200);
        $response->assertViewHas('faqs');
    }

    /** @test */
    public function can_view_static_pages()
    {
        $page = Page::factory()->create([
            'slug' => 'privacy-policy'
        ]);

        $response = $this->get("/page/privacy-policy");
        
        $response->assertStatus(200);
        $response->assertViewHas(['page', 'title', 'desc']);
    }

    /** @test */
    public function search_returns_valid_results()
    {
        Course::factory()->create([
            'course_title' => 'Laravel Course',
            'status' => 'published'
        ]);

        $response = $this->get('/search?q=Laravel');
        
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }


}