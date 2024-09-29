<?php


use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/subscribe', [CompanyController::class, 'store_view'])->name('views.companies.store');
Route::post('/subscribe', [CompanyController::class, 'store_action'])->name('actions.companies.store');
Route::get('/companies/csrf-token', function () {
    return csrf_token();
})->name('actions.companies.token');

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/company/patch', [CompanyController::class, 'patch_view'])->name('views.companies.patch');
    Route::patch('/company/patch', [CompanyController::class, 'patch_action'])->name('actions.companies.patch');
});
