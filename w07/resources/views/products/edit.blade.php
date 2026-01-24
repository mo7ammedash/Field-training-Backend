@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="bg-white border rounded-3 shadow-sm p-4">

                <h2 class="fw-bold text-center mb-4">Edit Product</h2>

                <form method="POST" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $product->price) }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-4">
                        <label class="form-label">Category</label>
                        <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                            required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Suppliers --}}
                    <div class="mb-4">
                        <h5 class="fw-bold mb-2">Suppliers</h5>

                        <div class="border rounded p-3 bg-light">
                            @foreach($suppliers as $supplier)

                            @php
                            $pivot = $product->suppliers
                            ->firstWhere('id', $supplier->id)?->pivot;
                            @endphp

                            <div class="supplier-box bg-white border rounded p-3 mb-3">

                                <div class="form-check mb-2">
                                    <input class="form-check-input supplier-checkbox"
                                        type="checkbox"
                                        name="suppliers[{{ $supplier->id }}][selected]"
                                        id="supplier{{ $supplier->id }}"
                                        {{ old("suppliers.$supplier->id.selected", $pivot ? 1 : 0) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold">
                                        {{ $supplier->name }}
                                    </label>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="number" step="0.01"
                                            name="suppliers[{{ $supplier->id }}][cost_price]"
                                            class="form-control supplier-input @error(" suppliers.$supplier->id.cost_price") is-invalid @enderror"
                                        placeholder="Cost Price"
                                        value="{{ old("suppliers.$supplier->id.cost_price", $pivot->cost_price ?? '') }}"
                                        {{ old("suppliers.$supplier->id.selected", $pivot ? 1 : 0) ? 'required' : 'disabled' }}>
                                        @error("suppliers.$supplier->id.cost_price")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input type="number"
                                            name="suppliers[{{ $supplier->id }}][lead_time_days]"
                                            class="form-control supplier-input @error(" suppliers.$supplier->id.lead_time_days") is-invalid @enderror"
                                        placeholder="Lead Time (days)"
                                        value="{{ old("suppliers.$supplier->id.lead_time_days", $pivot->lead_time_days ?? '') }}"
                                        {{ old("suppliers.$supplier->id.selected", $pivot ? 1 : 0) ? 'required' : 'disabled' }}>
                                        @error("suppliers.$supplier->id.lead_time_days")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary px-4">Update Product</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.supplier-checkbox').forEach(cb => {
            toggle(cb);
            cb.addEventListener('change', () => toggle(cb));
        });

        function toggle(cb) {
            const box = cb.closest('.supplier-box');
            box.querySelectorAll('.supplier-input').forEach(input => {
                input.disabled = !cb.checked;
                input.required = cb.checked;
                if (!cb.checked) input.value = '';
            });
        }
    });
</script>
@endsection