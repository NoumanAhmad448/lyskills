<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeController1;
use Eren\Lms\Controllers\HomeController as ControllersHomeController;
use Eren\Lms\Controllers\HomeController1 as ControllersHomeController1;
use Illuminate\Support\Facades\Route;


Route::get('', [HomeController1::class, 'index'])->name('index');
Route::get('post/{slug}', [ControllersHomeController::class, 'post'])->name('public_posts');
Route::get('posts', [HomeController::class, 'posts'])->name('all_public_posts');
Route::get('page/{slug}', [ControllersHomeController1::class, 'page'])->name('public_pages');
Route::get('faq/{slug}', [ControllersHomeController1::class, 'faq'])->name('public_faqs');
Route::get('faqs', [HomeController::class, 'faqs'])->name('public_faq');
// Route::get('go-live-with-nouman', [HomeController::class, 'aritsanLive']);
Route::get('/user_logout', [HomeController::class, 'logout'])->name('logout_user');
Route::post('/user_logout_post', [HomeController::class, 'logout'])->name('logout_post');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('contact-us', [HomeController::class, 'contactUsPost'])->name('contact-us-post');

Route::post('ckeditor/upload', [HomeController::class, 'upload'])->name('ckeditor.upload');
// Route::get('test', function(){
// return view('testing');
// });
Route::post('get-search', [HomeController::class, 'getSearch'])->name('get-search');

