<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseExController;

Route::middleware("auth")->group(function () {
    Route::get('instructor/comments/course/{course_name}', [CourseExController::class, 'comment'])->name('laoshi-comment');
    Route::post('instructor/comments', [CourseExController::class, 'commentPost'])->name('laoshi-commentPost');
    Route::patch('instructor/comments/update', [CourseExController::class, 'commentUpdate'])->name('laoshi-commentUpdate');
    Route::post('instructor/comments/delete', [CourseExController::class, 'commentDelete'])->name('laoshi-commentDelete');

    Route::get('laoshi-de/comments/{course}', [CourseExController::class, 'readComments'])->name('laoshi_de_c');
    Route::post('set-all-videos-downlabable/{course}', [CourseExController::class, 'setVidDown'])->name('setVidDown');
    Route::post('rating-course', [CourseExController::class, 'ratingCourse'])->name('rating-course');
    Route::get('create-pdf-file', [CourseExController::class, 'createPdf'])->name('create-pdf');
    Route::get('download-certificate/{course_name}', [CourseExController::class, 'downloadCert'])->name('down-cert');
});
