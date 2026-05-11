@extends('layouts.app')

@section('title', 'View Product - Grocery Stock Manager')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="bi bi-box-seam"></i> {{ $product->name }}</h3>
            <div class="gap-2">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>SKU:</strong> <code>{{ $product->sku }}</code></p>
                        <p><strong>Category:</strong> {{ $product->category->name }}</p>
                        <p><strong>Unit:</strong> {{ $product->unit }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Price:</strong> Rs. {{ number_format($product->price, 2) }}</p>
                        <p><strong>Cost Price:</strong> Rs. {{ number_format($product->cost_price, 2) }}</p>
                        <p>
                            <strong>Current Stock:</strong>
                            @if($product->current_stock <= 0)
                                <span class="badge bg-danger">{{ $product->current_stock }}</span>
                            @elseif($product->isLowStock())
                                <span class="badge bg-warning text-dark">{{ $product->current_stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->current_stock }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                @if($product->description)
                    <div class="mt-2">
                        <strong>Description:</strong>
                        <p class="text-muted mb-0">{{ $product->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Stock Actions</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.stock-in', $product) }}" class="row g-3 align-items-end mb-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Stock In (Add)</label>
                        <input type="number" class="form-control" name="quantity" min="1" placeholder="Qty" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="reference" placeholder="Reference (optional)">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success"><i class="bi bi-plus"></i> Add Stock</button>
                    </div>
                </form>
                <hr>
                <form method="POST" action="{{ route('products.stock-out', $product) }}" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Stock Out (Remove)</label>
                        <input type="number" class="form-control" name="quantity" min="1" max="{{ $product->current_stock }}" placeholder="Qty" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="reference" placeholder="Reference (optional)">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-dash"></i> Remove Stock</button>
                    </div>
                </form>
            </div>
        </div>

        <h5>Stock Movement History</h5>
        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Reference</th>
                            <th>User</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                        <tr>
                            <td>
                                @if($movement->type == 'in')
                                    <span class="badge bg-success">IN</span>
                                @else
                                    <span class="badge bg-danger">OUT</span>
                                @endif
                            </td>
                            <td>{{ $movement->quantity }} {{ $product->unit }}</td>
                            <td>{{ $movement->reference ?? '-' }}</td>
                            <td>{{ $movement->user->name ?? 'N/A' }}</td>
                            <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No stock movements yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">
            {{ $movements->links() }}
        </div>
    </div>
</div>
@endsection
