@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold">Categories</h1>

    @if($categories->count())
    <ul class="list-group">
        @foreach($categories as $category)
        <li class="list-group-item">{{ $category->name }}</li>
        @endforeach
    </ul>
    @else
    <div class="alert alert-info">No categories found.</div>
    @endif
</div>
@endsection