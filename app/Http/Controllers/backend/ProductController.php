<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // All Products list
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    // Add Product form
    public function create()
    {
        return view('backend.products.create');
    }

    // Save new product
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'price'       => $request->price,
            'old_price'   => $request->old_price ?: null,
            'stock'       => $request->stock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'       => $imagePath,
            'category'    => $request->category,
            'is_featured' => $request->has('is_featured'),
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product added successfully!');
    }

    // Edit form
    public function edit(Product $product)
    {
        return view('backend.products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // পুরনো image delete করো
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . $product->id,
            'description' => $request->description,
            'price'       => $request->price,
            'old_price'   => $request->old_price ?: null,
            'stock'       => $request->stock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'       => $imagePath,
            'category'    => $request->category,
            'is_featured' => $request->has('is_featured'),
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product deleted successfully!');
    }
}