<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeController1;
use Illuminate\Support\Facades\Route;

Route::domain(config("app.url"))->group(function () {

    Route::get('', [HomeController1::class, 'index'])->name('index');
    Route::get('post/{slug}', [HomeController1::class, 'post'])->name('public_posts');
    Route::get('posts', [HomeController::class, 'posts'])->name('all_public_posts');
    Route::get('page/{slug}', [HomeController1::class, 'page'])->name('public_pages');
    Route::get('faq/{slug}', [HomeController1::class, 'faq'])->name('public_faqs');
    Route::get('faqs', [HomeController::class, 'faqs'])->name('public_faq');

    Route::get('/user_logout', [HomeController::class, 'logout'])->name('logout_user');
    Route::post('/user_logout_post', [HomeController::class, 'logout'])->name('logout_post');
    Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
    Route::post('contact-us', [HomeController::class, 'contactUsPost'])->name('contact-us-post');

    Route::post('ckeditor/upload', [HomeController::class, 'upload'])->name('ckeditor.upload');

    Route::post('get-search', [HomeController::class, 'getSearch'])->name('get-search');
});
