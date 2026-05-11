@extends('layouts.app')

@section('title', 'Dashboard - Grocery Stock Manager')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Products</h6>
                        <h2 class="mb-0">{{ $totalProducts }}</h2>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Categories</h6>
                        <h2 class="mb-0">{{ $totalCategories }}</h2>
                    </div>
                    <i class="bi bi-tags fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Low Stock Items</h6>
                        <h2 class="mb-0">{{ $lowStockProducts->count() }}</h2>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Today's Movements</h6>
                        <h2 class="mb-0">{{ $todayMovements }}</h2>
                    </div>
                    <i class="bi bi-arrow-left-right fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card bg-warning bg-opacity-10 border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 text-warning">Total Stock Value</h6>
                        <h3 class="mb-0">Rs. {{ number_format($totalStockValue, 2) }}</h3>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@if($lowStockProducts->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Low Stock Alerts</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Threshold</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                            <tr>
                                <td><strong>{{ $product->name }}</strong> <small class="text-muted">({{ $product->sku }})</small></td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $product->current_stock }} {{ $product->unit }}</span>
                                </td>
                                <td>{{ $product->low_stock_threshold }} {{ $product->unit }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-plus-circle"></i> Stock In
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Stock Movements</h5>
                <a href="{{ route('reports.daily') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Reference</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMovements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $movement->product->name }}</td>
                                <td>
                                    @if($movement->type === 'in')
                                        <span class="badge bg-success"><i class="bi bi-arrow-down"></i> Stock In</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-arrow-up"></i> Stock Out</span>
                                    @endif
                                </td>
                                <td>{{ $movement->quantity }} {{ $movement->product->unit }}</td>
                                <td>{{ $movement->reference ?? '-' }}</td>
                                <td>{{ $movement->user->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No stock movements recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
