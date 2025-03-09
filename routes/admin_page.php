<?php

use App\Http\Controllers\AdminPageController;
use Illuminate\Support\Facades\Route;

Route::middleware("admin")->group(function () {
    Route::post('admin/page/{page}/change-status', [AdminPageController::class, 'changeStatus'])->name('admin_cs_page');
    Route::delete('admin/page/{page}/delete-page', [AdminPageController::class, 'delete'])->name('admin_page_delete');
    Route::get('admin/show-page', [AdminPageController::class, 'view'])->name('admin_v_page');
    Route::get('admin/create-page', [AdminPageController::class, 'createPage'])->name('admin_c_page');
    Route::post('admin/create-page', [AdminPageController::class, 'savePage'])->name('admin_s_page');

    Route::get('admin/page/{page}/edit-page', [AdminPageController::class, 'editPage'])->name('admin_edit_page');
    Route::put('admin/page/{page}/update-page', [AdminPageController::class, 'updatePage'])->name('admin_update_page');
});
