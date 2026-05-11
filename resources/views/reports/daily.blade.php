@extends('layouts.app')

@section('title', 'Daily Report - Grocery Stock Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h3><i class="bi bi-file-earmark-bar-graph"></i> Daily Stock Report</h3>
    <button onclick="window.print()" class="btn btn-outline-secondary">
        <i class="bi bi-printer"></i> Print Report
    </button>
</div>

<div class="print-header" style="display:none;">
    <h4>Grocery Stock Manager — Daily Report</h4>
    <p class="text-muted mb-0">{{ $date->format('F d, Y') }}</p>
    <hr>
</div>

<div class="card mb-4 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.daily') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="date" class="form-label">Select Date</label>
                <input type="date" class="form-control" id="date" name="date"
                       value="{{ $date->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> View Report</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4 no-print">
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6>Total Stock In</h6>
                <h2>{{ $totalIn }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body text-center">
                <h6>Total Dispatched</h6>
                <h2>{{ $totalOut }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white {{ $netChange >= 0 ? 'bg-info' : 'bg-warning' }}">
            <div class="card-body text-center">
                <h6>Net Change</h6>
                <h2>{{ $netChange >= 0 ? '+' : '' }}{{ $netChange }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h6>Total Transactions</h6>
                <h2>{{ $movements->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-calendar-event"></i> Movements for {{ $date->format('F d, Y') }}
            @if($date->isToday()) <span class="badge bg-primary">Today</span> @endif
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Time</th>
                        <th>Product</th>
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
                        <td>{{ $movement->created_at->format('H:i:s') }}</td>
                        <td>
                            <a href="{{ route('products.show', $movement->product) }}" class="text-decoration-none">
                                <strong>{{ $movement->product->name }}</strong>
                            </a>
                            <br><small class="text-muted">{{ $movement->product->sku }}</small>
                        </td>
                        <td>
                            @if($movement->type === 'in')
                                <span class="badge bg-success"><i class="bi bi-arrow-down"></i> Stock In</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-truck"></i> Dispatched</span>
                            @endif
                        </td>
                        <td>{{ $movement->quantity }} {{ $movement->product->unit }}</td>
                        <td>{{ $movement->reference ?? '-' }}</td>
                        <td>{{ $movement->notes ?? '-' }}</td>
                        <td>{{ $movement->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No stock movements recorded for {{ $date->format('F d, Y') }}.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
@media print {
    .no-print { display: none !important; }
    .print-header { display: block !important; }
    nav, footer { display: none !important; }
    body { background: white !important; }
    .card { border: none !important; box-shadow: none !important; }
    .badge { border: 1px solid #ccc; color: #000 !important; background: none !important; }
}
</style>
@endsection
