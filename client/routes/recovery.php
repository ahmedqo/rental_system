<?php

use App\Http\Controllers\RecoveryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/recoveries', [RecoveryController::class, 'index_view'])->name('views.recoveries.index');
    Route::get('/recoveries/{id}/patch', [RecoveryController::class, 'patch_view'])->name('views.recoveries.patch');

    Route::get('/recoveries/search', [RecoveryController::class, 'search_action'])->name('actions.recoveries.search');
    Route::get('/recoveries/filter', [RecoveryController::class, 'filter_action'])->name('actions.recoveries.filter');
    Route::patch('/recoveries/{id}/patch', [RecoveryController::class, 'patch_action'])->name('actions.recoveries.patch');
});
