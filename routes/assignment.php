<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')->middleware(['auth'])->group(function () {
    
});
