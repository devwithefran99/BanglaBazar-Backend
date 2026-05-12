<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    public function create()
{
    $categories = \App\Models\Category::where('is_active', true)
                    ->orderBy('sort_order')->orderBy('name')->get();
    return view('backend.products.create', compact('categories'));
}
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . time(),
            'description'         => $request->description,
            'price'               => $request->price,
            'old_price'           => $request->old_price ?: null,
            'stock'               => $request->stock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_featured'         => $request->has('is_featured'),
            'is_active'           => $request->has('is_active'),
        ]);

        // ── Inventory automatically তৈরি করো ──────────────
        $inventory = Inventory::create([
            'product_id'   => $product->id,
            'product_type' => 'product',
            'name'         => $product->name,
            'sku'          => 'PRD-' . str_pad($product->id, 5, '0', STR_PAD_LEFT),
            'category'     => $product->category ?? 'Uncategorized',
            'stock'        => $product->stock,
            'min_stock'    => $product->low_stock_threshold ?? 5,
            'price'        => $product->price,
            'unit'         => 'pcs',
            'is_active'    => $product->is_active,
        ]);

        // Initial stock movement log
        if ($product->stock > 0) {
            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'type'         => 'in',
                'quantity'     => $product->stock,
                'stock_before' => 0,
                'stock_after'  => $product->stock,
                'note'         => 'Initial stock — product created',
                'created_by'   => Auth::id(),
            ]);
        }
        // ───────────────────────────────────────────────────

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
{
    $categories = \App\Models\Category::where('is_active', true)
                    ->orderBy('sort_order')->orderBy('name')->get();
    return view('backend.products.edit', compact('product', 'categories'));
}

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
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $oldStock = $product->stock;

        $product->update([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . $product->id,
            'description'         => $request->description,
            'price'               => $request->price,
            'old_price'           => $request->old_price ?: null,
            'stock'               => $request->stock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_featured'         => $request->has('is_featured'),
            'is_active'           => $request->has('is_active'),
        ]);

        // ── Inventory sync করো ─────────────────────────────
        $inventory = Inventory::findByProduct($product->id, 'product');

        if ($inventory) {
            $newStock = (int) $request->stock;

            // Stock change হলে movement log করো
            if ($oldStock !== $newStock) {
                $diff = $newStock - $oldStock;
                InventoryMovement::create([
                    'inventory_id' => $inventory->id,
                    'type'         => $diff > 0 ? 'in' : 'out',
                    'quantity'     => abs($diff),
                    'stock_before' => $oldStock,
                    'stock_after'  => $newStock,
                    'note'         => 'Stock updated from product edit',
                    'created_by'   => Auth::id(),
                ]);
            }

            $inventory->update([
                'name'      => $product->name,
                'category'  => $product->category ?? 'Uncategorized',
                'stock'     => $newStock,
                'min_stock' => $product->low_stock_threshold ?? 5,
                'price'     => $product->price,
                'is_active' => $product->is_active,
            ]);
        } else {
            // Inventory না থাকলে নতুন বানাও
            Inventory::create([
                'product_id'   => $product->id,
                'product_type' => 'product',
                'name'         => $product->name,
                'sku'          => 'PRD-' . str_pad($product->id, 5, '0', STR_PAD_LEFT),
                'category'     => $product->category ?? 'Uncategorized',
                'stock'        => $product->stock,
                'min_stock'    => $product->low_stock_threshold ?? 5,
                'price'        => $product->price,
                'unit'         => 'pcs',
                'is_active'    => $product->is_active,
            ]);
        }
        // ───────────────────────────────────────────────────

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Inventory ও delete করো
        Inventory::where('product_id', $product->id)
                 ->where('product_type', 'product')
                 ->delete();

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product deleted successfully!');
    }
}