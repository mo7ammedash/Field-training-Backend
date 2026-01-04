<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('suppliers')->withCount('suppliers')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('products.create', compact('suppliers'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->only('name', 'price'));

        $syncData = [];
        foreach ($request->suppliers as $id => $data) {
            if (isset($data['selected'])) {
                $syncData[$id] = [
                    'cost_price' => $data['cost_price'],
                    'lead_time_days' => $data['lead_time_days']
                ];
            }
        }
        $product->suppliers()->sync($syncData);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'suppliers'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->only('name', 'price'));

        $syncData = [];
        foreach ($request->suppliers as $id => $data) {
            if (isset($data['selected'])) {
                $syncData[$id] = [
                    'cost_price' => $data['cost_price'],
                    'lead_time_days' => $data['lead_time_days']
                ];
            }
        }
        $product->suppliers()->sync($syncData);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
