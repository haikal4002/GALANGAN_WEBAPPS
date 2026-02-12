<?php

use App\Http\Controllers\StockItemController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicInventoryController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;

// redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route Inventori Publik (Tanpa Login)
Route::get('/cek-stok', [PublicInventoryController::class, 'index'])->name('public.stok');

// ROute login & logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/master-data', [App\Http\Controllers\MasterDataController::class, 'index'])->name('master.index');

    Route::post('/master-product', [App\Http\Controllers\MasterDataController::class, 'storeMasterProduct'])->name('master-product.store');
    Route::put('/master-product/{id}', [App\Http\Controllers\MasterDataController::class, 'updateMasterProduct'])->name('master-product.update');
    Route::delete('/master-product/{id}', [App\Http\Controllers\MasterDataController::class, 'destroyMasterProduct'])->name('master-product.destroy');
    Route::post('/master-unit', [App\Http\Controllers\MasterDataController::class, 'storeMasterUnit'])->name('master-unit.store');
    Route::put('/master-unit/{id}', [App\Http\Controllers\MasterDataController::class, 'updateMasterUnit'])->name('master-unit.update');
    Route::delete('/master-unit/{id}', [App\Http\Controllers\MasterDataController::class, 'destroyMasterUnit'])->name('master-unit.destroy');

    Route::post('/supplier', [App\Http\Controllers\MasterDataController::class, 'storeSupplier'])->name('supplier.store');
    Route::put('/supplier/{id}', [App\Http\Controllers\MasterDataController::class, 'updateSupplier'])->name('supplier.update');
    Route::delete('/supplier/{id}', [App\Http\Controllers\MasterDataController::class, 'destroySupplier'])->name('supplier.destroy');

    Route::get('/stok', [StockItemController::class, 'index'])->name('stok.index');
    Route::get('/stok/{id}', [StockItemController::class, 'show'])->name('stok.show');
    Route::put('/stok/{id}/update', [StockItemController::class, 'updateItem'])->name('stok.update-price');

    Route::delete('/stok/{id}/destroy-unit', [StockItemController::class, 'destroyUnit'])->name('stok.destroy_unit');
    Route::post('/stok/break', [StockItemController::class, 'breakUnit'])->name('stok.break');

    Route::get('/pembelian', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::put('/pembelian/{id}/pay', [PurchaseController::class, 'markAsPaid'])->name('purchase.pay');

    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/process', [PosController::class, 'process'])->name('pos.process');
    // Page to view and filter history (opens dedicated page)
    Route::get('/pos/history/view', [PosController::class, 'historyPage'])->name('pos.history.view');
    // JSON endpoint used by frontend to fetch transactions (supports ?start=YYYY-MM-DD&end=YYYY-MM-DD)
    Route::get('/pos/history', [PosController::class, 'history'])->name('pos.history');
    // JSON detail endpoint for modal
    Route::get('/pos/history/{id}/detail', [PosController::class, 'detail'])->name('pos.history.detail');

    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    Route::get('/laporan/export', [ReportController::class, 'export'])->name('report.export');

    Route::get('/cash-flow', [CashflowController::class, 'index'])->name('cashflow.index');
    Route::post('/cash-flow', [CashflowController::class, 'store'])->name('cashflow.store');
    Route::delete('/cash-flow/{id}', [CashflowController::class, 'destroy'])->name('cashflow.destroy');
    Route::put('/cash-flow/{id}', [CashflowController::class, 'update'])->name('cashflow.update');

    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');

    // Route Kelola Kode
    Route::post('/transaction-codes', [ExpenseController::class, 'storeCode'])->name('codes.store');
    Route::delete('/transaction-codes/{id}', [ExpenseController::class, 'destroyCode'])->name('codes.destroy');

    // Route Profile / Pengaturan
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
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
