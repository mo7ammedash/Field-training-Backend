@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">🗑 Trash</h1>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>

    @if($products->count() === 0)
    <div class="alert alert-info text-center">
        Trash is empty.
    </div>
    @else

    <table class="table table-bordered shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Supplier</th> 
                <th>Owner</th>
                <th>Deleted At</th>
                <th width="200">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category?->name }}</td>
                <td>
                    @foreach($product->suppliers as $supplier)
                    {{ $supplier->name }}
                    (Cost: {{ $supplier->pivot->cost_price }}, Lead: {{ $supplier->pivot->lead_time_days }} days)
                    <br>
                    @endforeach
                </td>

                <td>{{ $product->user?->email }}</td>
                <td>{{ $product->deleted_at }}</td>
                <td class="d-flex gap-2">

                    @can('restore', $product)
                    <form method="POST" action="{{ route('products.restore', $product->id) }}">
                        @csrf
                        <button class="btn btn-success btn-sm">Restore</button>
                    </form>
                    @endcan

                    @can('forceDelete', $product)
                    <form method="POST" action="{{ route('products.forceDelete', $product->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Force Delete</button>
                    </form>
                    @endcan

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $products->links() }}
    </div>

    @endif

</div>
@endsection