@extends('layouts.app')

@section('title', 'Edit Category - Grocery Stock Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="mb-4"><i class="bi bi-pencil"></i> Edit Category</h3>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
