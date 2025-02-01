<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('auth', [AuthController::class, 'auth'])->name('auth');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('management-barang')->group(function () {
        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('management-barang.kategori.index');
            Route::get('view/{id?}', [KategoriController::class, 'view'])->name('management-barang.kategori.view');
            Route::get('create', [KategoriController::class, 'create'])->name('management-barang.kategori.create');
            Route::post('store', [KategoriController::class, 'store'])->name('management-barang.kategori.store');
            Route::get('edit/{id?}', [KategoriController::class, 'edit'])->name('management-barang.kategori.edit');
            Route::post('update/{id?}', [KategoriController::class, 'update'])->name('management-barang.kategori.update');
            Route::get('delete/{id?}', [KategoriController::class, 'delete'])->name('management-barang.kategori.delete');
        });
    });

    Route::prefix('user-management')->group(function () {
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('user-management.role.index');
            Route::get('view/{id?}', [RoleController::class, 'view'])->name('user-management.role.view');
            Route::get('create', [RoleController::class, 'create'])->name('user-management.role.create');
            Route::post('store', [RoleController::class, 'store'])->name('user-management.role.store');
            Route::get('edit/{id?}', [RoleController::class, 'edit'])->name('user-management.role.edit');
            Route::post('update/{id?}', [RoleController::class, 'update'])->name('user-management.role.update');
            Route::get('delete/{id?}', [RoleController::class, 'delete'])->name('user-management.role.delete');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user-management.user.index');
            Route::get('view/{id?}', [UserController::class, 'view'])->name('user-management.user.view');
            Route::get('create', [UserController::class, 'create'])->name('user-management.user.create');
            Route::post('store', [UserController::class, 'store'])->name('user-management.user.store');
            Route::get('edit/{id?}', [UserController::class, 'edit'])->name('user-management.user.edit');
            Route::post('update/{id?}', [UserController::class, 'update'])->name('user-management.user.update');
            Route::get('delete/{id?}', [UserController::class, 'delete'])->name('user-management.user.delete');
        });
    });
});
