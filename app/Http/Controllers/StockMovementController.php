<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function stockIn(Request $request, Product $product){
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $product) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => 'in',
                'quantity' => $request->quantity,
                'reference' => $request->reference,
                'notes' => $request->notes,
            ]);
            $product->increment('current_stock', $request->quantity);
        });
        return redirect()->route('products.show', $product)
            ->with('success', "Added {$request->quantity} {$product->unit} to stock.");

    }

    public function stockOut(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->current_stock,
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $product) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => 'out',
                'quantity' => $request->quantity,
                'reference' => $request->reference,
                'notes' => $request->notes,
            ]);

            $product->decrement('current_stock', $request->quantity);
        });
    }
}
