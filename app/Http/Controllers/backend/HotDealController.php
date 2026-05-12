<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HotDeal;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HotDealController extends Controller
{
    public function index()
    {
        $hotDeals = HotDeal::latest()->paginate(10);
        return view('backend.hotdeal.index', compact('hotDeals'));
    }

    public function create()
{
    $categories = \App\Models\Category::where('is_active', true)
                    ->orderBy('sort_order')->orderBy('name')->get();
    return view('backend.hotdeal.create', compact('categories'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deal_ends_at' => 'nullable|date|after:now',
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
        ]);

        // ── Inventory automatically তৈরি করো ──────────────
        $inventory = Inventory::create([
            'product_id'   => $hotdeal->id,
            'product_type' => 'hotdeal',
            'name'         => $hotdeal->name,
            'sku'          => 'HOT-' . str_pad($hotdeal->id, 5, '0', STR_PAD_LEFT),
            'category'     => $hotdeal->category ?? 'Uncategorized',
            'stock'        => $hotdeal->stock,
            'min_stock'    => $hotdeal->low_stock_threshold ?? 5,
            'price'        => $hotdeal->price,
            'unit'         => 'pcs',
            'is_active'    => $hotdeal->is_active,
        ]);

        if ($hotdeal->stock > 0) {
            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'type'         => 'in',
                'quantity'     => $hotdeal->stock,
                'stock_before' => 0,
                'stock_after'  => $hotdeal->stock,
                'note'         => 'Initial stock — hot deal created',
                'created_by'   => Auth::id(),
            ]);
        }
        // ───────────────────────────────────────────────────

        return redirect()->route('backend.hotdeals.index')
                         ->with('success', 'Hot Deal added successfully!');
    }

   public function edit(HotDeal $hotdeal)
{
    $categories = \App\Models\Category::where('is_active', true)
                    ->orderBy('sort_order')->orderBy('name')->get();
    return view('backend.hotdeal.edit', compact('hotdeal', 'categories'));
}

    public function update(Request $request, HotDeal $hotdeal)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deal_ends_at' => 'nullable|date',
        ]);

        $imagePath = $hotdeal->image;
        if ($request->hasFile('image')) {
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('hotdeals', 'public');
        }

        $oldStock = $hotdeal->stock;

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
        ]);

        // ── Inventory sync করো ─────────────────────────────
        $inventory = Inventory::where('product_id', $hotdeal->id)
                               ->where('product_type', 'hotdeal')
                               ->first();

        if ($inventory) {
            $newStock = (int) $request->stock;

            if ($oldStock !== $newStock) {
                $diff = $newStock - $oldStock;
                InventoryMovement::create([
                    'inventory_id' => $inventory->id,
                    'type'         => $diff > 0 ? 'in' : 'out',
                    'quantity'     => abs($diff),
                    'stock_before' => $oldStock,
                    'stock_after'  => $newStock,
                    'note'         => 'Stock updated from hot deal edit',
                    'created_by'   => Auth::id(),
                ]);
            }

            $inventory->update([
                'name'      => $hotdeal->name,
                'category'  => $hotdeal->category ?? 'Uncategorized',
                'stock'     => $newStock,
                'min_stock' => $hotdeal->low_stock_threshold ?? 5,
                'price'     => $hotdeal->price,
                'is_active' => $hotdeal->is_active,
            ]);
        } else {
            // Inventory না থাকলে নতুন বানাও
            Inventory::create([
                'product_id'   => $hotdeal->id,
                'product_type' => 'hotdeal',
                'name'         => $hotdeal->name,
                'sku'          => 'HOT-' . str_pad($hotdeal->id, 5, '0', STR_PAD_LEFT),
                'category'     => $hotdeal->category ?? 'Uncategorized',
                'stock'        => $hotdeal->stock,
                'min_stock'    => $hotdeal->low_stock_threshold ?? 5,
                'price'        => $hotdeal->price,
                'unit'         => 'pcs',
                'is_active'    => $hotdeal->is_active,
            ]);
        }
        // ───────────────────────────────────────────────────

        return redirect()->route('backend.hotdeals.index')
                         ->with('success', 'Hot Deal updated successfully!');
    }

    public function destroy(HotDeal $hotdeal)
    {
        // Inventory ও delete করো
        Inventory::where('product_id', $hotdeal->id)
                 ->where('product_type', 'hotdeal')
                 ->delete();

        if ($hotdeal->image) {
            Storage::disk('public')->delete($hotdeal->image);
        }
        $hotdeal->delete();

        return redirect()->route('backend.hotdeals.index')
                         ->with('success', 'Hot Deal deleted successfully!');
    }
}