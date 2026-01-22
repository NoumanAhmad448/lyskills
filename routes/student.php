<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseEx2Controller;
use App\Http\Controllers\CourseEx3Controller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::domain(config("app.url"))->middleware(['web', 'auth'])->group(function () {

    Route::get('student/email-to-instructor', [CourseEx2Controller::class, 'emailToIns'])->name('email_to_ins');
    Route::post('student/email-to-instructor', [CourseEx2Controller::class, 'emailToInsPost'])->name('email_to_ins_post');

    Route::put('instructor/quiz/{quizzes}/update_quiz', [QuizController::class, 'updateQuiz'])
        ->name('update_quizzes');

    Route::delete('instructor/quiz/{quizzes}/delete-quizzes', [QuizController::class, 'deleteQuizzes'])
        ->name('del_quizzes');

    Route::post('instructor/course/{course}/change-the-course-url', [CourseEx3Controller::class, 'changeURL'])
        ->name('course-change-url');

    Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
    Route::post('/assignments/{assignment}/score', [AssignmentController::class, 'scoreUpdate'])->name('assignments.grade');
    Route::post('instructor/{course}/assigment', [AssignmentController::class, 'assign'])
        ->name('assign');
    Route::post('student/wish-list-courses/{slug}', [StudentController::class, 'wishlistCourse'])->name('wishlist-course-post');
    Route::post('student/course/coupon', [CourseEx2Controller::class, 'coupon'])->name('coupon');
    Route::post('student/course/enroll-now/{course}', [CourseEx2Controller::class, 'enrollNow'])->name('enroll-now');

    Route::get('student/wish-list-courses', [StudentController::class, 'getWishlistCourse'])->name('get-wishlist-course');
    Route::get('inst/student/my-learning', [CourseEx2Controller::class, 'myLearning'])->name('myLearning');

    Route::get('course/{slug}/available-payment-methods', [PaymentController::class, 'availablePayMe'])->name('a_payment_methods');
    Route::get('course/{slug}/payment-with-credit-card', [PaymentController::class, 'creditPayment'])->name('credit_card_payment');
    Route::post('course/{slug}/payment-with-credit-card', [PaymentController::class, 'creditPaymentPost'])->name('credit_card_pay_post');

    Route::get('student/payment-history', [PaymentController::class, 'paymentHis'])->name('pay_his');

    Route::post('student/offline-payment', [CourseEx2Controller::class, 'offlinePayment'])->name('offline-payment');
    Route::get('student/get-certificate', [CourseEx2Controller::class, 'getCerti'])->name('getCerti');
    Route::post('crop-image-upload', [ProfileController::class, 'uploadCropImage'])->name('upload_profile');
});
