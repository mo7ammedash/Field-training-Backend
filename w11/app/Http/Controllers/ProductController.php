<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base Query + Eager Loading
        $query = Product::with(['category', 'suppliers'])
            ->withCount('suppliers');

        // Authorization
        if ($user && $user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // 🔍 Search (name + description)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
                if (Schema::hasColumn('products', 'description')) {
                    $q->orWhere('description', 'like', "%{$search}%");
                }
            });
        }

        // 🎯 Filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('supplier_id')) {
            $query->whereHas('suppliers', function ($q) use ($request) {
                $q->where('suppliers.id', $request->supplier_id);
            });
        }

        // 🔃 Sorting (Whitelist)
        $allowedSorts = ['created_at', 'price', 'name'];
        $allowedDirections = ['asc', 'desc'];

        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
        if (!in_array($direction, $allowedDirections)) $direction = 'desc';

        $query->orderBy($sortBy, $direction);

        // 📄 Pagination + Query Persistence

        $products = $query->paginate(10)->withQueryString();

        // 🗑 Trash badge count
        $trashCount = Product::onlyTrashed()->count();

        return view('products.index', compact('products', 'trashCount'));
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
            'name'        => $request->name,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'user_id'     => auth()->id(),
        ]);

        // Image Upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image_path = $imagePath;
            $product->save();
        }

        // Sync Suppliers
        $syncData = [];
        foreach ($request->suppliers as $supplierId => $data) {
            if (!empty($data['selected'])) {
                $syncData[$supplierId] = [
                    'cost_price'       => $data['cost_price'] ?? 0,
                    'lead_time_days'   => $data['lead_time_days'] ?? 0,
                ];
            }
        }
        $product->suppliers()->sync($syncData);

        return redirect()->route('products.index')->with([
            'toast_message' => 'Product created successfully',
            'toast_type'    => 'create',
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
            'name'        => $request->name,
            'price'       => $request->price,
            'category_id' => $request->category_id,
        ]);

        // Image Upload (Update + Delete Old)
        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image_path = $imagePath;
            $product->save();
        }

        // Sync Suppliers
        $syncData = [];
        foreach ($request->suppliers as $supplierId => $data) {
            if (!empty($data['selected'])) {
                $syncData[$supplierId] = [
                    'cost_price'     => $data['cost_price'] ?? 0,
                    'lead_time_days' => $data['lead_time_days'] ?? 0,
                ];
            }
        }
        $product->suppliers()->sync($syncData);

        return redirect()->route('products.index')->with([
            'toast_message' => 'Product updated successfully',
            'toast_type'    => 'update',
        ]);
    }

    public function destroy(Product $product)
    {
        $user = Auth::user();
        abort_if(!$user || ($user->role !== 'admin' && $user->id !== $product->user_id), 403);

        // if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
        //     Storage::disk('public')->delete($product->image_path);
        // }

        $product->delete();

        return redirect()->route('products.index')->with([
            'toast_message' => 'Product deleted successfully',
            'toast_type'    => 'delete',
        ]);
    }
    public function trash()
    {
        $products = Product::onlyTrashed()
            ->with(['category', 'suppliers', 'user'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('products.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $product);

        $product->restore();

        return redirect()->route('products.trash')->with([
            'toast_message' => 'Product restored successfully',
            'toast_type'    => 'update',
        ]);
    }


    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $product);

        $product->forceDelete();

        return redirect()->route('products.trash')->with([
            'toast_message' => 'Product permanently deleted',
            'toast_type'    => 'delete',
        ]);
    }
}
