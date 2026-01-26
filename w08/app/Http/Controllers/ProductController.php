<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            $products = Product::with(['category', 'suppliers'])
                ->withCount('suppliers')
                ->get();
        } elseif ($user) {
            $products = Product::with(['category', 'suppliers'])
                ->withCount('suppliers')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $products = Product::with(['category', 'suppliers'])
                ->withCount('suppliers')
                ->get();
        }

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();

        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        $syncData = [];
        foreach ($request->suppliers as $supplierId => $data) {
            if (!empty($data['selected'])) {
                $syncData[$supplierId] = [
                    'cost_price' => $data['cost_price'] ?? 0,
                    'lead_time_days' => $data['lead_time_days'] ?? 0,
                ];
            }
        }
        $product->suppliers()->sync($syncData);

        return redirect()->route('products.index')->with([
            'toast_message' => 'Product created successfully',
            'toast_type' => 'create'
        ]);
    }

    public function edit(Product $product)
    {
        $user = Auth::user();
        abort_if(!$user || ($user->role !== 'admin' && $user->id !== $product->user_id), 403);

        $categories = Category::all();
        $suppliers  = Supplier::all();
        $product->load('suppliers');

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $user = Auth::user();
        abort_if(!$user || ($user->role !== 'admin' && $user->id !== $product->user_id), 403);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        $syncData = [];
        foreach ($request->suppliers as $supplierId => $data) {
            if (!empty($data['selected'])) {
                $syncData[$supplierId] = [
                    'cost_price' => $data['cost_price'] ?? 0,
                    'lead_time_days' => $data['lead_time_days'] ?? 0,
                ];
            }
        }
        $product->suppliers()->sync($syncData);

        return redirect()->route('products.index')->with([
            'toast_message' => 'Product updated successfully',
            'toast_type' => 'update'
        ]);
    }

    public function destroy(Product $product)
    {
        $user = Auth::user();
        abort_if(!$user || ($user->role !== 'admin' && $user->id !== $product->user_id), 403);

        $product->delete();

        return redirect()->route('products.index')->with([
            'toast_message' => 'Product deleted successfully',
            'toast_type' => 'delete'
        ]);
    }
}
