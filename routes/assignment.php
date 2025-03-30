<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;


Route::domain(config("app.url"))->prefix('user')->middleware(['auth'])->group(function () {
    
});
