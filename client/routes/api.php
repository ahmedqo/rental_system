<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/companies/{id}/upload', [CompanyController::class, 'image_action'])->name('actions.companies.image');
Route::get('/data/notify', [CoreController::class, 'notify_action'])->name('actions.core.notify');
Route::get('/data/read', [CoreController::class, 'read_action'])->name('actions.core.read');
