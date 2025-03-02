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

class HomeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Categories::factory()->create(); // For homepage categories
    }

    /** @test */
    public function home_page_displays_correctly()
    {
        $course = Course::factory()->create([
            'status' => 'published',
            'is_deleted' => null
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewHas(['title', 'desc', 'cs', 'courses']);
    }

    
    
    /** @test */
    public function search_functionality_works()
    {
        Course::factory()->create([
            'course_title' => 'Laravel Course',
            'status' => 'published',
            'is_deleted' => null
        ]);

        $response = $this->getJson('/get-search?q=Laravel');
        
        $response->assertStatus(200);
        $response->assertJsonStructure([['course_title']]);
    }

    /** @test */
    public function search_returns_instructor_names_if_no_courses()
    {
        User::factory()->create([
            'name' => 'John Teacher'
        ]);

        $response = $this->getJson('/get-search?q=John');
        
        $response->assertStatus(200);
        $response->assertJsonStructure([['name']]);
    }

    /** @test */
    public function contact_form_sends_email()
    {
        Mail::fake();

        $response = $this->post('/contact-us', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'body' => 'Test Message',
            'mobile' => '1234567890',
            'country' => 'Test Country'
        ]);

        Mail::assertQueued(ContactUsMail::class, function ($mail) {
            return $mail->hasTo(config("mail.contact_us_email"));
        });
        
        $response->assertRedirect();
        $response->assertSessionHas('status', 'Your Message has delivered. We will contact you soon');
    }

    /** @test
     * 
     * 
     */
    
    public function contact_form_validates_required_fields()
    {
        $response = $this->post('/contact-us', []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'body']);
    }
} 