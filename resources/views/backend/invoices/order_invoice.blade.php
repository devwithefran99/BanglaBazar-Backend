<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #2d2d2d;
            background: #eef0f4;
            padding: 32px 20px;
        }

        /* ── Controls (screen only) ── */
        .print-controls {
            max-width: 820px;
            margin: 0 auto 18px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-print {
            background: #3c3c8e;
            color: #fff;
            border: none;
            padding: 9px 22px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back {
            background: #fff;
            color: #3c3c8e;
            border: 1.5px solid #3c3c8e;
            padding: 9px 22px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Wrapper ── */
        .invoice-wrap {
            max-width: 820px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,.10);
        }

        /* ── Header ── */
        .inv-header {
            background: #1e1e4b;
            color: #fff;
            padding: 36px 48px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .brand-meta {
            font-size: 11.5px;
            color: rgba(255,255,255,.65);
            line-height: 1.9;
        }

        .inv-title-block { text-align: right; }

        .inv-title {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,.95);
        }

        .inv-number {
            font-size: 13px;
            color: rgba(255,255,255,.7);
            margin-top: 5px;
        }

        .inv-date {
            font-size: 11px;
            color: rgba(255,255,255,.5);
            margin-top: 3px;
        }

        /* ── Status strip ── */
        .status-strip {
            padding: 10px 48px;
            background: #f6f7fb;
            border-bottom: 1px solid #e8eaf0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11.5px;
            color: #888;
        }

        .status-pill {
            display: inline-block;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .s-pending   { background:#fff3cd; color:#856404; }
        .s-confirmed { background:#cff4fc; color:#055160; }
        .s-shipped   { background:#cfe2ff; color:#084298; }
        .s-delivered { background:#d1e7dd; color:#0a3622; }
        .s-cancelled { background:#f8d7da; color:#842029; }

        /* ── Body ── */
        .inv-body { padding: 36px 48px; }

        /* ── Parties ── */
        .parties {
            display: flex;
            gap: 20px;
            margin-bottom: 32px;
        }

        .party {
            flex: 1;
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            padding: 18px 20px;
            border-top: 3px solid #1e1e4b;
        }

        .party.right { border-top-color: #696cff; }

        .party-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e1e4b;
            margin-bottom: 10px;
        }

        .party.right .party-label { color: #696cff; }

        .party-name {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .party-info {
            font-size: 12px;
            color: #666;
            line-height: 1.8;
        }

        /* ── Section label ── */
        .sec-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 10px;
        }

        /* ── Table ── */
        .items-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .items-tbl thead tr {
            background: #1e1e4b;
            color: #fff;
        }

        .items-tbl thead th {
            padding: 11px 14px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .items-tbl thead th:first-child { border-radius: 6px 0 0 6px; }
        .items-tbl thead th:last-child  { border-radius: 0 6px 6px 0; text-align: right; }
        .items-tbl thead th:not(:first-child):not(:last-child) { text-align: center; }

        .items-tbl tbody tr {
            border-bottom: 1px solid #f0f0f4;
        }

        .items-tbl tbody tr:nth-child(even) { background: #fafbff; }

        .items-tbl tbody td {
            padding: 13px 14px;
            font-size: 13px;
            color: #333;
            vertical-align: middle;
        }

        .items-tbl tbody td:not(:first-child):not(:last-child) { text-align: center; }
        .items-tbl tbody td:last-child { text-align: right; font-weight: 600; color: #1e1e4b; }

        .item-name { font-weight: 600; color: #1a1a2e; }

        .type-tag {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 3px;
        }

        .tag-hotdeal { background: #fde8e8; color: #c0392b; }
        .tag-product { background: #e8f0fd; color: #2559b6; }

        .row-num { color: #ccc; font-size: 12px; }

        /* ── Summary ── */
        .summary-wrap {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 28px;
        }

        .summary-box {
            width: 290px;
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            overflow: hidden;
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 16px;
            font-size: 13px;
            color: #555;
            border-bottom: 1px solid #f0f0f4;
        }

        .sum-row:last-child { border-bottom: none; }

        .sum-row.total {
            background: #1e1e4b;
            color: #fff;
            padding: 12px 16px;
        }

        .sum-row.total .sum-val {
            font-size: 17px;
            font-weight: 800;
        }

        .free-val { color: #27ae60; font-weight: 600; }

        /* ── Notes ── */
        .notes-box {
            background: #f9f9fb;
            border-left: 3px solid #696cff;
            padding: 14px 18px;
            border-radius: 0 6px 6px 0;
            margin-bottom: 0;
        }

        .notes-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #696cff;
            margin-bottom: 6px;
        }

        .notes-text {
            font-size: 12px;
            color: #666;
            line-height: 1.7;
        }

        /* ── Footer ── */
        .inv-footer {
            background: #f6f7fb;
            border-top: 1px solid #e8eaf0;
            padding: 18px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #999;
        }

        .footer-brand {
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }

        /* ── Cancelled watermark ── */
        @if($order->status === 'cancelled')
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 90px;
            font-weight: 900;
            color: rgba(200,0,0,.06);
            text-transform: uppercase;
            pointer-events: none;
            letter-spacing: 6px;
            white-space: nowrap;
        }
        @endif

        /* ── Print ── */
       @media print {
    body { background: #fff; padding: 0; font-size: 11px; }
    .print-controls { display: none; }
    .invoice-wrap { box-shadow: none; border-radius: 0; max-width: 100%; }
    .inv-header { padding: 16px 28px; }
    .brand-name { font-size: 16px; }
    .inv-title { font-size: 22px; }
    .status-strip { padding: 6px 28px; }
    .inv-body { padding: 16px 28px; }
    .parties { margin-bottom: 14px; }
    .party { padding: 10px 14px; }
    .party-name { font-size: 13px; }
    .party-info { font-size: 10px; line-height: 1.6; }
    .sec-label { margin-bottom: 6px; }
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

@if($order->status === 'cancelled')
    <div class="watermark">Cancelled</div>
@endif

<div class="print-controls">
    <a href="{{ route('backend.orders.show', $order->id) }}" class="btn-back">
        <i class="bx bx-arrow-back"></i> Back
    </a>
    <button class="btn-print" onclick="window.print()">
        <i class="bx bx-printer"></i> Print / Save PDF
    </button>
</div>

<div class="invoice-wrap">

    {{-- Header --}}
    <div class="inv-header">
        <div>
            <div class="brand-name">Banglabazar24/7</div>
            <div class="brand-meta">
                Chattogram, Bangladesh<br>
                banglabazar247bd@gmail.com<br>
                +8801740-604565
            </div>
        </div>
        <div class="inv-title-block">
            <div class="inv-title">Invoice</div>
            <div class="inv-number">{{ $invoiceNumber }}</div>
            <div class="inv-date">Date: {{ $order->created_at->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Status --}}
    <div class="status-strip">
        <span>Order Status:</span>
        <span class="status-pill s-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        <span style="margin-left:auto;">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- Body --}}
    <div class="inv-body">

        {{-- Parties --}}
        <div class="parties">
            <div class="party">
                <div class="party-label">Bill To</div>
                <div class="party-name">{{ $order->user->name ?? 'Guest Customer' }}</div>
                <div class="party-info">
                    {{ $order->user->email ?? '—' }}<br>
                    {{ $order->phone }}<br>
                    {{ $order->address }}
                </div>
            </div>
            <div class="party right">
                <div class="party-label">Invoice Details</div>
                <div class="party-info">
                    <strong>Invoice No:</strong> {{ $invoiceNumber }}<br>
                    <strong>Order ID:</strong> #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}<br>
                    <strong>Issue Date:</strong> {{ $order->created_at->format('d M Y') }}<br>
                    <strong>Payment:</strong> Cash on Delivery<br>
                    <strong>Items:</strong> {{ $order->items->count() }}
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="sec-label">Ordered Items</div>
        <table class="items-tbl">
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th style="text-align:left">Description</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $i => $item)
                <tr>
                    <td><span class="row-num">{{ $i + 1 }}</span></td>
                    <td>
                        <div class="item-name">{{ $item->product_name }}</div>
                        @if($item->product_type === 'hotdeal')
                            <span class="type-tag tag-hotdeal">Hot Deal</span>
                        @else
                            <span class="type-tag tag-product">Product</span>
                        @endif
                    </td>
                    <td>৳{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary --}}
        <div class="summary-wrap">
            <div class="summary-box">
                <div class="sum-row">
                    <span>Subtotal</span>
                    <span>৳{{ number_format($order->total_price, 2) }}</span>
                </div>
                <div class="sum-row">
                    <span>Discount</span>
                    <span>৳0.00</span>
                </div>
                <div class="sum-row">
                    <span>Shipping</span>
                    <span class="free-val">Free</span>
                </div>
                <div class="sum-row">
                    <span>Tax</span>
                    <span>৳0.00</span>
                </div>
                <div class="sum-row total">
                    <span style="font-size:14px;font-weight:700;">Total</span>
                    <span class="sum-val">৳{{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="notes-box">
            <div class="notes-title">Terms & Notes</div>
            <div class="notes-text">
                This invoice is an official receipt for your order. Payment method: Cash on Delivery.
                For any issues please contact us within 7 days of delivery. Thank you for shopping with us.
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="inv-footer">
        <div>
            <div class="footer-brand">Banglabazar24/7</div>
            <div>Thank you for your order.</div>
        </div>
        <div style="text-align:right;">
            Generated: {{ now()->format('d M Y, h:i A') }}<br>
            {{ $invoiceNumber }}
        </div>
    </div>

</div>
</body>
</html>