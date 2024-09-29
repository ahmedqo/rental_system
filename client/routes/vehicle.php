<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/vehicles', [VehicleController::class, 'index_view'])->name('views.vehicles.index');
    Route::get('/vehicles/store', [VehicleController::class, 'store_view'])->name('views.vehicles.store');
    Route::get('/vehicles/{id}/patch', [VehicleController::class, 'patch_view'])->name('views.vehicles.patch');
    Route::get('/vehicles/{id}/scene', [VehicleController::class, 'scene_view'])->name('views.vehicles.scene');

    Route::post('/vehicles/store', [VehicleController::class, 'store_action'])->name('actions.vehicles.store');
    Route::get('/vehicles/search', [VehicleController::class, 'search_action'])->name('actions.vehicles.search');
    Route::patch('/vehicles/{id}/patch', [VehicleController::class, 'patch_action'])->name('actions.vehicles.patch');
    Route::delete('/vehicles/{id}/clear', [VehicleController::class, 'clear_action'])->name('actions.vehicles.clear');
    Route::get('/vehicles/{id}/charges', [VehicleController::class, 'charges_action'])->name('actions.vehicles.charges');
    Route::get('/vehicles/{id}/info', [VehicleController::class, 'get_info_action'])->name('actions.vehicles.info');
    Route::get('/vehicles/{id}/chart', [VehicleController::class, 'chart_action'])->name('actions.vehicles.chart');

    Route::get('/vehicles/{id}/reservations/search', [VehicleController::class, 'search_reservations_action'])->name('actions.vehicles.reservations.search');
    Route::get('/vehicles/{id}/reservations/filter', [VehicleController::class, 'filter_reservations_action'])->name('actions.vehicles.reservations.filter');
    Route::get('/vehicles/{id}/recoveries/search', [VehicleController::class, 'search_recoveries_action'])->name('actions.vehicles.recoveries.search');
    Route::get('/vehicles/{id}/recoveries/filter', [VehicleController::class, 'filter_recoveries_action'])->name('actions.vehicles.recoveries.filter');
    Route::get('/vehicles/{id}/payments/search', [VehicleController::class, 'search_payments_action'])->name('actions.vehicles.payments.search');
    Route::get('/vehicles/{id}/payments/filter', [VehicleController::class, 'filter_payments_action'])->name('actions.vehicles.payments.filter');
    Route::get('/vehicles/{id}/charges/search', [VehicleController::class, 'search_charges_action'])->name('actions.vehicles.charges.search');
});
