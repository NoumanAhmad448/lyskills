<?php

use App\Http\Controllers\DeploymentController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get("/clear-cache", [DeploymentController::class, "clearCache"]);

Route::get("/live-deployment", [DeploymentController::class, "liveDeployment"]);

Route::post("/course-unerolle", [CourseController::class, "search_unenrolle"])->name("search_unenrolle");