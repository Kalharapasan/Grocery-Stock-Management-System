@extends('layouts.app')

@section('title', $product->name . ' - Grocery Stock Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-box-seam"></i> {{ $product->name }}</h3>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><h6 class="mb-0">Product Details</h6></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><th width="40%">SKU:</th><td><code>{{ $product->sku }}</code></td></tr>
                    <tr><th>Category:</th><td><span class="badge bg-secondary">{{ $product->category->name }}</span></td></tr>
                    <tr><th>Unit:</th><td>{{ $product->unit }}</td></tr>
                    <tr><th>Selling Price:</th><td>Rs. {{ number_format($product->price, 2) }}</td></tr>
                    <tr><th>Cost Price:</th><td>Rs. {{ number_format($product->cost_price, 2) }}</td></tr>
                    <tr><th>Profit Margin:</th><td>Rs. {{ number_format($product->price - $product->cost_price, 2) }}</td></tr>
                    <tr>
                        <th>Current Stock:</th>
                        <td>
                            @if($product->current_stock <= 0)
                                <span class="badge bg-danger fs-6">{{ $product->current_stock }} {{ $product->unit }}</span>
                            @elseif($product->isLowStock())
                                <span class="badge bg-warning text-dark fs-6">{{ $product->current_stock }} {{ $product->unit }}</span>
                            @else
                                <span class="badge bg-success fs-6">{{ $product->current_stock }} {{ $product->unit }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Low Stock At:</th><td>{{ $product->low_stock_threshold }} {{ $product->unit }}</td></tr>
                    <tr><th>Stock Value:</th><td>Rs. {{ number_format($product->current_stock * $product->price, 2) }}</td></tr>
                </table>
                @if($product->description)
                    <hr>
                    <p class="text-muted mb-0">{{ $product->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-success">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-arrow-down-circle"></i> Stock In</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('products.stock-in', $product) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="stock_in_qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock_in_qty" name="quantity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock_in_ref" class="form-label">Reference (Invoice #)</label>
                        <input type="text" class="form-control" id="stock_in_ref" name="reference" placeholder="e.g. INV-001">
                    </div>
                    <div class="mb-3">
                        <label for="stock_in_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="stock_in_notes" name="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i> Add Stock
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0"><i class="bi bi-truck"></i> Dispatch to Customer</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('products.stock-out', $product) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="stock_out_qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock_out_qty" name="quantity"
                               min="1" max="{{ $product->current_stock }}" required>
                        <small class="text-muted">Available: {{ $product->current_stock }} {{ $product->unit }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="stock_out_ref" class="form-label">Customer / Reference</label>
                        <input type="text" class="form-control" id="stock_out_ref" name="reference" placeholder="e.g. Customer name, Order #">
                    </div>
                    <div class="mb-3">
                        <label for="stock_out_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="stock_out_notes" name="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100" {{ $product->current_stock <= 0 ? 'disabled' : '' }}>
                        <i class="bi bi-truck"></i> Dispatch
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Stock Movement History</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Reference</th>
                        <th>Notes</th>
                        <th>By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @if($movement->type === 'in')
                                <span class="badge bg-success"><i class="bi bi-arrow-down"></i> Stock In</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-truck"></i> Dispatched</span>
                            @endif
                        </td>
                        <td>{{ $movement->quantity }} {{ $product->unit }}</td>
                        <td>{{ $movement->reference ?? '-' }}</td>
                        <td>{{ $movement->notes ?? '-' }}</td>
                        <td>{{ $movement->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No stock movements for this product yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $movements->links() }}
</div>
@endsection
