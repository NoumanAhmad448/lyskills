<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubCategories;

$route = Route::prefix("admin")->middleware(['web', 'admin']);
if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}
$route->group(function () {

    Route::get('/get-draft-courses', [AdminController::class, 'draftCourse'])->name('draft_course');
    Route::get('/get-published-courses', [AdminController::class, 'publishedCourse'])->name('p_courses');
    Route::get('/courses/new-courses', [CourseController::class, 'newCourse'])->name('i_new_courses');
    Route::get('/dashboard', [AdminController::class, 'index'])->middleware('admin')->name('a_home');
    Route::get('/logout', [AdminController::class, 'logout'])->name('a_logout');
    Route::post('change-course-status', [CourseController::class, 'changeStatus'])->name('change_course_status');


    Route::get('create-main-categories', [CategoriesController::class, 'createMainCategories'])->name('admin_create_main_c');
    Route::post('store-main-categories', [CategoriesController::class, 'storeMainCategories'])->name('admin_store_main_c');
    Route::delete('delete-main-categories/{category}', [CategoriesController::class, 'storeDeleteCategories'])->name('admin_delete_main_c');
    Route::get('edit-main-categories/{c}', [CategoriesController::class, 'storeEditCategories'])->name('admin_edit_main_c');
    Route::patch('update-main-categories/{c}', [CategoriesController::class, 'storeUpdateCategories'])->name('admin_update_main_c');

    Route::get('categories', [CategoriesController::class, 'viewCategories'])->name('admin_view_categories');
    Route::get('main-categories', [CategoriesController::class, 'mainCategories'])->name('admin_main_categories');
    Route::get('sub-categories', [CategoriesController::class, 'subCategories'])->name('admin_sub_categories');
});


$route  = Route::prefix("ädmin")->middleware("admin");
if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}
$route->group(function () {


    Route::get('admin/create-sub-categories', [SubCategories::class, 'createSubCategories'])->name('admin_create_sub_c');
    Route::post('admin/store-sub-categories', [SubCategories::class, 'storeSubCategories'])->name('admin_store_sub_c');

    Route::get('admin/edit-sub-categories/{c}', [SubCategories::class, 'storeEditCategories'])->name('admin_edit_sub_c');
    Route::patch('admin/update-sub-categories/{c}', [SubCategories::class, 'storeUpdateCategories'])->name('admin_update_sub_c');

    Route::delete('admin/delete-sub-categories/{category}', [SubCategories::class, 'storeDeleteCategories'])->name('admin_delete_sub_c');
});
