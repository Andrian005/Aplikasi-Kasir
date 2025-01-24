<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('auth', [AuthController::class, 'auth'])->name('auth');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
