@extends('layouts.app')

@section('title', 'View Category - Grocery Stock Manager')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="bi bi-tag"></i> {{ $category->name }}</h3>
            <div class="gap-2">
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Description:</strong> {{ $category->description ?? 'N/A' }}</p>
                <p><strong>Total Products:</strong> {{ $category->products->count() }}</p>
            </div>
        </div>

        <h5>Products in this Category</h5>
        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($category->products as $product)
                        <tr>
                            <td><code>{{ $product->sku }}</code></td>
                            <td>{{ $product->name }}</td>
                            <td>Rs. {{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->isLowStock())
                                    <span class="badge bg-danger">{{ $product->current_stock }}</span>
                                @else
                                    <span class="badge bg-success">{{ $product->current_stock }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">No products in this category.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
