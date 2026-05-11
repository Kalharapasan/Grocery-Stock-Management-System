@extends('layouts.app')

@section('title', 'Daily Report - Grocery Stock Manager')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="bi bi-file-earmark-bar-graph"></i> Daily Stock Movement Report</h3>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('reports.daily') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Select Date</label>
                        <input type="date" class="form-control" name="date" value="{{ $date->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> View</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Total IN</h5>
                        <h3>{{ $totalIn }} units</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5>Total OUT</h5>
                        <h3>{{ $totalOut }} units</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Net Change</h5>
                        <h3>{{ $netChange }} units</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Movements for {{ $date->format('F d, Y') }}</strong>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Time</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Qty</th>
                            <th>Reference</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                        <tr>
                            <td>{{ $movement->created_at->format('H:i') }}</td>
                            <td>{{ $movement->product->name ?? 'N/A' }}</td>
                            <td>
                                @if($movement->type == 'in')
                                    <span class="badge bg-success">IN</span>
                                @else
                                    <span class="badge bg-danger">OUT</span>
                                @endif
                            </td>
                            <td>{{ $movement->quantity }}</td>
                            <td>{{ $movement->reference ?? '-' }}</td>
                            <td>{{ $movement->user->name ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No movements on this date.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
