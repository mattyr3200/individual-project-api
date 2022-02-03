<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TriggerController;
use App\Http\Controllers\TriggerLogController;
use App\Http\Controllers\StatusCheckController;
use App\Http\Controllers\Auth\Web\LoginController;
use App\Http\Controllers\Auth\Web\RegisterController;
use App\Http\Controllers\Tokens\DeviceTokenController;

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

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', RegisterController::class)->name('register');

Route::get("/status", StatusCheckController::class)->name('status');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/user", UserController::class)->name('user');

    Route::apiResource('device', DeviceController::class);

    Route::apiResource('trigger', TriggerController::class)->except('index');

    Route::post('/trigger/log', [TriggerLogController::class, 'store'])->middleware('ability:create-trigger-log')->name('trigger.log.store');

    Route::apiResource('triggerLog', TriggerLogController::class)->except('index');

    Route::get('/{device}/triggers', [TriggerController::class, 'index'])->name('trigger.index');

    Route::delete('/{device}/token', [DeviceTokenController::class, 'destroy'])->middleware(["ability:delete-token"])->name('device.token.destroy');
});



