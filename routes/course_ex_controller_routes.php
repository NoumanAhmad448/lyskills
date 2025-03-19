<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseExController;

Route::middleware("auth")->group(function () {
    Route::get('create-pdf-file', [CourseExController::class, 'createPdf'])->name('create-pdf');
});
