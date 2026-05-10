<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockProducts = Product::whereColumn('current_stock', '<=', 'low_stock_threshold')
            ->with('category')->get();
        $todayMovements = StockMovement::whereDate('created_at', Carbon::today())->count();
        $recentMovements = StockMovement::with(['product', 'user'])->latest()->take(10)->get();
        $totalStockValue = Product::selectRaw('SUM(current_stock * price) as total')
            ->value('total') ?? 0;

        return view('dashboard', compact(
            'totalProducts', 'totalCategories', 'lowStockProducts',
            'todayMovements', 'recentMovements', 'totalStockValue'
        ));
    }
}
