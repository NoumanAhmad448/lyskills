<?php

use App\Http\Controllers\HacksController;
use Illuminate\Support\Facades\Route;

Route::get("/change-config", [HacksController::class, "changeConfig"]);