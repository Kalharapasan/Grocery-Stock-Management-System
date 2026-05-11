@extends('layouts.app')

@section('title', 'Products - Grocery Stock Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-box-seam"></i> Products</h3>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Product
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="search" placeholder="Search by name or SKU..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary me-2"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>SKU</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Unit</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td><code>{{ $product->sku }}</code></td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $product->category->name }}</span></td>
                        <td>Rs. {{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->current_stock <= 0)
                                <span class="badge bg-danger">{{ $product->current_stock }}</span>
                            @elseif($product->current_stock <= $product->low_stock_threshold)
                                <span class="badge bg-warning text-dark">{{ $product->current_stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->current_stock }}</span>
                            @endif
                        </td>
                        <td>{{ $product->unit }}</td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info text-white" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $products->links() }}
</div>
@endsection
