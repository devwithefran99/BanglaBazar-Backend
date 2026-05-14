<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

  public function create()
{
    $suppliers = Supplier::active()->orderBy('name')->get();
    return view('backend.products.create', compact('suppliers'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'price'     => 'required|numeric|min:0',        // sell price
            'old_price' => 'nullable|numeric|min:0',        // regular price
            'buy_price' => 'nullable|numeric|min:0',        // ✅ new
            'stock'     => 'required|integer|min:0',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
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
               'supplier_id' => $request->supplier_id ?: null, 
        ]);

        // ✅ Inventory auto-create with buy_price
        Inventory::create([
            'product_id'   => $product->id,
            'product_type' => 'product',
            'name'         => $product->name,
            'sku'          => 'PRD-' . str_pad($product->id, 5, '0', STR_PAD_LEFT),
            'category'     => $product->category ?? 'general',
            'stock'        => $product->stock,
            'min_stock'    => $product->low_stock_threshold ?? 5,
            'price'        => $product->price,
            'buy_price'    => $request->buy_price ?? 0,
            'unit'         => 'pcs',
            'image'        => $imagePath,
            'is_active'    => true,
        ]);

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product & Inventory added successfully!');
    }

   public function edit(Product $product)
{
    $suppliers = Supplier::active()->orderBy('name')->get();
    return view('backend.products.edit', compact('product', 'suppliers'));
}

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'price'     => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'buy_price' => 'nullable|numeric|min:0',
            'stock'     => 'required|integer|min:0',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
             'supplier_id' => 'nullable|exists:suppliers,id', 
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
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
             'supplier_id' => $request->supplier_id ?: null,
        ]);

        // ✅ Linked inventory sync + buy_price update
        Inventory::updateOrCreate(
            [
                'product_id'   => $product->id,
                'product_type' => 'product',
            ],
            [
                'name'      => $product->name,
                'sku'       => 'PRD-' . str_pad($product->id, 5, '0', STR_PAD_LEFT),
                'category'  => $product->category ?? 'general',
                'stock'     => $product->stock,
                'min_stock' => $product->low_stock_threshold ?? 5,
                'price'     => $product->price,
                'buy_price' => $request->buy_price ?? 0,
                'unit'      => 'pcs',
                'image'     => $imagePath,
                'is_active' => true,
            ]
        );

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        Inventory::where('product_id', $product->id)
                 ->where('product_type', 'product')
                 ->delete();

        $product->delete();

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product deleted successfully!');
    }
}