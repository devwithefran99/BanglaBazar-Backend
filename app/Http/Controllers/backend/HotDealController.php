<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HotDeal;
use App\Models\ProductVariation;
use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HotDealController extends Controller
{
    public function index()
    {
        $hotDeals = HotDeal::latest()->paginate(10);
        return view('backend.hotdeal.index', compact('hotDeals'));
    }

    public function create()
    {
        $suppliers = Supplier::active()->orderBy('name')->get();
        return view('backend.hotdeal.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $hasVariations = $request->boolean('has_variations');

        $rules = [
            'name'         => 'required|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deal_ends_at' => 'nullable|date|after:now',
            'supplier_id'  => 'nullable|exists:suppliers,id',
        ];

        if ($hasVariations) {
            $rules['variations']             = 'required|array|min:1';
            $rules['variations.*.label']     = 'required|string|max:100';
            $rules['variations.*.price']     = 'required|numeric|min:0';
            $rules['variations.*.old_price'] = 'nullable|numeric|min:0';
            $rules['variations.*.stock']     = 'required|integer|min:0';
        } else {
            $rules['price']     = 'required|numeric|min:0';
            $rules['old_price'] = 'nullable|numeric|min:0';
            $rules['buy_price'] = 'nullable|numeric|min:0';
            $rules['stock']     = 'required|integer|min:0';
        }

        $request->validate($rules);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotdeals', 'public');
        }

        $mainPrice    = $request->price ?? 0;
        $mainOldPrice = $request->old_price ?: null;
        $mainStock    = $request->stock ?? 0;

        if ($hasVariations) {
            $variations = $request->variations;
            $defaultIdx = (int) ($request->default_variation ?? 0);
            $defaultVar = $variations[$defaultIdx] ?? $variations[0];
            $mainPrice    = $defaultVar['price'];
            $mainOldPrice = $defaultVar['old_price'] ?: null;
            $mainStock    = array_sum(array_column($variations, 'stock'));
        }

        $hotdeal = HotDeal::create([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name),
            'description'         => $request->description,
            'price'               => $mainPrice,
            'old_price'           => $mainOldPrice,
            'stock'               => $mainStock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_best_sale'        => $request->has('is_best_sale'),
            'is_active'           => $request->has('is_active'),
            'deal_ends_at'        => $request->deal_ends_at ?: null,
            'supplier_id'         => $request->supplier_id ?: null,
        ]);

        // Variations save
        if ($hasVariations) {
            $defaultIdx = (int) ($request->default_variation ?? 0);
            foreach ($request->variations as $i => $var) {
                ProductVariation::create([
                    'product_id'   => $hotdeal->id,
                    'product_type' => 'hotdeal',
                    'label'        => $var['label'],
                    'price'        => $var['price'],
                    'old_price'    => $var['old_price'] ?: null,
                    'stock'        => $var['stock'],
                    'is_default'   => ($i == $defaultIdx),
                ]);
            }
        }

        Inventory::create([
            'product_id'   => $hotdeal->id,
            'product_type' => 'hotdeal',
            'name'         => $hotdeal->name,
            'sku'          => 'HD-' . str_pad($hotdeal->id, 5, '0', STR_PAD_LEFT),
            'category'     => $hotdeal->category ?? 'general',
            'stock'        => $hotdeal->stock,
            'min_stock'    => $hotdeal->low_stock_threshold ?? 5,
            'price'        => $hotdeal->price,
            'buy_price'    => $request->buy_price ?? 0,
            'unit'         => 'pcs',
            'image'        => $imagePath,
            'is_active'    => true,
        ]);

        return redirect()->route('backend.hotdeals.index')
                         ->with('success', 'Hot Deal & Inventory added successfully!');
    }

    public function edit(HotDeal $hotdeal)
    {
        $suppliers  = Supplier::active()->orderBy('name')->get();
        $categories = ['sutki', 'meat', 'fish', 'oil_ghee', 'spices', 'rice', 'beverage'];
        $variations = $hotdeal->variations()->get();
        return view('backend.hotdeal.edit', compact('hotdeal', 'suppliers', 'categories', 'variations'));
    }

    public function update(Request $request, HotDeal $hotdeal)
    {
        $hasVariations = $request->boolean('has_variations');

        $rules = [
            'name'         => 'required|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deal_ends_at' => 'nullable|date',
            'supplier_id'  => 'nullable|exists:suppliers,id',
        ];

        if ($hasVariations) {
            $rules['variations']             = 'required|array|min:1';
            $rules['variations.*.label']     = 'required|string|max:100';
            $rules['variations.*.price']     = 'required|numeric|min:0';
            $rules['variations.*.old_price'] = 'nullable|numeric|min:0';
            $rules['variations.*.stock']     = 'required|integer|min:0';
        } else {
            $rules['price']     = 'required|numeric|min:0';
            $rules['old_price'] = 'nullable|numeric|min:0';
            $rules['buy_price'] = 'nullable|numeric|min:0';
            $rules['stock']     = 'required|integer|min:0';
        }

        $request->validate($rules);

        $imagePath = $hotdeal->image;
        if ($request->hasFile('image')) {
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('hotdeals', 'public');
        }

        $mainPrice    = $request->price ?? $hotdeal->price;
        $mainOldPrice = $request->old_price ?: null;
        $mainStock    = $request->stock ?? $hotdeal->stock;

        if ($hasVariations) {
            $variations = $request->variations;
            $defaultIdx = (int) ($request->default_variation ?? 0);
            $defaultVar = $variations[$defaultIdx] ?? $variations[0];
            $mainPrice    = $defaultVar['price'];
            $mainOldPrice = $defaultVar['old_price'] ?: null;
            $mainStock    = array_sum(array_column($variations, 'stock'));
        }

        $hotdeal->update([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name),
            'description'         => $request->description,
            'price'               => $mainPrice,
            'old_price'           => $mainOldPrice,
            'stock'               => $mainStock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_best_sale'        => $request->has('is_best_sale'),
            'is_active'           => $request->has('is_active'),
            'deal_ends_at'        => $request->deal_ends_at ?: null,
            'supplier_id'         => $request->supplier_id ?: null,
        ]);

        // Variations: পুরনো delete করে নতুন save
        if ($hasVariations) {
            ProductVariation::where('product_id', $hotdeal->id)
                            ->where('product_type', 'hotdeal')
                            ->delete();
            $defaultIdx = (int) ($request->default_variation ?? 0);
            foreach ($request->variations as $i => $var) {
                ProductVariation::create([
                    'product_id'   => $hotdeal->id,
                    'product_type' => 'hotdeal',
                    'label'        => $var['label'],
                    'price'        => $var['price'],
                    'old_price'    => $var['old_price'] ?: null,
                    'stock'        => $var['stock'],
                    'is_default'   => ($i == $defaultIdx),
                ]);
            }
        } else {
            ProductVariation::where('product_id', $hotdeal->id)
                            ->where('product_type', 'hotdeal')
                            ->delete();
        }

        Inventory::updateOrCreate(
            ['product_id' => $hotdeal->id, 'product_type' => 'hotdeal'],
            [
                'name'      => $hotdeal->name,
                'sku'       => 'HD-' . str_pad($hotdeal->id, 5, '0', STR_PAD_LEFT),
                'category'  => $hotdeal->category ?? 'general',
                'stock'     => $hotdeal->stock,
                'min_stock' => $hotdeal->low_stock_threshold ?? 5,
                'price'     => $hotdeal->price,
                'buy_price' => $request->buy_price ?? 0,
                'unit'      => 'pcs',
                'image'     => $imagePath,
                'is_active' => true,
            ]
        );

        return redirect()->route('backend.hotdeals.index')
                         ->with('success', 'Hot Deal updated successfully!');
    }

    public function destroy(HotDeal $hotdeal)
    {
        if ($hotdeal->image) {
            Storage::disk('public')->delete($hotdeal->image);
        }
        ProductVariation::where('product_id', $hotdeal->id)
                        ->where('product_type', 'hotdeal')
                        ->delete();
        Inventory::where('product_id', $hotdeal->id)
                 ->where('product_type', 'hotdeal')
                 ->delete();
        $hotdeal->delete();

        return redirect()->route('backend.hotdeals.index')
                         ->with('success', 'Hot Deal deleted successfully!');
    }
}