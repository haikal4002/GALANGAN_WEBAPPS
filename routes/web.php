<?php

use App\Http\Controllers\StockItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// ROute login & logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/master-stock', [StockItemController::class, 'index'])->name('stok.index');
    Route::post('/master-stock', [StockItemController::class, 'store'])->name('stok.store');
    Route::post('/master-product', [StockItemController::class, 'storeMasterProduct'])->name('master-product.store');
    Route::delete('/master-product/{id}', [StockItemController::class, 'destroyMasterProduct'])->name('master-product.destroy');
    Route::post('/supplier', [StockItemController::class, 'storeSupplier'])->name('supplier.store');
    Route::delete('/supplier/{id}', [StockItemController::class, 'destroySupplier'])->name('supplier.destroy');
    Route::get('/stok', [StockItemController::class, 'index'])->name('stok.index');
    Route::get('/stok/{id}', [StockItemController::class, 'show'])->name('stok.show');

});

Route::middleware(['auth', 'is_admin'])->group(function () {

    // Form tambah barang
    Route::get('/stok/create', [StockItemController::class, 'create'])->name('stok.create');
    // Proses simpan
    Route::post('/stok', [StockItemController::class, 'store'])->name('stok.store');
    // Form edit
    Route::get('/stok/{id}/edit', [StockItemController::class, 'edit'])->name('stok.edit');
    // Proses update
    Route::put('/stok/{id}', [StockItemController::class, 'update'])->name('stok.update');
    // Proses hapus
    Route::delete('/stok/{id}', [StockItemController::class, 'destroy'])->name('stok.destroy');

});
