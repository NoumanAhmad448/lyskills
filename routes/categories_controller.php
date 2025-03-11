<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubCategories;

Route::get('categories', [CategoriesController::class, 'viewCategories'])->name('admin_view_categories');
Route::get('main-categories', [CategoriesController::class, 'mainCategories'])->name('admin_main_categories');
Route::get('sub-categories', [CategoriesController::class, 'subCategories'])->name('admin_sub_categories');

Route::prefix("ädmin")->middleware("admin")->group(function () {

    Route::get('create-main-categories', [CategoriesController::class, 'createMainCategories'])->name('admin_create_main_c');
    Route::post('store-main-categories', [CategoriesController::class, 'storeMainCategories'])->name('admin_store_main_c');

    Route::get('edit-main-categories/{c}', [CategoriesController::class, 'storeEditCategories'])->name('admin_edit_main_c');
    Route::patch('update-main-categories/{c}', [CategoriesController::class, 'storeUpdateCategories'])->name('admin_update_main_c');

    Route::delete('delete-main-categories/{category}', [CategoriesController::class, 'storeDeleteCategories'])->name('admin_delete_main_c');

    Route::get('admin/create-sub-categories', [SubCategories::class, 'createSubCategories'])->name('admin_create_sub_c');
    Route::post('admin/store-sub-categories', [SubCategories::class, 'storeSubCategories'])->name('admin_store_sub_c');

    Route::get('admin/edit-sub-categories/{c}', [SubCategories::class, 'storeEditCategories'])->name('admin_edit_sub_c');
    Route::patch('admin/update-sub-categories/{c}', [SubCategories::class, 'storeUpdateCategories'])->name('admin_update_sub_c');

    Route::delete('admin/delete-sub-categories/{category}', [SubCategories::class, 'storeDeleteCategories'])->name('admin_delete_sub_c');
});
