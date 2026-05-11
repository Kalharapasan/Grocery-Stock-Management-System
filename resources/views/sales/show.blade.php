@extends('layouts.app')

@section('title', 'Sale #' . $sale->id . ' - Grocery Stock Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="bi bi-receipt"></i> Sale #{{ $sale->id }}</h3>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Sales
            </a>
        </div>

        <div class="card mb-3">
            <div class="card-header"><strong>Sale Details</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Customer:</strong> {{ $sale->customer_name ?? 'Walk-in Customer' }}</p>
                        <p><strong>Phone:</strong> {{ $sale->customer_phone ?? 'N/A' }}</p>
                        <p><strong>Payment Method:</strong> <span class="badge bg-info text-dark">{{ ucfirst($sale->payment_method) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date:</strong> {{ $sale->created_at->format('Y-m-d H:i:s') }}</p>
                        <p><strong>Cashier:</strong> {{ $sale->user->name ?? 'N/A' }}</p>
                    </div>
                </div>
                @if($sale->notes)
                    <div class="mt-2">
                        <strong>Notes:</strong>
                        <p class="text-muted mb-0">{{ $sale->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><strong>Items Purchased</strong></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
                            <td>{{ $item->quantity }} {{ $item->product->unit ?? '' }}</td>
                            <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                            <td><strong>Rs. {{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                            <td>Rs. {{ number_format($sale->subtotal, 2) }}</td>
                        </tr>
                        @if($sale->tax_amount > 0)
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                            <td>+ Rs. {{ number_format($sale->tax_amount, 2) }}</td>
                        </tr>
                        @endif
                        @if($sale->discount_amount > 0)
                        <tr>
                            <td colspan="3" class="text-end"><strong>Discount:</strong></td>
                            <td class="text-danger">- Rs. {{ number_format($sale->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                            <td><h5 class="mb-0 text-primary">Rs. {{ number_format($sale->total_amount, 2) }}</h5></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Sale
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="bi bi-printer"></i> Print Receipt
            </button>
        </div>
    </div>
</div>
@endsection
