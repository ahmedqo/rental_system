<?php


use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/companies', [CompanyController::class, 'index_view'])->name('views.companies.index');
    Route::get('/companies/store', [CompanyController::class, 'store_view'])->name('views.companies.store');
    Route::get('/companies/{id}/patch', [CompanyController::class, 'patch_view'])->name('views.companies.patch');
    Route::get('/companies/{id}/scene', [CompanyController::class, 'scene_view'])->name('views.companies.scene');

    Route::post('/companies/store', [CompanyController::class, 'store_action'])->name('actions.companies.store');
    Route::get('/companies/search', [CompanyController::class, 'search_action'])->name('actions.companies.search');
    Route::patch('/companies/{id}/patch', [CompanyController::class, 'patch_action'])->name('actions.companies.patch');
    Route::delete('/companies/{id}/clear', [CompanyController::class, 'clear_action'])->name('actions.companies.clear');
    Route::get('/companies/{id}/popular', [CompanyController::class, 'popular_action'])->name('actions.companies.popular');
    Route::get('/companies/{id}/chart', [CompanyController::class, 'chart_action'])->name('actions.companies.chart');

    Route::get('/companies/{id}/reservations/search', [CompanyController::class, 'search_reservations_action'])->name('actions.companies.reservations.search');
    Route::get('/companies/{id}/reservations/filter', [CompanyController::class, 'filter_reservations_action'])->name('actions.companies.reservations.filter');
    Route::get('/companies/{id}/recoveries/search', [CompanyController::class, 'search_recoveries_action'])->name('actions.companies.recoveries.search');
    Route::get('/companies/{id}/recoveries/filter', [CompanyController::class, 'filter_recoveries_action'])->name('actions.companies.recoveries.filter');
    Route::get('/companies/{id}/payments/search', [CompanyController::class, 'search_payments_action'])->name('actions.companies.payments.search');
    Route::get('/companies/{id}/payments/filter', [CompanyController::class, 'filter_payments_action'])->name('actions.companies.payments.filter');
    Route::get('/companies/{id}/charges/search', [CompanyController::class, 'search_charges_action'])->name('actions.companies.charges.search');
});
