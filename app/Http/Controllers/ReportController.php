<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->filled('date') ? Carbon::parse($request->date) : Carbon::today();

        $movements = StockMovement::with(['product', 'user'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        $totalIn = $movements->where('type', 'in')->sum('quantity');
        $totalOut = $movements->where('type', 'out')->sum('quantity');
        $netChange = $totalIn - $totalOut;

        return view('reports.daily', compact('movements', 'date', 'totalIn', 'totalOut', 'netChange'));
    }
}
