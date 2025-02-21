<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class HomepagePhotoTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $storagePath;
    private $defaultPath;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Run migrations
        Artisan::call('migrate:fresh');
        
        // Create admin user
        $this->admin = User::factory()->create(['is_admin' => 1]);
        
        // Get paths from language file
        $this->storagePath = __('tests.homepage.paths.storage');
        $this->defaultPath = __('tests.homepage.paths.default');
    }

    protected function tearDown(): void
    {
        // Clean up any files created during tests
        Storage::fake('s3')->deleteDirectory($this->storagePath);
        Storage::fake('public')->deleteDirectory($this->storagePath);
        
        parent::tearDown();
    }

    /** @test */
    public function non_admin_cannot_access_homepage_settings()
    {
        $user = User::factory()->create(['is_admin' => 0]);
        
        $response = $this->actingAs($user)->get(route('admin.homepage'));
        
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_homepage_settings()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.homepage'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.homepage.index');
    }

    /** @test */
    public function admin_can_upload_homepage_photo()
    {
        Storage::fake('s3');
        Storage::fake('public');

        $file = UploadedFile::fake()->image(__('tests.homepage.file_names.valid'));

        $response = $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file
            ]);

        $response->assertSessionHas('status', __('messages.success.photo_updated'));
        $this->assertDatabaseHas('settings', [
            'homepage_photo' => $this->storagePath . $file->hashName()
        ]);
    }

    /** @test */
    public function homepage_photo_must_be_an_image()
    {
        Storage::fake('s3');

        $file = UploadedFile::fake()->create(__('tests.homepage.file_names.invalid'));

        $response = $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file
            ]);

        $response->assertSessionHasErrors('homepage_photo');
    }

    /** @test */
    public function homepage_photo_must_not_exceed_5mb()
    {
        Storage::fake('s3');

        $file = UploadedFile::fake()->create(
            __('tests.homepage.file_names.large'), 
            __('tests.homepage.sizes.oversized')
        );

        $response = $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file
            ]);

        $response->assertSessionHasErrors('homepage_photo');
    }

    /** @test */
    public function old_photo_is_deleted_when_new_photo_is_uploaded()
    {
        Storage::fake('s3');
        
        // Upload first photo
        $file1 = UploadedFile::fake()->image(__('tests.homepage.file_names.first'));
        $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file1
            ]);
        
        // Upload second photo
        $file2 = UploadedFile::fake()->image(__('tests.homepage.file_names.second'));
        $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file2
            ]);

        // First photo should be deleted
        $this->assertFalse(
            Storage::disk('s3')->exists($this->storagePath . $file1->hashName())
        );
    }

    /** @test */
    public function welcome_page_shows_homepage_photo_if_exists()
    {
        Storage::fake('s3');

        $file = UploadedFile::fake()->image(__('tests.homepage.file_names.valid'));
        
        // Upload photo
        $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file
            ]);

        $response = $this->get('/');
        
        $response->assertSee(config('setting.s3Url') . $this->storagePath . $file->hashName());
    }

    /** @test */
    public function welcome_page_shows_default_photo_if_no_homepage_photo()
    {
        $response = $this->get('/');
        
        $response->assertSee($this->defaultPath);
    }

    /** @test */
    public function local_environment_uses_public_storage()
    {
        config(['app.env' => 'local']);
        Storage::fake('public');

        $file = UploadedFile::fake()->image(__('tests.homepage.file_names.valid'));

        $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file
            ]);

        $this->assertTrue(
            Storage::disk('public')->exists($this->storagePath . $file->hashName())
        );
    }

    /** @test */
    public function production_environment_uses_s3_storage()
    {
        config(['app.env' => 'production']);
        Storage::fake('s3');

        $file = UploadedFile::fake()->image(__('tests.homepage.file_names.valid'));

        $this->actingAs($this->admin)
            ->post(route('admin.homepage.update'), [
                'homepage_photo' => $file
            ]);

        $this->assertTrue(
            Storage::disk('s3')->exists($this->storagePath . $file->hashName())
        );
    }
} 