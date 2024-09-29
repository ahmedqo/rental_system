<?php


use App\Http\Controllers\AgencyController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/agencies', [AgencyController::class, 'index_view'])->name('views.agencies.index');
    Route::get('/agencies/store', [AgencyController::class, 'store_view'])->name('views.agencies.store');
    Route::get('/agencies/{id}/patch', [AgencyController::class, 'patch_view'])->name('views.agencies.patch');
    Route::get('/agencies/{id}/scene', [AgencyController::class, 'scene_view'])->name('views.agencies.scene');

    Route::post('/agencies/store', [AgencyController::class, 'store_action'])->name('actions.agencies.store');
    Route::get('/agencies/search', [AgencyController::class, 'search_action'])->name('actions.agencies.search');
    Route::get('/agencies/search/all', [AgencyController::class, 'search_all_action'])->name('actions.agencies.search.all');
    Route::patch('/agencies/{id}/patch', [AgencyController::class, 'patch_action'])->name('actions.agencies.patch');
    Route::delete('/agencies/{id}/clear', [AgencyController::class, 'clear_action'])->name('actions.agencies.clear');
    Route::get('/agencies/{id}/chart', [AgencyController::class, 'chart_action'])->name('actions.agencies.chart');

    Route::get('/agencies/{id}/reservations/search', [AgencyController::class, 'search_reservations_action'])->name('actions.agencies.reservations.search');
    Route::get('/agencies/{id}/reservations/filter', [AgencyController::class, 'filter_reservations_action'])->name('actions.agencies.reservations.filter');
    Route::get('/agencies/{id}/recoveries/search', [AgencyController::class, 'search_recoveries_action'])->name('actions.agencies.recoveries.search');
    Route::get('/agencies/{id}/recoveries/filter', [AgencyController::class, 'filter_recoveries_action'])->name('actions.agencies.recoveries.filter');
    Route::get('/agencies/{id}/payments/search', [AgencyController::class, 'search_payments_action'])->name('actions.agencies.payments.search');
    Route::get('/agencies/{id}/payments/filter', [AgencyController::class, 'filter_payments_action'])->name('actions.agencies.payments.filter');
});
