@csrf

<div class="card shadow-sm p-4 mb-4">
    <h3 class="mb-4">Product Details</h3>

    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <label class="form-label">Product Name</label>
            <input type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $product->name ?? '') }}"
                required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Price</label>
            <input type="number"
                name="price"
                step="0.01"
                min="0"
                class="form-control"
                value="{{ old('price', $product->price ?? '') }}"
                required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Suppliers</label>
        <div class="p-3 border rounded bg-white">

            @foreach($suppliers as $supplier)

            @php
            $pivot = isset($product)
            ? $product->suppliers->firstWhere('id', $supplier->id)?->pivot
            : null;
            @endphp

            <div class="row align-items-center mb-3 supplier-row">

                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input supplier-checkbox"
                            type="checkbox"
                            id="supplier-{{ $supplier->id }}"
                            name="suppliers[{{ $supplier->id }}][selected]"
                            value="1"
                            {{ old('suppliers.'.$supplier->id.'.selected', $pivot ? true : false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="supplier-{{ $supplier->id }}">
                            {{ $supplier->name }}
                        </label>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <input type="number"
                        step="0.01"
                        min="0"
                        class="form-control supplier-input bg-light"
                        placeholder="Cost Price"
                        name="suppliers[{{ $supplier->id }}][cost_price]"
                        value="{{ old('suppliers.'.$supplier->id.'.cost_price', $pivot->cost_price ?? '') }}"
                        {{ old('suppliers.'.$supplier->id.'.selected', $pivot ? true : false) ? '' : 'disabled' }}>
                </div>

                <div class="col-md-4 mb-2">
                    <input type="number"
                        min="0"
                        class="form-control supplier-input bg-light"
                        placeholder="Lead Time (days)"
                        name="suppliers[{{ $supplier->id }}][lead_time_days]"
                        value="{{ old('suppliers.'.$supplier->id.'.lead_time_days', $pivot->lead_time_days ?? '') }}"
                        {{ old('suppliers.'.$supplier->id.'.selected', $pivot ? true : false) ? '' : 'disabled' }}>
                </div>
            </div>

            @endforeach

        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary me-2">{{ $buttonText }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<script>
    document.querySelectorAll('.supplier-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const row = this.closest('.supplier-row');
            row.querySelectorAll('.supplier-input').forEach(input => {
                input.disabled = !this.checked;
                if (!this.checked) input.value = '';
            });
        });
    });
</script>