<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/reservations', [ReservationController::class, 'index_view'])->name('views.reservations.index');
    // Route::get('/reservations/store', [ReservationController::class, 'store_view'])->name('views.reservations.store');
    Route::get('/reservations/{id}/patch', [ReservationController::class, 'patch_view'])->name('views.reservations.patch');
    Route::get('/reservations/{id}/print', [ReservationController::class, 'print_view'])->name('views.reservations.print');

    // Route::post('/reservations/store', [ReservationController::class, 'store_action'])->name('actions.reservations.store');
    Route::get('/reservations/search', [ReservationController::class, 'search_action'])->name('actions.reservations.search');
    Route::get('/reservations/filter', [ReservationController::class, 'filter_action'])->name('actions.reservations.filter');
    Route::patch('/reservations/{id}/patch', [ReservationController::class, 'patch_action'])->name('actions.reservations.patch');
});
