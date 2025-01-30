<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/trip-orders', [TripOrderController::class, 'index'])->name('trip-orders.index');
    Route::post('/trip-orders', [TripOrderController::class, 'store'])->name('trip-orders.store');
});
