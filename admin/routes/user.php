<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/users', [AdminController::class, 'index_view'])->name('views.users.index');
    Route::get('/users/store', [AdminController::class, 'store_view'])->name('views.users.store');
    Route::get('/users/{id}/patch', [AdminController::class, 'patch_view'])->name('views.users.patch');

    Route::post('/users/store', [AdminController::class, 'store_action'])->name('actions.users.store');
    Route::get('/users/search', [AdminController::class, 'search_action'])->name('actions.users.search');
    Route::patch('/users/{id}/patch', [AdminController::class, 'patch_action'])->name('actions.users.patch');
    Route::delete('/users/{id}/clear', [AdminController::class, 'clear_action'])->name('actions.users.clear');
});
