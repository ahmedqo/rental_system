<?php


use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/clients', [ClientController::class, 'index_view'])->name('views.clients.index');
    // Route::get('/clients/store', [ClientController::class, 'store_view'])->name('views.clients.store');
    Route::get('/clients/{id}/patch', [ClientController::class, 'patch_view'])->name('views.clients.patch');
    Route::get('/clients/{id}/scene', [ClientController::class, 'scene_view'])->name('views.clients.scene');

    // Route::post('/clients/store', [ClientController::class, 'store_action'])->name('actions.clients.store');
    Route::get('/clients/search', [ClientController::class, 'search_action'])->name('actions.clients.search');
    Route::get('/clients/search/all', [ClientController::class, 'search_all_action'])->name('actions.clients.search.all');
    Route::patch('/clients/{id}/patch', [ClientController::class, 'patch_action'])->name('actions.clients.patch');
    Route::delete('/clients/{id}/clear', [ClientController::class, 'clear_action'])->name('actions.clients.clear');
    Route::get('/clients/{id}/chart', [ClientController::class, 'chart_action'])->name('actions.clients.chart');

    Route::get('/clients/{id}/reservations/search', [ClientController::class, 'search_reservations_action'])->name('actions.clients.reservations.search');
    Route::get('/clients/{id}/reservations/filter', [ClientController::class, 'filter_reservations_action'])->name('actions.clients.reservations.filter');
    Route::get('/clients/{id}/recoveries/search', [ClientController::class, 'search_recoveries_action'])->name('actions.clients.recoveries.search');
    Route::get('/clients/{id}/recoveries/filter', [ClientController::class, 'filter_recoveries_action'])->name('actions.clients.recoveries.filter');
    Route::get('/clients/{id}/payments/search', [ClientController::class, 'search_payments_action'])->name('actions.clients.payments.search');
    Route::get('/clients/{id}/payments/filter', [ClientController::class, 'filter_payments_action'])->name('actions.clients.payments.filter');
});
