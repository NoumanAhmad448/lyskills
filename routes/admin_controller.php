<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/admin', [AdminController::class, 'admin_panel'])->name('admin');
Route::post('/admin/post', [AdminController::class, 'login'])->name('admin_a');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/homepage', [AdminController::class, 'homepage'])->name('admin.homepage');
    Route::post('/admin/homepage/update', [AdminController::class, 'homepageUpdate'])->name('admin.homepage.update');
});

Route::prefix('admin')->middleware(['auth', 'admin', 'verified'])->group(function () {
    Route::get('send-email', [AdminController::class, 'sendEmail'])->name('a-send-email');
    Route::post('send-email', [AdminController::class, 'sendEmailPost'])->name('a-p-send-email');

    Route::get('admin/new-offline-enrollment', [AdminController::class, 'nEn'])->name('n_en');
    Route::post('admin/new-offline-enrollment/user/{user}/course/{course}', [AdminController::class, 'nEnP'])->name('n_en_p');

    Route::get('/course-history-delete', [AdminController::class, 'courseHistory'])->name('course_del');

    Route::get('/all-assignments', [AdminController::class, 'getAss'])->name('a-asses');

    Route::post('/all-assignments-sorting', [AdminController::class, 'assSorting'])->name('a_a_sorting');
    Route::get('/all-assignments-sorting', [AdminController::class, 'getAss']);

    Route::post('/all-assignments-searching', [AdminController::class, 'searching'])->name('a_a_searching');
    Route::get('/all-assignments-searching', [AdminController::class, 'getAss']);

    Route::get('/get-courses', [AdminController::class, 'viewCourse'])->name('a_courses');
    Route::post('/all-courses-sorting', [AdminController::class, 'courseSorting'])->name('a_c_sorting');
    Route::get('/all-courses-sorting', [AdminController::class, 'viewCourse']);

    Route::get('/course-xuesheng/{course}', [AdminController::class, 'xueshiXuesheng'])->name("xueshiXuesheng");
    Route::post('/course-xuesheng', [AdminController::class, 'xueshiXueshengPost'])->name("xueshiXueshengPost");

    Route::post('/all-courses-searching', [AdminController::class, 'courseSearching'])->name('a_c_searching');
    Route::get('/all-courses-searching', [AdminController::class, 'viewCourse']);

    Route::get('admin/password/change-password', [AdminController::class, 'changePassword'])->name('admin_change_pass');
    Route::patch('admin/password/change-password', [AdminController::class, 'changePasswordP'])->name('admin_p_change_pass');

    Route::get('admin/setting/payment-share-setting', [AdminController::class, 'sharePayment'])->name('a_share_payment');
    Route::post('admin/setting/payment-share-setting', [AdminController::class, 'sharePostPayment'])->name('a_p_share_payment');
    Route::get('admin/instructor-earning-detail/{id}', [AdminController::class, 'getInsDetailedEaning'])->name('total-earning-detail');
});
