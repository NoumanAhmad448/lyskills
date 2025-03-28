<?php

namespace Tests\Feature;

use App\Models\Categories;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\View;
use App\Models\Pricing;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/**
 * @group global-tests
 */
class CourseController2Test extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $student;
    protected $admin;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->instructor = User::factory()->create([
            'is_instructor' => 1
        ]);

        $this->student = User::factory()->create();
        $this->admin = User::factory()->create([
            'is_admin' => 1
        ]);

        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);
    }

    /** @test */
    public function non_instructor_creating_create_course()
    {

        $user = User::factory()->create(['is_instructor' => 0]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));

        $response->assertViewIs("lms::dashboard");
        $response->assertViewHasAll(['courses', 'title', 'ann']);
        $this->assertDatabaseHas('users', [
            'is_instructor' => 1
        ]);

        $this->assertTrue(View::exists('lms::dashboard'));
    }

    /** @test */
    public function instructor_can_create_course()
    {
        $this->actingAs($this->student);

        $course = Course::factory()->create();
        $pricing = Pricing::factory([
            "course_id" => $course->refresh()->id
        ])->create();

        if (config("app.debug")) {
            $pricing->dump();
            $course->dump();
        }

        $response = $this->get(route('show-all-courses'));
        if (config("app.debug")) {
            $response->dump();
        }

        $response->assertViewIs("lms::xuesheng.all-courses")->assertViewHasAll(['title', 'courses']);
        $this->assertTrue(View::exists('lms::xuesheng.all-courses'));
        $response->assertOk();

        $response = $this->get(route('logout_user'));
        $response->assertRedirectToRoute("index")->assertFound();

        $response = $this->post(route('logout_post'));
        $response->assertRedirectToRoute("index")->assertFound();
    }

    /** @test */
    public function public_admin_login()
    {

        $response = $this->get(route('admin'));

        $response->assertViewIs("admin")->assertViewHasAll(['title']);
        $this->assertTrue(View::exists('admin'));
        $response->assertOk();
    }

    /** @test */
    public function admin_visitng_login_page()
    {

        $this->actingAs($this->admin);
        $response = $this->get(route('admin'));

        $response->assertRedirectToRoute('a_home')->assertFound();
        $this->assertTrue(Route::has('a_home'));
    }

    /** @test */
    public function student_visitig_admin_page()
    {

        $this->actingAs($this->student);
        $response = $this->get(route('admin'));

        $response->assertRedirectToRoute('index')->assertFound();
        $this->assertTrue(Route::has('index'));
    }

    /** @test */
    public function visit_exist()
    {
        $this->assertTrue(View::exists(config("setting.show_course_blade")));
    }

    /** @test */
    public function public_routes()
    {

        $categories = Categories::factory()->create();

        $this->assertTrue(Route::has([
            "instructor.login",
            "login",
            "register",
            "instructor.register",
            "s-search-page",
            "li-login",
            "google-login",
            "fb-login",
        ]));

        $this->get(route('instructor.login'))->assertViewIs('lms::auth.instructor.login')->assertViewHasAll(['title', "desc"]);
        $this->get(route('login'))->assertViewis("auth.login")->assertOk();

        $this->get(route('user-categories', ["category" => $categories->value]))->assertOk()->assertViewIs(config("setting.category_blade"));
        $this->get(route('register'))->assertOk();

        if (config("app.debug")) {
            dump("calling instrutor register header");
            $this->get(route('instructor.register'))->dump();
        }
        $response = $this->get(route('instructor.register'))->assertViewIs(config("setting.show_blade"))
            ->assertViewHasAll(['title', 'desc']);

        if (config("app.debug")) {
            debug_logs($response->dump());
        }

        Course::factory()->create([
            "course_title" => "sample title",
            "slug" => Str::slug("sample title")
        ]);
        $response = $this->get(route('s-search-page', ["keyword" => "sample_title"]));
        $response->assertViewIs("lms::xuesheng.show-course")
            ->assertViewHasAll(
                [
                    'title',
                    'courses',
                    'keyword'
                ]
            );
        $this->get(route('li-login'))->assertFound();
        $this->get(route('google-login'))->assertFound();
        $this->get(route('fb-login'))->assertFound();
    }

    /** @test */
    public function instructor_can_soft_delete_course()
    {
        $this->actingAs($this->instructor);

        $course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $response = $this->delete(route('course_delete', ["course_id" => $course->id]));

        $response->assertRedirect()->assertRedirectToRoute('dashboard');
        $this->assertNotNull($course->fresh()->is_deleted);
    }
}
