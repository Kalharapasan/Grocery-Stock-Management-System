<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories - full CRUD
    Route::resource('categories', CategoryController::class);

    // Products - full CRUD
    Route::resource('products', ProductController::class);

    // Stock movements
    Route::post('/products/{product}/stock-in', [StockMovementController::class, 'stockIn'])->name('products.stock-in');
    Route::post('/products/{product}/stock-out', [StockMovementController::class, 'stockOut'])->name('products.stock-out');

    // Reports
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');

    // Sales - only index, create, store, show
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
