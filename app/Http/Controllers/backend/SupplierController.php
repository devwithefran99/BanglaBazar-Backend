<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // ── All Suppliers ─────────────────────────────────────
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $suppliers = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'          => Supplier::count(),
            'active'         => Supplier::active()->count(),
            'total_purchase' => Supplier::sum('total_purchase'),
            'total_due'      => Supplier::selectRaw('SUM(total_purchase - total_paid) as due')->value('due') ?? 0,
        ];

        return view('backend.suppliers.index', compact('suppliers', 'stats'));
    }

    // ── Create Form ───────────────────────────────────────
    public function create()
    {
        return view('backend.suppliers.create');
    }

    // ── Store ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'notes'   => 'nullable|string',
        ]);

        Supplier::create($request->only('name', 'phone', 'address', 'notes'));

        return redirect()->route('backend.suppliers.index')
                         ->with('success', 'Supplier সফলভাবে যোগ করা হয়েছে!');
    }

    // ── Edit Form ─────────────────────────────────────────
    public function edit(Supplier $supplier)
    {
        return view('backend.suppliers.edit', compact('supplier'));
    }

    // ── Update ────────────────────────────────────────────
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'notes'   => 'nullable|string',
            'status'  => 'required|in:active,inactive',
        ]);

        $supplier->update($request->only('name', 'phone', 'address', 'notes', 'status'));

        return redirect()->route('backend.suppliers.index')
                         ->with('success', 'Supplier আপডেট হয়েছে!');
    }

    // ── Delete ────────────────────────────────────────────
    public function destroy(Supplier $supplier)
    {
        if ($supplier->purchases()->exists()) {
            return back()->with('error', 'এই supplier এর purchase record আছে। Delete করা যাবে না।');
        }
        $supplier->delete();
        return redirect()->route('backend.suppliers.index')
                         ->with('success', 'Supplier মুছে ফেলা হয়েছে।');
    }
    public function show(Supplier $supplier)
{
    $supplier->load(['purchases', 'payments']);
    return view('backend.suppliers.show', compact('supplier'));
}
}