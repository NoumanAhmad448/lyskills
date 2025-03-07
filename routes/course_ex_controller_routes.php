<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseExController;


Route::middleware('auth')->get('instructor/comments/course/{course_name}', [CourseExController::class, 'comment'])->name('laoshi-comment');
Route::middleware('auth')->post('instructor/comments', [CourseExController::class, 'commentPost'])->name('laoshi-commentPost');
Route::middleware('auth')->patch('instructor/comments/update', [CourseExController::class, 'commentUpdate'])->name('laoshi-commentUpdate');
Route::middleware('auth')->post('instructor/comments/delete', [CourseExController::class, 'commentDelete'])->name('laoshi-commentDelete');

Route::middleware('auth')->get('laoshi-de/comments/{course}', [CourseExController::class, 'readComments'])->name('laoshi_de_c');

Route::middleware('auth')->post('set-all-videos-downlabable/{course}', [CourseExController::class, 'setVidDown'])->name('setVidDown');

Route::middleware('auth')->post('rating-course', [CourseExController::class, 'ratingCourse'])->name('rating-course');

Route::middleware('auth')->get('create-pdf-file', [CourseExController::class, 'createPdf'])->name('create-pdf');

Route::middleware('auth')->get('download-certificate/{course_name}', [CourseExController::class, 'downloadCert'])->name('down-cert');
