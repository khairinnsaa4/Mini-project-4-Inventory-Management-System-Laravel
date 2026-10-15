<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;

/*
|--------------------------------------------------------------------------
| Web Routes (Slide 12-16)
|--------------------------------------------------------------------------
*/

// Halaman root redirect ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Autentikasi Pengguna (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

// Logout (Authenticated Only)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman Terlindungi (Memerlukan Login - Slide 16 Grouping)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data Resource Routes (Slide 18)
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('suppliers', SupplierController::class)->except(['show', 'destroy']);

    // Transaksi & Mutasi Stok (Slide 25 & 26)
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/in', [StockController::class, 'in'])->name('in');
        Route::post('/in', [StockController::class, 'storeIn'])->name('storeIn');
        Route::get('/out', [StockController::class, 'out'])->name('out');
        Route::post('/out', [StockController::class, 'storeOut'])->name('storeOut');
        Route::get('/history', [StockController::class, 'history'])->name('history');
    });
});
