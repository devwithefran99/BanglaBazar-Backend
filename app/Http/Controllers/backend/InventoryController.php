<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            match($request->status) {
                'in_stock'     => $query->where('stock', '>', 0)->whereColumn('stock', '>', 'min_stock'),
                'low_stock'    => $query->lowStock(),
                'out_of_stock' => $query->outOfStock(),
                default        => null,
            };
        }

        $inventories = $query->latest()->paginate(15)->withQueryString();
        $categories  = Inventory::distinct()->pluck('category')->filter()->sort()->values();

        $stats = [
            'total'        => Inventory::count(),
            'in_stock'     => Inventory::where('stock', '>', 0)->whereColumn('stock', '>', 'min_stock')->count(),
            'low_stock'    => Inventory::lowStock()->count(),
            'out_of_stock' => Inventory::outOfStock()->count(),
            'total_value'  => Inventory::selectRaw('SUM(stock * price) as val')->value('val') ?? 0,
        ];

        return view('backend.inventory.index', compact('inventories', 'categories', 'stats'));
    }

    public function show(Inventory $inventory)
    {
        $inventory->load('movements.creator');
        return view('backend.inventory.show', compact('inventory'));
    }

    // ── Manually add বন্ধ — Product/HotDeal থেকে auto হবে ──
    public function create()
    {
        return redirect()->route('backend.inventory.index')
                         ->with('error', 'Inventory manually add করা যাবে না। Product বা Hot Deal add করলে automatically inventory তৈরি হবে।');
    }

    public function store(Request $request)
    {
        return redirect()->route('backend.inventory.index')
                         ->with('error', 'Inventory manually add করা যাবে না। Product বা Hot Deal add করলে automatically inventory তৈরি হবে।');
    }

    // ── Edit: শুধু min_stock, unit, supplier পরিবর্তন করা যাবে ──
   public function edit(Inventory $inventory)
{
    $categories = Inventory::distinct()->pluck('category')->filter()->sort()->values();
    return view('backend.inventory.edit', compact('inventory', 'categories'));
}

   public function update(Request $request, Inventory $inventory)
{
    $validated = $request->validate([
        'min_stock'   => 'required|integer|min:0',
        'buy_price'   => 'required|numeric|min:0',   
        'unit'        => 'required|string|max:50',
        'supplier'    => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    $inventory->update($validated);

    return redirect()->route('backend.inventory.show', $inventory)
                     ->with('success', 'Settings updated successfully!');
}

    // ── Stock adjust: in / out / adjustment ──────────────────
    public function adjustStock(Request $request, Inventory $inventory)
    {
        $request->validate([
            'type'     => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:255',
        ]);

        $stockBefore = $inventory->stock;

        if ($request->type === 'out' && $inventory->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock.']);
        }

        $newStock = match($request->type) {
            'in'         => $stockBefore + $request->quantity,
            'out'        => $stockBefore - $request->quantity,
            'adjustment' => $request->quantity,
        };

        // Inventory stock update
        $inventory->update(['stock' => $newStock]);

        // Linked product/hotdeal এর stock ও sync করো
        if ($inventory->product_type === 'hotdeal') {
            \App\Models\HotDeal::where('id', $inventory->product_id)
                               ->update(['stock' => $newStock]);
        } elseif ($inventory->product_type === 'product') {
            \App\Models\Product::where('id', $inventory->product_id)
                               ->update(['stock' => $newStock]);
        }

        InventoryMovement::create([
            'inventory_id' => $inventory->id,
            'type'         => $request->type,
            'quantity'     => $request->quantity,
            'stock_before' => $stockBefore,
            'stock_after'  => $newStock,
            'note'         => $request->note,
            'created_by'   => Auth::id(),
        ]);

        return back()->with('success', 'Stock updated successfully!');
    }

    // ── Delete: linked product থাকলে delete করা যাবে না ─────
    public function destroy(Inventory $inventory)
    {
        if ($inventory->product_id) {
            return back()->with('error', 'এই inventory টি একটি Product/HotDeal এর সাথে linked। Product delete করলে inventory automatically delete হবে।');
        }

        if ($inventory->image) Storage::disk('public')->delete($inventory->image);
        $inventory->delete();

        return redirect()->route('backend.inventory.index')
                         ->with('success', 'Item deleted successfully!');
    }
}