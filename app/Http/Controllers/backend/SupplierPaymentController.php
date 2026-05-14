<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SupplierPayment;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{
    // ── All Payments ──────────────────────────────────────
    public function index(Request $request)
    {
        $query = SupplierPayment::with('supplier')->latest();

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $payments  = $query->paginate(15)->withQueryString();
        $suppliers = Supplier::active()->orderBy('name')->get();

        $stats = [
            'total_paid'     => SupplierPayment::sum('paid_amount'),
            'this_month'     => SupplierPayment::whereMonth('payment_date', now()->month)->sum('paid_amount'),
            'total_due'      => Supplier::selectRaw('SUM(total_purchase - total_paid) as due')->value('due') ?? 0,
        ];

        return view('backend.suppliers.payments', compact('payments', 'suppliers', 'stats'));
    }

    // ── Store Payment ─────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'  => 'required|exists:suppliers,id',
            'paid_amount'  => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'method'       => 'required|in:cash,bank,bkash,nagad',
            'note'         => 'nullable|string',
        ]);

        SupplierPayment::create($request->only(
            'supplier_id', 'paid_amount', 'payment_date', 'method', 'note'
        ));

        // supplier এর total_paid update করো
        $supplier = Supplier::find($request->supplier_id);
        $supplier->increment('total_paid', $request->paid_amount);

        return redirect()->route('backend.supplier-payments.index')
                         ->with('success', 'Payment record যোগ করা হয়েছে!');
    }

    // ── Delete ────────────────────────────────────────────
    public function destroy(SupplierPayment $supplierPayment)
    {
        $supplierPayment->supplier->decrement('total_paid', $supplierPayment->paid_amount);
        $supplierPayment->delete();

        return redirect()->route('backend.supplier-payments.index')
                         ->with('success', 'Payment মুছে ফেলা হয়েছে।');
    }
}