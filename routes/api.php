<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChangeDeviceStatusController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\StatusCheckController;
use App\Http\Controllers\Tokens\DeviceTokenController;
use App\Http\Controllers\TriggerController;
use App\Http\Controllers\TriggerLogController;
use App\Http\Controllers\TriggerSummary\MonthlyDeviceTriggers;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TriggerSummary\WeeklyDeviceTriggers;
use App\Http\Controllers\TriggerSummary\YearlyDeviceTriggers;
use Illuminate\Support\Facades\Route;

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

Route::get('/{device}/token', [DeviceTokenController::class, 'create'])->name('device.token.create');

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', RegisterController::class)->name('register');

Route::get('/status', StatusCheckController::class)->name('status');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', LogoutController::class)->name('logout');

    Route::get('/device/status', StatusCheckController::class)->name('device.status'); // similar to one above for now
    Route::post('/{device}/arm', ChangeDeviceStatusController::class)->name('device.arm');;

    Route::get('/user', UserController::class)->name('user');

    Route::apiResource('device', DeviceController::class);

    Route::apiResource('trigger', TriggerController::class)->except('index');

    Route::post('/log', [TriggerLogController::class, 'store'])->name('trigger.log.store');

    Route::get('{device}/log/week', WeeklyDeviceTriggers::class)->name('weekly.triggers');
    Route::get('{device}/log/month', MonthlyDeviceTriggers::class)->name('monthly.triggers');
    Route::get('{device}/log/year', YearlyDeviceTriggers::class)->name('yearly.triggers');

    Route::get('/{device}/trigger/log', [TriggerLogController::class, 'index'])->name('trigger.log.index');

    Route::get('/{device}/triggers', [TriggerController::class, 'index'])->name('trigger.index');

    Route::delete('/{device}/token', [DeviceTokenController::class, 'destroy'])->middleware(['ability:delete-token'])->name('device.token.destroy');
});
