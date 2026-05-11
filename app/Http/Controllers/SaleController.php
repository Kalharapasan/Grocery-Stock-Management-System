<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'customer_name'  => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|in:cash,card,mobile',
            'tax_amount'     => 'nullable|numeric|min:0',
            'discount_amount'=> 'nullable|numeric|min:0',
            'notes'          => 'nullable|string',
            'items'          => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
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
                'user_id'        => Auth::id(),
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'payment_method' => $request->payment_method,
                'subtotal'       => $total,
                'tax_amount'     => $request->tax_amount ?: 0,
                'discount_amount'=> $request->discount_amount ?: 0,
                'total_amount'   => $total + ($request->tax_amount ?: 0) - ($request->discount_amount ?: 0),
                'notes'          => $request->notes,
            ]);

            foreach ($lines as ['product' => $product, 'item' => $item, 'subtotal' => $subtotal]) {
                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal'   => $subtotal,
                ]);

                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id'    => Auth::id(),
                    'type'       => 'out',
                    'quantity'   => $item['quantity'],
                    'reference'  => "Sale #{$sale->id}",
                    'notes'      => $request->customer_name ? "Customer: {$request->customer_name}" : null,
                ]);

                $product->decrement('current_stock', $item['quantity']);
            }

            session(['last_sale_id' => $sale->id]);
        });

        return redirect()->route('sales.show', session('last_sale_id'))
            ->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product', 'user');
        return view('sales.show', compact('sale'));
    }
}
