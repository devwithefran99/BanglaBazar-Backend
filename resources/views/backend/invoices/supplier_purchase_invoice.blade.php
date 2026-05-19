<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice {{ $invoiceNumber }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 13px; color: #2d2d2d; background: #eef0f4; padding: 32px 20px; }
        .print-controls { max-width: 840px; margin: 0 auto 18px; display: flex; gap: 10px; justify-content: flex-end; }
        .btn-print { background: #0e5c3c; color: #fff; border: none; padding: 9px 22px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-back { background: #fff; color: #0e5c3c; border: 1.5px solid #0e5c3c; padding: 9px 22px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .invoice-wrap { max-width: 840px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.10); }
        .inv-header { background: #0e3d28; color: #fff; padding: 36px 48px; display: flex; justify-content: space-between; align-items: flex-start; }
        .brand-name { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
        .brand-meta { font-size: 11.5px; color: rgba(255,255,255,.6); line-height: 1.9; }
        .inv-title-block { text-align: right; }
        .inv-title { font-size: 28px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,.95); line-height: 1.2; }
        .inv-number { font-size: 13px; color: rgba(255,255,255,.65); margin-top: 6px; }
        .inv-date { font-size: 11px; color: rgba(255,255,255,.45); margin-top: 3px; }
        .type-strip { background: #f0faf5; border-bottom: 1px solid #c8e6d8; padding: 10px 48px; display: flex; align-items: center; gap: 10px; font-size: 11.5px; color: #555; }
        .type-pill { background: #d1ecdf; color: #0a3622; padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
        .inv-body { padding: 36px 48px; }
        .parties { display: flex; gap: 20px; margin-bottom: 28px; }
        .party { flex: 1; border: 1px solid #e0ede5; border-radius: 8px; padding: 18px 20px; border-top: 3px solid #0e3d28; }
        .party.right { border-top-color: #27ae60; }
        .party-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #0e3d28; margin-bottom: 10px; }
        .party.right .party-label { color: #27ae60; }
        .party-name { font-size: 15px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .party-info { font-size: 12px; color: #666; line-height: 1.8; }
        .stats-row { display: flex; gap: 14px; margin-bottom: 28px; }
        .stat-card { flex: 1; background: #f4fdf8; border: 1px solid #c8e6d8; border-radius: 8px; padding: 14px 16px; text-align: center; }
        .stat-val { font-size: 18px; font-weight: 800; color: #0e3d28; }
        .stat-label { font-size: 10px; color: #888; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-top: 3px; }
        .sec-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 10px; }
        .items-tbl { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
        .items-tbl thead tr { background: #0e3d28; color: #fff; }
        .items-tbl thead th { padding: 11px 14px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
        .items-tbl thead th:first-child { border-radius: 6px 0 0 6px; }
        .items-tbl thead th:last-child { border-radius: 0 6px 6px 0; text-align: right; }
        .items-tbl thead th:not(:first-child):not(:last-child) { text-align: center; }
        .items-tbl tbody tr { border-bottom: 1px solid #f0f4f0; }
        .items-tbl tbody tr:nth-child(even) { background: #f8fdf9; }
        .items-tbl tbody td { padding: 12px 14px; font-size: 12.5px; color: #333; vertical-align: middle; }
        .items-tbl tbody td:not(:first-child):not(:last-child) { text-align: center; }
        .items-tbl tbody td:last-child { text-align: right; font-weight: 600; color: #0e3d28; }
        .items-tbl tfoot td { padding: 10px 14px; font-size: 12px; background: #f0faf5; font-weight: 600; color: #444; }
        .items-tbl tfoot td:last-child { text-align: right; }
        .items-tbl tfoot td:nth-child(4) { text-align: center; }
        .item-name { font-weight: 600; color: #1a1a2e; }
        .item-note { font-size: 10.5px; color: #aaa; margin-top: 2px; }
        .row-num { color: #ccc; font-size: 12px; }
        .date-txt { color: #999; font-size: 11px; }
        .summary-wrap { display: flex; justify-content: flex-end; margin-bottom: 28px; }
        .summary-box { width: 290px; border: 1px solid #c8e6d8; border-radius: 8px; overflow: hidden; }
        .sum-row { display: flex; justify-content: space-between; padding: 9px 16px; font-size: 13px; color: #555; border-bottom: 1px solid #e8f5e9; }
        .sum-row:last-child { border-bottom: none; }
        .sum-row.total { background: #0e3d28; color: #fff; padding: 12px 16px; }
        .sum-row.total .sum-val { font-size: 17px; font-weight: 800; }
        .notes-box { background: #f9f9fb; border-left: 3px solid #27ae60; padding: 14px 18px; border-radius: 0 6px 6px 0; }
        .notes-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #27ae60; margin-bottom: 6px; }
        .notes-text { font-size: 12px; color: #666; line-height: 1.7; }
        .inv-footer { background: #f0faf5; border-top: 1px solid #c8e6d8; padding: 18px 48px; display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #999; }
        .footer-brand { font-size: 13px; font-weight: 600; color: #555; }
      @media print {
    body { background: #fff; padding: 0; font-size: 11px; }
    .print-controls { display: none; }
    .invoice-wrap { box-shadow: none; border-radius: 0; max-width: 100%; }
    .inv-header { padding: 16px 28px; }
    .brand-name { font-size: 16px; }
    .inv-title { font-size: 22px; }
    .type-strip { padding: 6px 28px; }
    .inv-body { padding: 16px 28px; }
    .parties { margin-bottom: 14px; }
    .party { padding: 10px 14px; }
    .party-name { font-size: 13px; }
    .party-info { font-size: 10px; line-height: 1.6; }
    .stats-row { margin-bottom: 14px; gap: 8px; }
    .stat-card { padding: 8px 10px; }
    .stat-val { font-size: 14px; }
    .items-tbl { margin-bottom: 14px; }
    .items-tbl thead th { padding: 7px 10px; font-size: 10px; }
    .items-tbl tbody td { padding: 7px 10px; font-size: 11px; }
    .summary-wrap { margin-bottom: 14px; }
    .sum-row { padding: 6px 12px; font-size: 11px; }
    .notes-box { padding: 10px 14px; }
    .notes-text { font-size: 10px; }
    .inv-footer { padding: 10px 28px; font-size: 10px; }
    .inv-header, .items-tbl thead tr, .sum-row.total {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    @page { size: A4; margin: 8mm; }
}
    </style>
</head>
<body>

<div class="print-controls">
    <a href="{{ url()->previous() }}" class="btn-back">Back</a>
    <button class="btn-print" onclick="window.print()">Print / Save PDF</button>
</div>

<div class="invoice-wrap">

    <div class="inv-header">
        <div>
            <div class="brand-name">MyShop</div>
            <div class="brand-meta">
                Dhaka, Bangladesh<br>
                accounts@myshop.com<br>
                +880 1700-000000
            </div>
        </div>
        <div class="inv-title-block">
            <div class="inv-title">Purchase<br>Invoice</div>
            <div class="inv-number">{{ $invoiceNumber }}</div>
            <div class="inv-date">Generated: {{ now()->format('d M Y') }}</div>
        </div>
    </div>

    <div class="type-strip">
        <span class="type-pill">Supplier Purchase Invoice</span>
        <span>All purchase records from this supplier</span>
        <span style="margin-left:auto;">{{ $purchases->count() }} records</span>
    </div>

    <div class="inv-body">

        <div class="parties">
            <div class="party">
                <div class="party-label">Supplier</div>
                <div class="party-name">{{ $supplier->name }}</div>
                <div class="party-info">
                    @if($supplier->company){{ $supplier->company }}<br>@endif
                    @if($supplier->email){{ $supplier->email }}<br>@endif
                    @if($supplier->phone){{ $supplier->phone }}<br>@endif
                  @if($supplier->address)
    {{ $supplier->address }}{{ $supplier->city ? ', '.$supplier->city : '' }}
@endif
                </div>
            </div>
            <div class="party right">
                <div class="party-label">Invoice Details</div>
                <div class="party-info">
                    <strong>Invoice No:</strong> {{ $invoiceNumber }}<br>
                    <strong>Generated:</strong> {{ now()->format('d M Y') }}<br>
                    <strong>Supplier ID:</strong> #{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}<br>
                    <strong>Total Entries:</strong> {{ $purchases->count() }}<br>
                    <strong>Status:</strong> {{ ucfirst($supplier->status ?? 'Active') }}
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-val">{{ $purchases->count() }}</div>
                <div class="stat-label">Total Entries</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">{{ number_format($totalQty) }}</div>
                <div class="stat-label">Total Qty</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">৳{{ number_format($totalCost, 0) }}</div>
                <div class="stat-label">Total Cost</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">৳{{ $totalQty > 0 ? number_format($totalCost / $totalQty, 2) : '0.00' }}</div>
                <div class="stat-label">Avg Unit Cost</div>
            </div>
        </div>

        <div class="sec-label">Purchase Records</div>
        <table class="items-tbl">
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th style="text-align:left">Product</th>
                    <th>Date</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $i => $purchase)
                <tr>
                    <td><span class="row-num">{{ $i + 1 }}</span></td>
                    <td>
                        <div class="item-name">{{ $purchase->product_name }}</div>
                        @if($purchase->notes)
                            <div class="item-note">{{ $purchase->notes }}</div>
                        @endif
                    </td>
                    <td><span class="date-txt">{{ $purchase->purchase_date->format('d M Y') }}</span></td>
                    <td>{{ number_format($purchase->quantity) }}</td>
                    <td>৳{{ number_format($purchase->buying_price, 2) }}</td>
                    <td>৳{{ number_format($purchase->quantity * $purchase->buying_price, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:28px;color:#aaa;">No purchase records found.</td>
                </tr>
                @endforelse
            </tbody>
            @if($purchases->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;">Totals:</td>
                    <td style="text-align:center;">{{ number_format($totalQty) }}</td>
                    <td></td>
                    <td style="text-align:right;color:#0e3d28;">৳{{ number_format($totalCost, 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>

        <div class="summary-wrap">
            <div class="summary-box">
                <div class="sum-row">
                    <span>Total Entries</span>
                    <span>{{ $purchases->count() }}</span>
                </div>
                <div class="sum-row">
                    <span>Total Quantity</span>
                    <span>{{ number_format($totalQty) }} units</span>
                </div>
                <div class="sum-row">
                    <span>Avg Unit Cost</span>
                    <span>৳{{ $totalQty > 0 ? number_format($totalCost / $totalQty, 2) : '0.00' }}</span>
                </div>
                <div class="sum-row total">
                    <span style="font-size:14px;font-weight:700;">Grand Total</span>
                    <span class="sum-val">৳{{ number_format($totalCost, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="notes-box">
            <div class="notes-title">Notes</div>
            <div class="notes-text">
                This invoice is the official purchase record for {{ $supplier->name }}.
                For any discrepancy, please contact the accounts department.
                This is a system-generated document.
            </div>
        </div>

    </div>

    <div class="inv-footer">
        <div>
            <div class="footer-brand">MyShop — Accounts</div>
            <div>System generated document.</div>
        </div>
        <div style="text-align:right;">
            Printed: {{ now()->format('d M Y, h:i A') }}<br>
            {{ $invoiceNumber }}
        </div>
    </div>

</div>
</body>
</html>