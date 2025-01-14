<?php


use App\Http\Controllers\PreferenceController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/preferences/patch', [PreferenceController::class, 'patch_view'])->name('views.preferences.patch');
    Route::patch('/preferences/patch', [PreferenceController::class, 'patch_action'])->name('actions.preferences.patch');
});
