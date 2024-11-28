<?php

use App\Http\Controllers\CoreController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', function ($locale) {
    app()->setlocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('actions.language.index');

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/dashboard', [CoreController::class, 'index_view'])->name('views.core.index');
    Route::get('/notifications', [CoreController::class, 'notify_view'])->name('views.core.notify');

    Route::get('/data/popular', [CoreController::class, 'popular_action'])->name('actions.core.popular');
    Route::get('/data/notify', [CoreController::class, 'notify_action'])->name('actions.core.notify');
    Route::get('/data/chart', [CoreController::class, 'chart_action'])->name('actions.core.chart');
    Route::get('/data/read', [CoreController::class, 'read_action'])->name('actions.core.read');
});
