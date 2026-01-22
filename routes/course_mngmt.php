<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEx3Controller;
use App\Http\Controllers\CourseExController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SayonaraController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

$route = Route::middleware(['web', 'auth']);
if (config("setting.enable_instructor_domain")) {
    $route->domain(config("setting.instructor_domain"));
}
$route->group(function () {
    Route::post('instructor/course/{course}/upload-bulk-loader', [VideoController::class, 'uploadBulkLoader'])
        ->name('bulk_loader');
    Route::get('course/{slug}/video/uploads/{video}', [CourseEx3Controller::class, 'showVideo'])->name('video-page');

    Route::get('download-certificate/{course_name}', [CourseExController::class, 'downloadCert'])->name('down-cert');

    // In your routes/web.php or routes/api.php (depending on your needs)

    Route::get('/certificates/verify/{slug}/{code}', [CertificateController::class, "getCert"])->name('certificates.verify');
    Route::get('/verification/{id}', [CertificateController::class , "getCertPdf"])->name('verification.get');

    Route::post('rating-course', [CourseExController::class, 'ratingCourse'])->name('rating-course');

    Route::post('instructor/course/{course_id}/manage/section_title', [DashboardController::class, 'course_curriculum_post'])
        ->name('courses_curriculum_post');

    Route::get('instructor/course/{course_id}/manage/curriculum', [DashboardController::class, 'course_curriculum'])
        ->name('courses_curriculum');

    Route::post('set-all-videos-downlabable/{course}', [CourseExController::class, 'setVidDown'])->name('setVidDown');

    Route::post('update-lecture-status/{media_id}', [VideoController::class, 'set_video_free'])->name('update-lecture-status');

    Route::post('e/{course_id}/{media_id}/edit_video', [VideoController::class, 'edit_video'])->name('e_video');

    Route::get('instructor/course/{course}/pricing', [PricingController::class, 'pricing'])
        ->name('pricing');

    Route::post('instructor/course/{course}/pricing', [PricingController::class, 'savePricing'])
        ->name('pricingPost');


    Route::get('instructor/course/{course}/promotion', [PromotionController::class, 'promotion'])
        ->name('promotion');

    Route::post('instructor/course/{course}/coupon', [PromotionController::class, 'saveCoupon'])
        ->name('saveCoupon');

    Route::post('instructor/coupon/{promotion}/update_coupon', [PromotionController::class, 'updateCoupon'])
        ->name('updateCoupon');

    Route::delete('instructor/coupon/{promotion}/delete_coupon', [PromotionController::class, 'deleteCoupon'])
        ->name('delete_coupon');

    Route::get('instructor/course/{course}/final_message', [SayonaraController::class, 'sayonara'])
        ->name('zaijian');

    Route::post('instructor/course/{course}/final_message', [SayonaraController::class, 'storeSayonara'])
        ->name('zaijianPost');

    Route::post('instructor/course/{course}/submit-course', [SayonaraController::class, 'submitCourse'])
        ->name('submitCourse');

    Route::post('/create_course', [CourseController::class, 'createCourse'])
        ->name('create_course');

    Route::get('courses/public-announcement', [CourseEx3Controller::class, 'publicAnn'])->name('public-ann');

    Route::post('courses/public-announcement', [CourseEx3Controller::class, 'publicAnnPost'])->name('public-ann-post');


    Route::post('instructor/course/{course}/course-image', [LandingPageController::class, 'course_img'])
        ->name('course_img');

    Route::post('instructor/course/{course}/course-video', [LandingPageController::class, 'course_vid'])
        ->name('course_vid');


    Route::get('instructor/course/{course}/setting-course-status', [CourseEx3Controller::class, 'setting'])
        ->name('setting');

    Route::post('instructor/course/{course}/setting-course-status', [CourseEx3Controller::class, 'PostSetting'])
        ->name('post_setting');

    Route::post('instructor/course/{course}/setting-delete-course', [CourseEx3Controller::class, 'delCourseSetting'])
        ->name('del-course_setting');
});
