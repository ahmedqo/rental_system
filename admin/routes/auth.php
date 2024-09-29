<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [AuthController::class, 'login_view'])->name('views.login.index');
    Route::get('/forgot', [AuthController::class, 'blank_view'])->name('views.blank.index');
    Route::get('/reset/{token}', [AuthController::class, 'reset_view'])->name('views.reset.index');

    Route::post('/login', [AuthController::class, 'login_action'])->name('actions.login.index');
    Route::post('/forgot', [AuthController::class, 'blank_action'])->name('actions.blank.index');
    Route::post('/reset/{token}', [AuthController::class, 'reset_action'])->name('actions.reset.index');
});

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::post('/logout', [AuthController::class, 'close_action'])->name('actions.close.index');
});
