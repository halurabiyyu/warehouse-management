<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InboundController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OutboundController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome2');
})->name('welcome2');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login-proses');

Route::middleware('auth')->group(function () {
    Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::resource('items', ItemController::class)->names('items');
    Route::resource('inbound', InboundController::class)->names('inbound');
    Route::resource('outbound', OutboundController::class)->names('outbound');
    Route::resource('stock-movement', StockMovementController::class)->names('stock-movement');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
