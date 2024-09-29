<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/payments', [PaymentController::class, 'index_view'])->name('views.payments.index');
    Route::get('/payments/{id}/patch', [PaymentController::class, 'patch_view'])->name('views.payments.patch');
    Route::get('/payments/{id}/print', [PaymentController::class, 'print_view'])->name('views.payments.print');

    Route::get('/payments/search', [PaymentController::class, 'search_action'])->name('actions.payments.search');
    Route::get('/payments/filter', [PaymentController::class, 'filter_action'])->name('actions.payments.filter');
    Route::patch('/payments/{id}/patch', [PaymentController::class, 'patch_action'])->name('actions.payments.patch');
});
