<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

$route = Route::prefix("admin");
if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}

$route->group(function () {

    Route::get('/', [AdminController::class, 'admin_panel'])->name('admin');
    Route::post('/post', [AdminController::class, 'login'])->name('admin_a');
});

$route = Route::prefix('admin')->middleware(['auth', 'admin']);
if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}

$route->group(function () {

    Route::get('/homepage', [AdminController::class, 'homepage'])->name('admin.homepage');
    Route::post('/homepage/update', [AdminController::class, 'homepageUpdate'])->name('admin.homepage.update');
});

$route = Route::prefix('admin')->middleware(['auth', 'admin', 'verified']);

if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}

$route->group(function () {

    Route::get('send-email', [AdminController::class, 'sendEmail'])->name('a-send-email');
    Route::post('send-email', [AdminController::class, 'sendEmailPost'])->name('a-p-send-email');

    Route::get('new-offline-enrollment', [AdminController::class, 'nEn'])->name('n_en');
    Route::post('new-offline-enrollment/user/{user}/course/{course}', [AdminController::class, 'nEnP'])->name('n_en_p');

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

    Route::get('password/change-password', [AdminController::class, 'changePassword'])->name('admin_change_pass');
    Route::patch('password/change-password', [AdminController::class, 'changePasswordP'])->name('admin_p_change_pass');

    Route::get('setting/payment-share-setting', [AdminController::class, 'sharePayment'])->name('a_share_payment');
    Route::post('setting/payment-share-setting', [AdminController::class, 'sharePostPayment'])->name('a_p_share_payment');
    Route::get('instructor-earning-detail/{id}', [AdminController::class, 'getInsDetailedEaning'])->name('total-earning-detail');
});
