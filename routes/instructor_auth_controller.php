<?php

use App\Http\Controllers\InstructorAuthController;
use Illuminate\Support\Facades\Route;

// Instructor Authentication Routes
Route::get('/instructor/register', [InstructorAuthController::class, 'showRegister'])
    ->name('instructor.register');
Route::post('/instructor/register', [InstructorAuthController::class, 'register']);

Route::get('/instructor/login', [InstructorAuthController::class, 'showLogin'])
    ->name('instructor.login');
Route::post('/instructor/login', [InstructorAuthController::class, 'login']);

