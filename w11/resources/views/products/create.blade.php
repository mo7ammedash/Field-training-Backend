@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="bg-white border rounded-3 shadow-sm p-4">

                <h2 class="fw-bold text-center mb-4">Add New Product</h2>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price') }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-4">
                        <label class="form-label">Category</label>
                        <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected':'' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Image Upload + Live Preview --}}
                    <div class="mb-4">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" accept="image/*" id="imageInput" class="form-control @error('image') is-invalid @enderror">
                        <img id="imagePreview" src="{{ asset('images/default-product.png') }}"
                            alt="Preview"
                            style="margin-top:10px; width:120px; height:120px; object-fit:cover; border-radius:5px;">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Suppliers --}}
                    <div class="mb-4">
                        <h5 class="fw-bold mb-2">Suppliers</h5>
                        @if ($errors->has('suppliers'))
                        <div class="text-danger fw-semibold">
                            {{ $errors->first('suppliers') }}
                        </div>
                        @endif
                        <div class="border rounded p-3 bg-light mt-2">
                            @foreach($suppliers as $supplier)
                            <div class="supplier-box bg-white border rounded p-3 mb-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input supplier-checkbox"
                                        type="checkbox"
                                        name="suppliers[{{ $supplier->id }}][selected]"
                                        id="supplier{{ $supplier->id }}"
                                        {{ old("suppliers.$supplier->id.selected") ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="supplier{{ $supplier->id }}">
                                        {{ $supplier->name }}
                                    </label>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="number" step="0.01"
                                            name="suppliers[{{ $supplier->id }}][cost_price]"
                                            class="form-control supplier-input"
                                            placeholder="Cost Price"
                                            value="{{ old("suppliers.$supplier->id.cost_price") }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number"
                                            name="suppliers[{{ $supplier->id }}][lead_time_days]"
                                            class="form-control supplier-input"
                                            placeholder="Lead Time (days)"
                                            value="{{ old("suppliers.$supplier->id.lead_time_days") }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-success px-4">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Supplier toggles
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

        // Live Image Preview
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        imageInput.addEventListener('change', function() {
            const [file] = imageInput.files;
            if (file) imagePreview.src = URL.createObjectURL(file);
        });
    });
</script>
@endsection