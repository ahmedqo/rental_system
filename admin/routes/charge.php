<?php

use App\Http\Controllers\ChargeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/charges', [ChargeController::class, 'index_view'])->name('views.charges.index');
    // Route::get('/charges/store', [ChargeController::class, 'store_view'])->name('views.charges.store');
    Route::get('/charges/{id}/patch', [ChargeController::class, 'patch_view'])->name('views.charges.patch');

    // Route::post('/charges/store', [ChargeController::class, 'store_action'])->name('actions.charges.store');
    Route::get('/charges/search', [ChargeController::class, 'search_action'])->name('actions.charges.search');
    Route::patch('/charges/{id}/patch', [ChargeController::class, 'patch_action'])->name('actions.charges.patch');
    Route::delete('/charges/{id}/clear', [ChargeController::class, 'clear_action'])->name('actions.charges.clear');
});
