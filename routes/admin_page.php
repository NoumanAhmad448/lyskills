<?php

use App\Http\Controllers\AdminPageController;
use Illuminate\Support\Facades\Route;

$route = Route::prefix("admin")->middleware("admin");

if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}
$route->group(function () {
    Route::post('page/{page}/change-status', [AdminPageController::class, 'changeStatus'])->name('admin_cs_page');
    Route::delete('page/{page}/delete-page', [AdminPageController::class, 'delete'])->name('admin_page_delete');
    Route::get('show-page', [AdminPageController::class, 'view'])->name('admin_v_page');
    Route::get('create-page', [AdminPageController::class, 'createPage'])->name('admin_c_page');
    Route::post('create-page', [AdminPageController::class, 'savePage'])->name('admin_s_page');

    Route::get('page/{page}/edit-page', [AdminPageController::class, 'editPage'])->name('admin_edit_page');
    Route::put('page/{page}/update-page', [AdminPageController::class, 'updatePage'])->name('admin_update_page');
});
