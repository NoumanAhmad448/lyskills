<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseExController;

Route::middleware("auth")->group(function () {
    Route::post('rating-course', [CourseExController::class, 'ratingCourse'])->name('rating-course');
    Route::get('create-pdf-file', [CourseExController::class, 'createPdf'])->name('create-pdf');
    Route::get('download-certificate/{course_name}', [CourseExController::class, 'downloadCert'])->name('down-cert');
});
