<?php
use App\Http\Controllers\HealthCheckResultsController;
use Illuminate\Support\Facades\Route;


Route::prefix("dev")->middleware("is_dev")->group(function(){
    Route::get('/health', HealthCheckResultsController::class)->name('health');
});
