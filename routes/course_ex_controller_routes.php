<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseExController;

Route::domain(config("app.url"))->middleware("auth")->group(function () {
    Route::get('create-pdf-file', [CourseExController::class, 'createPdf'])->name('create-pdf');
});
