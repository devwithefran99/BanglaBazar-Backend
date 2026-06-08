<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
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
        $hasVariations = $request->has('has_variations') && $request->boolean('has_variations');

        $rules = [
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ];

        if ($hasVariations) {
            $rules['variations']                = 'required|array|min:1';
            $rules['variations.*.label']        = 'required|string|max:100';
            $rules['variations.*.price']        = 'required|numeric|min:0';
            $rules['variations.*.old_price']    = 'nullable|numeric|min:0';
            $rules['variations.*.stock']        = 'required|integer|min:0';
        } else {
            $rules['price']     = 'required|numeric|min:0';
            $rules['old_price'] = 'nullable|numeric|min:0';
            $rules['buy_price'] = 'nullable|numeric|min:0';
            $rules['stock']     = 'required|integer|min:0';
        }

        $request->validate($rules);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Variation থাকলে default variation এর price/stock product এ রাখো
        $mainPrice = $request->price ?? 0;
        $mainOldPrice = $request->old_price ?: null;
        $mainStock = $request->stock ?? 0;

        if ($hasVariations) {
            $variations = $request->variations;
            $defaultIdx = (int) ($request->default_variation ?? 0);
            $defaultVar = $variations[$defaultIdx] ?? $variations[0];
            $mainPrice    = $defaultVar['price'];
            $mainOldPrice = $defaultVar['old_price'] ?: null;
            $mainStock    = array_sum(array_column($variations, 'stock'));
        }

        $product = Product::create([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name),
            'description'         => $request->description,
            'price'               => $mainPrice,
            'old_price'           => $mainOldPrice,
            'stock'               => $mainStock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_featured'         => $request->has('is_featured'),
            'is_active'           => $request->has('is_active'),
            'supplier_id'         => $request->supplier_id ?: null,
        ]);

        // Variations save
        if ($hasVariations) {
            $defaultIdx = (int) ($request->default_variation ?? 0);
            foreach ($request->variations as $i => $var) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'label'      => $var['label'],
                    'price'      => $var['price'],
                    'old_price'  => $var['old_price'] ?: null,
                    'stock'      => $var['stock'],
                    'is_default' => ($i == $defaultIdx),
                ]);
            }
        }

        // Inventory auto-create
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
        $suppliers  = Supplier::active()->orderBy('name')->get();
        $variations = $product->variations()->get();
        return view('backend.products.edit', compact('product', 'suppliers', 'variations'));
    }

    public function update(Request $request, Product $product)
    {
        $hasVariations = $request->has('has_variations') && $request->boolean('has_variations');

        $rules = [
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ];

        if ($hasVariations) {
            $rules['variations']                = 'required|array|min:1';
            $rules['variations.*.label']        = 'required|string|max:100';
            $rules['variations.*.price']        = 'required|numeric|min:0';
            $rules['variations.*.old_price']    = 'nullable|numeric|min:0';
            $rules['variations.*.stock']        = 'required|integer|min:0';
        } else {
            $rules['price']     = 'required|numeric|min:0';
            $rules['old_price'] = 'nullable|numeric|min:0';
            $rules['buy_price'] = 'nullable|numeric|min:0';
            $rules['stock']     = 'required|integer|min:0';
        }

        $request->validate($rules);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $mainPrice    = $request->price ?? $product->price;
        $mainOldPrice = $request->old_price ?: null;
        $mainStock    = $request->stock ?? $product->stock;

        if ($hasVariations) {
            $variations = $request->variations;
            $defaultIdx = (int) ($request->default_variation ?? 0);
            $defaultVar = $variations[$defaultIdx] ?? $variations[0];
            $mainPrice    = $defaultVar['price'];
            $mainOldPrice = $defaultVar['old_price'] ?: null;
            $mainStock    = array_sum(array_column($variations, 'stock'));
        }

        $product->update([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name),
            'description'         => $request->description,
            'price'               => $mainPrice,
            'old_price'           => $mainOldPrice,
            'stock'               => $mainStock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_featured'         => $request->has('is_featured'),
            'is_active'           => $request->has('is_active'),
            'supplier_id'         => $request->supplier_id ?: null,
        ]);

        // Variations: পুরনো delete করে নতুন save
        if ($hasVariations) {
            $product->variations()->delete();
            $defaultIdx = (int) ($request->default_variation ?? 0);
            foreach ($request->variations as $i => $var) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'label'      => $var['label'],
                    'price'      => $var['price'],
                    'old_price'  => $var['old_price'] ?: null,
                    'stock'      => $var['stock'],
                    'is_default' => ($i == $defaultIdx),
                ]);
            }
        } else {
            // variation off করলে সব delete
            $product->variations()->delete();
        }

        // Inventory sync
        Inventory::updateOrCreate(
            ['product_id' => $product->id, 'product_type' => 'product'],
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
        $product->variations()->delete();
        Inventory::where('product_id', $product->id)
                 ->where('product_type', 'product')
                 ->delete();
        $product->delete();

        return redirect()->route('backend.products.index')
                         ->with('success', 'Product deleted successfully!');
    }
}