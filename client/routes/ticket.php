<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/tickets/store', [TicketController::class, 'store_view'])->name('views.tickets.store');
    Route::get('/tickets/{id}/scene', [TicketController::class, 'scene_view'])->name('views.tickets.scene');

    Route::get('/tickets/search', [TicketController::class, 'search_action'])->name('actions.tickets.search');
    Route::get('/tickets/filter', [TicketController::class, 'filter_action'])->name('actions.tickets.filter');
    Route::post('/tickets/store', [TicketController::class, 'store_action'])->name('actions.tickets.store');
    Route::get('/tickets/{id}/close', [TicketController::class, 'close_action'])->name('actions.tickets.close');
    Route::patch('/tickets/{id}/comment/store', [TicketController::class, 'patch_action'])->name('actions.tickets.patch');
});
