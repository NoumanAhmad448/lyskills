<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('post/{slug}', [HomeController::class, 'post'])->name('public_posts');
Route::get('posts', [HomeController::class, 'posts'])->name('all_public_posts');
Route::get('page/{slug}', [HomeController::class, 'page'])->name('public_pages');
Route::get('faq/{slug}', [HomeController::class, 'faq'])->name('public_faqs');
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
Route::post('course-search', [HomeController::class, 'userSearch'])->name('c-search-page');
Route::get('show-search-course/{keyword}', [HomeController::class, 'showSearchCourse'])->name('s-search-page');

Route::get('get-many-roles', [HomeController::class, 'getManyRoles']);
