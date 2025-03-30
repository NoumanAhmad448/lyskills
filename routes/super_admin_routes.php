<?php

use App\Http\Controllers\BloggerController;
use App\Http\Controllers\CreateSubAdminController;
use App\Http\Livewire\CreateBlogger;
use App\Http\Livewire\EditAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CreateAdmin as CreateAdminByAdmin;

$route = Route::domain(config("app.url"))->middleware("super_admin");
if (config("setting.enable_super_admin_domain")) {
    $route->domain(config("setting.super_admin_domain"));
}
$route->group(function () {

    Route::get('admin/edit-admin/{user}', EditAdmin::class)->name('edit_admin___');
    Route::delete('admin/delete-admin/{user}', [BloggerController::class, 'delete'])->name('delete_admin___');
    Route::get('admin/create-sub-admins', CreateAdminByAdmin::class)->name('create_admin');
    Route::post('admin/post-admins', [CreateSubAdminController::class, 'storeSubAdmin'])->name('store_admin');
    Route::get('admin/edit-bloggers/{user}', [BloggerController::class, 'edit'])->name('edit_blogger___');
    Route::delete('admin/delete-bloggers/{user}', [BloggerController::class, 'delete'])->name('delete_blogger___');
    Route::get('admin/create-bloggers', CreateBlogger::class)->name('create_blogger___');
    Route::post('admin/post-bloggers', [BloggerController::class, 'store_blogger'])->name('store_blogger___');
    Route::put('admin/create-bloggers/{user}', [BloggerController::class, 'updateBlogger'])->name('update_blogger___');
});
