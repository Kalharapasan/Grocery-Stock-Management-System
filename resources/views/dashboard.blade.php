@extends('layouts.app')

@section('title', 'Dashboard - Grocery Stock Manager')
@section('content')
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-box-seam"></i> Total Products</h5>
                    <h2>{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-tags"></i> Categories</h5>
                    <h2>{{ $totalCategories }}</h2>
                </div>
            </div>
        </div>



    </div>
