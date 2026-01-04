@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<h1 class="mb-4">Edit Product</h1>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('products.update', $product) }}" method="POST">
    @method('PUT')
    @include('products.form', ['buttonText' => 'Update Product'])
</form>
@endsection