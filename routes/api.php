<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TriggerController;
use App\Http\Controllers\Token\DeviceTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/{device}/token', [DeviceTokenController::class, 'create'])->name('device.token.create');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('device', DeviceController::class);

    Route::apiResource('trigger', TriggerController::class);

    Route::delete('/{device}/token', [DeviceTokenController::class, 'destroy'])->middleware(["ability:delete-token"])->name('device.token.destroy');
});



