<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')->latest()->paginate(15);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('current_stock', '>', 0)->orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () {
            $total = 0;
            $lines = [];
            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->current_stock < $item['quantity']) {
                    abort(422, "Insufficient stock for {$product->name}.");
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                $lines[] = compact('product', 'item', 'subtotal');
            }

            $sale = Sale::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'total_amount' => $total,
                'notes' => $request->notes,
            ]);

            foreach ($lines as $line) {
                $product = $line['product'];
                $item = $line['item'];
                $subtotal = $line['subtotal'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference' => "Sale #{$sale->id}",
                    'notes' => $request->customer_name ? "Customer: {$request->customer_name}" : null,
                ]);

                $product->decrement('current_stock', $item['quantity']);
            }
            session(['last_sale_id' => $sale->id]);
        });

    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
