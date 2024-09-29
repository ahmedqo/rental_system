<?php

use App\Http\Controllers\RestrictionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/restrictions', [RestrictionController::class, 'index_view'])->name('views.restrictions.index');
    // Route::get('/restrictions/store', [RestrictionController::class, 'store_view'])->name('views.restrictions.store');
    Route::get('/restrictions/{id}/patch', [RestrictionController::class, 'patch_view'])->name('views.restrictions.patch');

    // Route::post('/restrictions/store', [RestrictionController::class, 'store_action'])->name('actions.restrictions.store');
    Route::get('/restrictions/search', [RestrictionController::class, 'search_action'])->name('actions.restrictions.search');
    Route::patch('/restrictions/{id}/patch', [RestrictionController::class, 'patch_action'])->name('actions.restrictions.patch');
    Route::delete('/restrictions/{id}/clear', [RestrictionController::class, 'clear_action'])->name('actions.restrictions.clear');
});
