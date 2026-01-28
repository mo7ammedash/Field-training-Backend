@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="mb-4">Dashboard</h1>

    {{-- Cards --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-4">{{ $totalProducts }}</p>
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">View Products</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text fs-4">{{ $totalCategories }}</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm">View Categories</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Suppliers</h5>
                    <p class="card-text fs-4">{{ $totalSuppliers }}</p>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-light btn-sm">View Suppliers</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest Products Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            Latest Products
        </div>
        <div class="card-body p-0">
            @if($latestProducts->count())
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Suppliers</th>
                            <th>Owner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? '—' }}</td>
                            <td>
                                @if($product->suppliers->count())
                                @foreach($product->suppliers as $supplier)
                                {{ $supplier->name }} (Cost: {{ $supplier->pivot->cost_price }}, Lead: {{ $supplier->pivot->lead_time_days }} days)<br>
                                @endforeach
                                @else
                                —
                                @endif
                            </td>
                            <td>{{ $product->user?->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-3 text-center text-muted">
                No products yet.
            </div>
            @endif
        </div>
    </div>

</div>
@endsection