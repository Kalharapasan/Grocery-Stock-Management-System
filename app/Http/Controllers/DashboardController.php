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
        $lowStockProducts = Product::whereColumn('current_stock', '<=', 'low_stock_threshold')->with('category')->get();
        $expiringProducts = Product::whereNotNull('expiry_date')
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays(7))
            ->with('category')
            ->get();
        $expiredProducts = Product::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now())
            ->with('category')
            ->get();
        $todayMovements = StockMovement::whereDate('created_at', Carbon::today())->count();
        $recentMovements = StockMovement::with(['product', 'user'])->latest()->take(10)->get();
        $totalStockValue = Product::selectRaw('SUM(current_stock * price) as total')->value('total') ?? 0;

        // Chart Data: Last 7 days sales
        $salesData = [];
        $salesLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesLabels[] = $date->format('M d');
            $salesData[] = \App\Models\Sale::whereDate('created_at', $date)->sum('total_amount');
        }

        // Chart Data: Category distribution
        $categoriesData = Category::withCount('products')->get();
        $categoryLabels = $categoriesData->pluck('name');
        $categoryCounts = $categoriesData->pluck('products_count');

        return view('dashboard', compact(
            'totalProducts', 'totalCategories', 'lowStockProducts', 'expiringProducts', 'expiredProducts',
            'todayMovements', 'recentMovements', 'totalStockValue', 'salesData', 'salesLabels',
            'categoryLabels', 'categoryCounts'
        ));
    }
}
