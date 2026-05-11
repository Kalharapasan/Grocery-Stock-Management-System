@extends('layouts.app')

@section('title', $category->name . ' - Grocery Stock Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-tag"></i> {{ $category->name }}</h3>
    <div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

@if($category->description)
<p class="text-muted mb-4">{{ $category->description }}</p>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-box-seam"></i> Products in this Category</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category->products as $product)
                    <tr>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td><code>{{ $product->sku }}</code></td>
                        <td>Rs. {{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->current_stock <= 0)
                                <span class="badge bg-danger">{{ $product->current_stock }} {{ $product->unit }}</span>
                            @elseif($product->isLowStock())
                                <span class="badge bg-warning text-dark">{{ $product->current_stock }} {{ $product->unit }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->current_stock }} {{ $product->unit }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No products in this category yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
