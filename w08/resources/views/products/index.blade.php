@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Guest Alert --}}
    @guest
    <div class="alert alert-info text-center mb-4 shadow-sm">
        <h5 class="fw-bold mb-2">👋 Welcome, Guest!</h5>
        <p class="mb-2">
            You are viewing the products as a guest. You cannot add, edit, or delete products.
        </p>
        <p>
            To manage products, please
            <a href="{{ route('register') }}" class="fw-semibold">register</a>
            or
            <a href="{{ route('login') }}" class="fw-semibold">login</a>.
        </p>
    </div>
    @endguest

    {{-- Admin Alert --}}
    @auth
    @if(auth()->user()->role === 'admin')
    <div class="alert alert-warning text-center mb-4 shadow-sm">
        <h5 class="fw-bold mb-2">👋 Welcome, Admin!</h5>
        <p class="mb-2">
            You can view, add, edit, and delete all products from all users.
        </p>
    </div>
    @endif
    @endauth

    {{-- Header (عند وجود منتجات) --}}
    @if($products->count() > 0)
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark">Product List</h1>
            <div class="text-muted">Manage products and their suppliers</div>
            <hr>
        </div>

        {{-- زر Add Product يظهر للـ User والـ Admin --}}
        @auth
        <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Product</a>
        @endauth
    </div>
    @endif

    {{-- Empty State (لا منتجات) --}}
    @if($products->count() === 0)
    <div class="alert alert-info text-center py-5 shadow-sm">
        <h4 class="fw-bold mb-3">No products found</h4>
        <p class="mb-4 text-muted">
            Start by creating your first product and managing suppliers easily.
        </p>

        @auth
        <a href="{{ route('products.create') }}" class="btn btn-success btn-lg">+ Create Your First Product</a>
        @endauth

        @guest
        <a href="{{ route('login') }}" class="btn btn-success btn-lg">+ Create Your First Product</a>
        @endguest
    </div>
    @else

    {{-- Products Grid --}}
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex flex-column">
                    <h5 class="fw-semibold text-primary mb-2">{{ $product->name }}</h5>
                    <p class="mb-1"><strong>💲 Price:</strong> {{ $product->price }}</p>
                    <p class="mb-1"><strong>📂 Category:</strong> {{ $product->category?->name ?? '—' }}</p>
                    <p class="mb-2"><strong>👤 Owner:</strong> {{ $product->user?->email }}</p>
                    <hr>
                    <p class="mb-2 fw-semibold">🚚 Suppliers ({{ $product->suppliers_count }})</p>

                    @if($product->suppliers->count())
                    <div class="d-flex flex-column gap-2 small">
                        @foreach($product->suppliers as $supplier)
                        <div class="border rounded p-2 bg-light">
                            <strong>{{ $supplier->name }}</strong>
                            <div class="text-muted">
                                Cost: {{ $supplier->pivot->cost_price }} |
                                Lead: {{ $supplier->pivot->lead_time_days }} days
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted small">No suppliers assigned</p>
                    @endif

                    {{-- Actions (Edit / Delete) --}}
                    @if(auth()->check() && (auth()->id() === $product->user_id || auth()->user()->role === 'admin'))
                    <div class="mt-auto d-flex gap-2 pt-3">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary btn-sm">Edit</a>

                        <button class="btn btn-outline-danger btn-sm delete-btn" data-id="{{ $product->id }}">Delete</button>

                        <form id="delete-form-{{ $product->id }}" method="POST"
                            action="{{ route('products.destroy', $product) }}" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>

    @endif
</div>
@endsection