@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<h1 class="mb-4">Add Product</h1>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('products.store') }}" method="POST">
    @include('products.form', ['buttonText' => 'Create Product'])
</form>
@endsection