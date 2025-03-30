<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


$route = Route::prefix('admin')->middleware(['auth', 'admin']);

if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}

$route->group(function () {
    Route::post(
        'block-user/{user}',
        [UserController::class, 'blockUser']
    )->name('admin.user.update');
});
