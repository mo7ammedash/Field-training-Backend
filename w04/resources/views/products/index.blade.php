<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ isset($editProduct) ? 'Edit Product' : 'Add Product' }}</h4>
            </div>
            <div class="card-body">
                <form method="POST"
                    action="{{ isset($editProduct) ? route('products.update', $editProduct) : route('products.store') }}">
                    @csrf
                    @if(isset($editProduct))
                    @method('PUT')
                    @endif

                    <div class="row mb-3">

                        <div class="col">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $editProduct->name ?? '') }}">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control"
                                value="{{ old('price', $editProduct->price ?? '') }}">
                            @error('price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        {{ isset($editProduct) ? 'Update Product' : 'Add Product' }}
                    </button>

                    @if(isset($editProduct))
                    <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Products List</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $product->updated_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('products.index', ['edit' => $product->id]) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>