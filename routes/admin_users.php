<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::post('block-user/{user}',
     [UserController::class, 'blockUser'])->name('admin.user.update');
});