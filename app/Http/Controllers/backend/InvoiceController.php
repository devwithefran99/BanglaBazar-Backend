<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierPayment;

class InvoiceController extends Controller
{
    /**
     * Invoice Section — main index page
     * Route: GET /admin/invoices
     */
    public function index()
    {
        $totalOrders    = Order::whereIn('status', ['confirmed','shipped','delivered'])->count();
        $totalPurchases = Purchase::count();
        $totalPayments  = SupplierPayment::count();

        $recentOrders    = Order::with('user')
                                ->whereIn('status', ['confirmed','shipped','delivered'])
                                ->latest()->take(5)->get();
        $recentPurchases = Purchase::with('supplier')->latest()->take(5)->get();
        $recentPayments  = SupplierPayment::with('supplier')->latest()->take(5)->get();

        return view('backend.invoices.index', compact(
            'totalOrders', 'totalPurchases', 'totalPayments',
            'recentOrders', 'recentPurchases', 'recentPayments'
        ));
    }

    /**
     * Customer Order Invoice
     * Route: GET /orders/{id}/invoice
     */
    public function orderInvoice($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);

        foreach ($order->items as $item) {
            $item->productModel = $item->product_type === 'hotdeal'
                ? HotDeal::find($item->product_id)
                : Product::find($item->product_id);
        }

        $invoiceNumber = 'INV-ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);

        return view('backend.invoices.order_invoice', compact('order', 'invoiceNumber'));
    }

    /**
     * Supplier Purchases Invoice
     * Route: GET /admin/suppliers/{id}/purchase-invoice
     */
    public function supplierPurchaseInvoice($id)
    {
        $supplier  = Supplier::findOrFail($id);
        $purchases = Purchase::where('supplier_id', $id)->latest('purchase_date')->get();

        $totalQty  = $purchases->sum('quantity');
        $totalCost = $purchases->sum(fn($p) => $p->quantity * $p->buying_price);
        $invoiceNumber = 'INV-PUR-' . str_pad($supplier->id, 5, '0', STR_PAD_LEFT);

        return view('backend.invoices.supplier_purchase_invoice', compact(
            'supplier', 'purchases', 'totalQty', 'totalCost', 'invoiceNumber'
        ));
    }

    /**
     * Supplier Payments Invoice
     * Route: GET /admin/suppliers/{id}/payment-invoice
     */
    public function supplierPaymentInvoice($id)
    {
        $supplier = Supplier::findOrFail($id);
        $payments = SupplierPayment::where('supplier_id', $id)->latest('payment_date')->get();

        $totalPaid     = $payments->sum('paid_amount');
        $invoiceNumber = 'INV-PAY-' . str_pad($supplier->id, 5, '0', STR_PAD_LEFT);

        return view('backend.invoices.supplier_payment_invoice', compact(
            'supplier', 'payments', 'totalPaid', 'invoiceNumber'
        ));
    }
}