<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CourseEx3Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeController1;
use App\Http\Controllers\InstructorAuthController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

Route::domain(config("app.url"))->middleware(['web'])->group(function () {


    Route::get('/', [HomeController1::class, 'index'])->name('index');
    Route::get('/user_logout', [HomeController1::class, 'logout'])->name('logout_user');
    Route::post('/user_logout_post', [HomeController1::class, 'logout'])->name('logout_post');
    Route::get('/admin', [AdminController::class, 'admin_panel'])->name('admin');
    Route::post('/admin/post', [AdminController::class, 'login'])->name('admin_a');

    // social login
    Route::get('/login/google', [SocialController::class, 'googleVerification'])->name('google-login');
    Route::get('/google/callback', [SocialController::class, 'googleLogin']);

    Route::get('/login/facebook', [SocialController::class, 'facebookVerification'])->name('fb-login');
    Route::get('/facebook/callback', [SocialController::class, 'facebookLogin']);

    Route::get('/login/linkedin', [SocialController::class, 'linkedinVerification'])->name('li-login');
    Route::get('/linkedin/callback', [SocialController::class, 'linkedinLogin']);

    Route::post('course-search', [HomeController::class, 'userSearch'])->name('c-search-page');
    Route::get('show-search-course/{keyword}', [HomeController::class, 'showSearchCourse'])->name('s-search-page');

    Route::get('/instructor/register', [InstructorAuthController::class, 'showRegister'])
        ->name('instructor.register');
    Route::post('/instructor/register', [InstructorAuthController::class, 'register']);

    Route::get('/instructor/login', [InstructorAuthController::class, 'showLogin'])
        ->name('instructor.login');
    Route::post('/instructor/login', [InstructorAuthController::class, 'login']);
    Route::get('categories/{category}', [CategoriesController::class, 'showCategory'])->name('user-categories');
});
