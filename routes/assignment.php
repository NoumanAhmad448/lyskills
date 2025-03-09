<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
    Route::post('/assignments/{assignment}/score', [AssignmentController::class, 'scoreUpdate'])->name('assignments.grade');
    Route::post('instructor/{course}/assigment', [AssignmentController::class, 'assign'])
        ->name('assign');
});
