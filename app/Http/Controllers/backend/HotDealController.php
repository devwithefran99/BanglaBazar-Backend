<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HotDeal;
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
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',     // sell price
            'old_price'    => 'nullable|numeric|min:0',     // regular price
            'buy_price'    => 'nullable|numeric|min:0',     // ✅ new
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deal_ends_at' => 'nullable|date|after:now',
             'supplier_id'  => 'nullable|exists:suppliers,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotdeals', 'public');
        }

        $hotdeal = HotDeal::create([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . time(),
            'description'         => $request->description,
            'price'               => $request->price,
            'old_price'           => $request->old_price ?: null,
            'stock'               => $request->stock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_best_sale'        => $request->has('is_best_sale'),
            'is_active'           => $request->has('is_active'),
            'deal_ends_at'        => $request->deal_ends_at ?: null,
              'supplier_id'         => $request->supplier_id ?: null,
        ]);

        // ✅ Inventory auto-create with buy_price
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
    $suppliers = Supplier::active()->orderBy('name')->get();
    $categories = ['sutki', 'meat', 'fish', 'oil_ghee', 'spices', 'rice', 'beverage'];
    return view('backend.hotdeal.edit', compact('hotdeal', 'suppliers', 'categories'));
}
    public function update(Request $request, HotDeal $hotdeal)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'old_price'    => 'nullable|numeric|min:0',
            'buy_price'    => 'nullable|numeric|min:0',     // ✅ new
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deal_ends_at' => 'nullable|date',
            'supplier_id'  => 'nullable|exists:suppliers,id',
        ]);

        $imagePath = $hotdeal->image;
        if ($request->hasFile('image')) {
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('hotdeals', 'public');
        }

        $hotdeal->update([
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . '-' . $hotdeal->id,
            'description'         => $request->description,
            'price'               => $request->price,
            'old_price'           => $request->old_price ?: null,
            'stock'               => $request->stock,
            'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            'image'               => $imagePath,
            'category'            => $request->category,
            'is_best_sale'        => $request->has('is_best_sale'),
            'is_active'           => $request->has('is_active'),
            'deal_ends_at'        => $request->deal_ends_at ?: null,
             'supplier_id'         => $request->supplier_id ?: null,
        ]);

        // ✅ Linked inventory sync + buy_price update
        Inventory::updateOrCreate(
            [
                'product_id'   => $hotdeal->id,
                'product_type' => 'hotdeal',
            ],
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

        // ✅ Linked inventory delete
        Inventory::where('product_id', $hotdeal->id)
                 ->where('product_type', 'hotdeal')
                 ->delete();

        $hotdeal->delete();

        return redirect()->route('backend.hotdeals.index')
                         ->with('success', 'Hot Deal deleted successfully!');
    }
}