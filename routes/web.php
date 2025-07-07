<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// Rute landing page / login
Route::get('/', function () {
    return view('auth.login');
});

    // Rute yang hanya bisa diakses setelah login
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
        // Rute Profil Bawaan Breeze
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Rute hanya untuk Admin
    Route::middleware('role:admin')->group(function() {
        // RUTE UNTUK DATA GRAFIK DASHBOARD
        Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart');
        // RUTE LAPORAN
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
        // RUTE MANAJEMEN USER

        // RUTE STOK MASUK
        Route::get('/stock-ins', [StockInController::class, 'index'])->name('stock-ins.index');
        Route::get('/stock-ins/create', [StockInController::class, 'create'])->name('stock-ins.create');
        Route::post('/stock-ins', [StockInController::class, 'store'])->name('stock-ins.store');

        // Tambahkan rute untuk laporan, manajemen user, dll.
        Route::resource('customers', \App\Http\Controllers\CustomerController::class);

        // RUTE PENGATURAN APLIKASI
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    });

    // Rute untuk Kasir (dan Admin juga bisa)
    Route::middleware('role:admin,kasir')->group(function() {
        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
        Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
        Route::get('/transaction/{sale}', [TransactionController::class, 'show'])->name('transaction.show');
        // Tambahkan rute untuk proses transaksi
    });


require __DIR__.'/auth.php';



