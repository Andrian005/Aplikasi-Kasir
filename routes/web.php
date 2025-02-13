<?php

use App\Http\Middleware\RoleMiddelware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TypePelangganController;
use App\Http\Controllers\LaporanTransaksiController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('auth', [AuthController::class, 'auth'])->name('auth');
Route::get('/not-found', function () {
    return view('errors.not-found');
})->name('not-found');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.dashboard');
        Route::get('view/{id?}', [DashboardController::class, 'view'])->name('dashboard.view.barang');
        Route::get('getCountPelanggan', [DashboardController::class, 'getCountPelanggan'])->name('dashboard.getCountPelanggan');
        Route::get('getCountBarang', [DashboardController::class, 'getCountBarang'])->name('dashboard.getCountBarang');
        Route::get('getCountLaporanTransaksi', [DashboardController::class, 'getCountLaporanTransaksi'])->name('dashboard.getCountLaporanTransaksi');
        Route::get('getBarang', [DashboardController::class, 'getBarang'])->name('dashboard.getBarang');
        Route::get('chart-data', [DashboardController::class, 'chart'])->name('dashboard.chart');
    });

    Route::prefix('kasir')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
        Route::get('get-pelanggan', [KasirController::class, 'getPelanggan'])->name('kasir.getPelanggan');
        Route::get('get-barang', [KasirController::class, 'getBarang'])->name('kasir.getBarang');
        Route::get('get-diskon/{type_pelanggan_id?}', [KasirController::class, 'getDiskon'])->name('kasir.getDiskon');
        Route::post('transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi');
        Route::get('invoice/{id?}', [KasirController::class, 'invoice'])->name('kasir.invoice');
        Route::get('invoice/download/{id}', [KasirController::class, 'downloadInvoice'])->name('kasir.invoice.download');
        Route::get('invoice/print/{id}', [KasirController::class, 'printInvoice'])->name('kasir.invoice.print');
    });

    Route::prefix('list-data')->middleware('role')->group(function () {
        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('list-data.kategori.index');
            Route::get('view/{id?}', [KategoriController::class, 'view'])->name('list-data.kategori.view');
            Route::get('create', [KategoriController::class, 'create'])->name('list-data.kategori.create');
            Route::post('store', [KategoriController::class, 'store'])->name('list-data.kategori.store');
            Route::get('edit/{id?}', [KategoriController::class, 'edit'])->name('list-data.kategori.edit');
            Route::post('update/{id?}', [KategoriController::class, 'update'])->name('list-data.kategori.update');
            Route::get('delete/{id?}', [KategoriController::class, 'delete'])->name('list-data.kategori.delete');
        });

        Route::prefix('diskon')->group(function () {
            Route::get('/', [DiskonController::class, 'index'])->name('list-data.diskon.index');
            Route::get('view/{id?}', [DiskonController::class, 'view'])->name('list-data.diskon.view');
            Route::get('create', [DiskonController::class, 'create'])->name('list-data.diskon.create');
            Route::post('store', [DiskonController::class, 'store'])->name('list-data.diskon.store');
            Route::get('edit/{id?}', [DiskonController::class, 'edit'])->name('list-data.diskon.edit');
            Route::post('update/{id?}', [DiskonController::class, 'update'])->name('list-data.diskon.update');
            Route::get('delete/{id?}', [DiskonController::class, 'delete'])->name('list-data.diskon.delete');
        });
    });

    Route::prefix('barang')->middleware('role')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('barang.index');
        Route::get('view/{id?}', [BarangController::class, 'view'])->name('barang.view');
        Route::get('create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('store', [BarangController::class, 'store'])->name('barang.store');
        Route::get('edit/{id?}', [BarangController::class, 'edit'])->name('barang.edit');
        Route::post('update/{id?}', [BarangController::class, 'update'])->name('barang.update');
        Route::get('delete/{id?}', [BarangController::class, 'delete'])->name('barang.delete');
    });

    Route::prefix('pelanggan')->middleware('role')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('view/{id?}', [PelangganController::class, 'view'])->name('pelanggan.view');
        Route::get('create', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('store', [PelangganController::class, 'store'])->name('pelanggan.store');
        Route::get('edit/{id?}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::post('update/{id?}', [PelangganController::class, 'update'])->name('pelanggan.update');
        Route::get('delete/{id?}', [PelangganController::class, 'delete'])->name('pelanggan.delete');
    });

    Route::prefix('laporan-transaksi')->group(function () {
        Route::get('/', [LaporanTransaksiController::class, 'index'])->name('laporan-transaksi.index');
        Route::get('view/{id?}', [LaporanTransaksiController::class, 'view'])->name('laporan-transaksi.view');
        Route::get('delete/{id?}', [LaporanTransaksiController::class, 'delete'])->name('laporan-transaksi.delete');
        Route::get('export-excel', [LaporanTransaksiController::class, 'excel'])->name('laporan-transaksi.export-excel');
        Route::get('export-pdf', [LaporanTransaksiController::class, 'pdf'])->name('laporan-transaksi.export-pdf');
    });

    Route::prefix('user-management')->middleware('role')->group(function () {
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
