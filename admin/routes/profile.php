<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/profile/patch', [ProfileController::class, 'profile_view'])->name('views.profile.patch');
    Route::get('/password/patch', [ProfileController::class, 'password_view'])->name('views.password.patch');

    Route::patch('/profile/patch', [ProfileController::class, 'profile_action'])->name('actions.profile.patch');
    Route::patch('/password/patch', [ProfileController::class, 'password_action'])->name('actions.password.patch');
});
