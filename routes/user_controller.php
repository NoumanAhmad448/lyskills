<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::domain(config("app.url"))->group(function(){

    Route::get('/users', [UserController::class, 'index'])->name('a_users');
    Route::get('/edit-users/{user}', [UserController::class, 'edit'])->name('a_e_users');
Route::put('/update-users/{user}', [UserController::class, 'update'])->name('a_u_users');
Route::delete('/delete-users/{user}', [UserController::class, 'delete'])->name('a_d_users');

Route::post('/sorting-users', [UserController::class, 'sortingUser'])->name('sorting_users');
Route::get('/sorting-users', [UserController::class, 'index']);

Route::post('/search-users', [UserController::class, 'searchUser'])->name('search_users');
Route::get('/search-users', [UserController::class, 'index']);

});