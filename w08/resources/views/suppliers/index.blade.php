@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold">Suppliers</h1>

    @if($suppliers->count())
    <ul class="list-group">
        @foreach($suppliers as $supplier)
        <li class="list-group-item">{{ $supplier->name }}</li>
        @endforeach
    </ul>
    @else
    <div class="alert alert-info">No suppliers found.</div>
    @endif
</div>
@endsection