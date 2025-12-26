@extends('layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<h1>{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h1>

<form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST">
    @csrf
    @if(isset($product))
    @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}">
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" name="price" value="{{ old('price', $product->price ?? 0) }}">
        @error('price') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" class="form-select">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-success" type="submit">{{ isset($product) ? 'Update' : 'Save' }}</button>
</form>
@endsection