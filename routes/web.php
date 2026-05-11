<?php

use App\Http\Controllers\SaleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    Route::post('/products/{product}/stock-in', [StockMovementController::class, 'stockIn'])->name('products.stock-in');
    Route::post('/products/{product}/stock-out', [StockMovementController::class, 'stockOut'])->name('products.stock-out');

    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');

    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
