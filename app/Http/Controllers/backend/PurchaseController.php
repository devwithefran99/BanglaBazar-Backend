<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // ── All Purchases ─────────────────────────────────────
    public function index(Request $request)
    {
        $query = Purchase::with('supplier')->latest();

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $purchases  = $query->paginate(15)->withQueryString();
        $suppliers  = Supplier::active()->orderBy('name')->get();

        $stats = [
            'total_purchases' => Purchase::count(),
            'total_cost'      => Purchase::selectRaw('SUM(quantity * buying_price) as total')->value('total') ?? 0,
            'this_month'      => Purchase::whereMonth('purchase_date', now()->month)->selectRaw('SUM(quantity * buying_price) as total')->value('total') ?? 0,
        ];

        return view('backend.suppliers.purchases', compact('purchases', 'suppliers', 'stats'));
    }

    // ── Add Purchase Form ─────────────────────────────────
    public function create()
    {
        $suppliers = Supplier::active()->orderBy('name')->get();
      return view('backend.suppliers.purchase_create', compact('suppliers'));
    }

    // ── Store Purchase ────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'product_name'  => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'buying_price'  => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes'         => 'nullable|string',
        ]);

        $totalCost = $request->quantity * $request->buying_price;

        Purchase::create($request->only(
            'supplier_id', 'product_name', 'quantity', 'buying_price', 'purchase_date', 'notes'
        ));

        // supplier এর total_purchase update করো
        $supplier = Supplier::find($request->supplier_id);
        $supplier->increment('total_purchase', $totalCost);

        return redirect()->route('backend.purchases.index')
                         ->with('success', 'Purchase record যোগ করা হয়েছে!');
    }

    // ── Delete ────────────────────────────────────────────
    public function destroy(Purchase $purchase)
    {
        // supplier এর total_purchase থেকে কমাও
        $purchase->supplier->decrement('total_purchase', $purchase->total_cost);
        $purchase->delete();

        return redirect()->route('backend.purchases.index')
                         ->with('success', 'Purchase মুছে ফেলা হয়েছে।');
    }
}