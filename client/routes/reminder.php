<?php

use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/reminders', [ReminderController::class, 'index_view'])->name('views.reminders.index');
    Route::get('/reminders/store', [ReminderController::class, 'store_view'])->name('views.reminders.store');
    Route::get('/reminders/{id}/patch', [ReminderController::class, 'patch_view'])->name('views.reminders.patch');

    Route::post('/reminders/store', [ReminderController::class, 'store_action'])->name('actions.reminders.store');
    Route::get('/reminders/search', [ReminderController::class, 'search_action'])->name('actions.reminders.search');
    Route::patch('/reminders/{id}/patch', [ReminderController::class, 'patch_action'])->name('actions.reminders.patch');
    Route::delete('/reminders/{id}/clear', [ReminderController::class, 'clear_action'])->name('actions.reminders.clear');
});
