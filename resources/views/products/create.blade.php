@extends('layouts.app')

@section('title', 'Create Product - Grocery Stock Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h3 class="mb-4"><i class="bi bi-plus-circle"></i> Create Product</h3>
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="card mb-3">
                <div class="card-header"><strong>Product Information</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SKU</label>
                            <input type="text" class="form-control" name="sku" value="{{ old('sku') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <select class="form-select" name="unit" required>
                                <option value="">Select Unit</option>
                                <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                                <option value="litre" {{ old('unit') == 'litre' ? 'selected' : '' }}>litre</option>
                                <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>pack</option>
                                <option value="dozen" {{ old('unit') == 'dozen' ? 'selected' : '' }}>dozen</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price (Rs.)</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price') }}" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cost Price (Rs.)</label>
                            <input type="number" step="0.01" class="form-control" name="cost_price" value="{{ old('cost_price') }}" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Stock</label>
                            <input type="number" class="form-control" name="current_stock" value="{{ old('current_stock', 0) }}" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Low Stock Threshold</label>
                            <input type="number" class="form-control" name="low_stock_threshold" value="{{ old('low_stock_threshold', 0) }}" min="0">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
