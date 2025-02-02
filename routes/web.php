<?php

use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TypePelangganController;

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

        Route::prefix('barang')->group(function () {
            Route::get('/', [BarangController::class, 'index'])->name('management-barang.barang.index');
            Route::get('view/{id?}', [BarangController::class, 'view'])->name('management-barang.barang.view');
            Route::get('create', [BarangController::class, 'create'])->name('management-barang.barang.create');
            Route::post('store', [BarangController::class, 'store'])->name('management-barang.barang.store');
            Route::get('edit/{id?}', [BarangController::class, 'edit'])->name('management-barang.barang.edit');
            Route::post('update/{id?}', [BarangController::class, 'update'])->name('management-barang.barang.update');
            Route::get('delete/{id?}', [BarangController::class, 'delete'])->name('management-barang.barang.delete');
        });
    });

    Route::prefix('management-pelanggan')->group(function () {
        Route::prefix('type-pelanggan')->group(function () {
            Route::get('/', [TypePelangganController::class, 'index'])->name('management-pelanggan.type-pelanggan.index');
            Route::get('view/{id?}', [TypePelangganController::class, 'view'])->name('management-pelanggan.type-pelanggan.view');
            Route::get('create', [TypePelangganController::class, 'create'])->name('management-pelanggan.type-pelanggan.create');
            Route::post('store', [TypePelangganController::class, 'store'])->name('management-pelanggan.type-pelanggan.store');
            Route::get('edit/{id?}', [TypePelangganController::class, 'edit'])->name('management-pelanggan.type-pelanggan.edit');
            Route::post('update/{id?}', [TypePelangganController::class, 'update'])->name('management-pelanggan.type-pelanggan.update');
            Route::get('delete/{id?}', [TypePelangganController::class, 'delete'])->name('management-pelanggan.type-pelanggan.delete');
        });

        Route::prefix('pelanggan')->group(function () {
            Route::get('/', [PelangganController::class, 'index'])->name('management-pelanggan.pelanggan.index');
            Route::get('view/{id?}', [PelangganController::class, 'view'])->name('management-pelanggan.pelanggan.view');
            Route::get('create', [PelangganController::class, 'create'])->name('management-pelanggan.pelanggan.create');
            Route::post('store', [PelangganController::class, 'store'])->name('management-pelanggan.pelanggan.store');
            Route::get('edit/{id?}', [PelangganController::class, 'edit'])->name('management-pelanggan.pelanggan.edit');
            Route::post('update/{id?}', [PelangganController::class, 'update'])->name('management-pelanggan.pelanggan.update');
            Route::get('delete/{id?}', [PelangganController::class, 'delete'])->name('management-pelanggan.pelanggan.delete');
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
