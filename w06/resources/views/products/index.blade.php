@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Products</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Suppliers</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td class="text-end">${{ number_format($product->price, 2) }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach($product->suppliers as $supplier)
                            <li>
                                <strong>{{ $supplier->name }}</strong> —
                                <span class="text-muted">Cost: ${{ number_format($supplier->pivot->cost_price, 2) }}, Lead: {{ $supplier->pivot->lead_time_days }} days</span>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection