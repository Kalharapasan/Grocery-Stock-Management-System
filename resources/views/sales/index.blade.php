@extends('layouts.app')

@section('title', 'Sales - Grocery Stock Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-cart-check"></i> Sales</h3>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> New Sale
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Items</th>
                        <th>Date</th>
                        <th>Cashier</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td><code>#{{ $sale->id }}</code></td>
                        <td>{{ $sale->customer_name ?? 'Walk-in' }}</td>
                        <td>{{ $sale->customer_phone ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ ucfirst($sale->payment_method) }}</span></td>
                        <td><strong>Rs. {{ number_format($sale->total_amount, 2) }}</strong></td>
                        <td>{{ $sale->items->count() }}</td>
                        <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $sale->user->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info text-white" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No sales recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $sales->links() }}
</div>
@endsection
