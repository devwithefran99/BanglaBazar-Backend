<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Invoice {{ $invoiceNumber }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #2d2d2d;
            background: #eef0f4;
            padding: 32px 20px;
        }

        .print-controls {
            max-width: 840px;
            margin: 0 auto 18px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-print {
            background: #5a2d82;
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
            color: #5a2d82;
            border: 1.5px solid #5a2d82;
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

        .invoice-wrap {
            max-width: 840px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,.10);
        }

        /* ── Header ── */
        .inv-header {
            background: #2d1248;
            color: #fff;
            padding: 36px 48px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .brand-name  { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
        .brand-meta  { font-size: 11.5px; color: rgba(255,255,255,.6); line-height: 1.9; }

        .inv-title-block { text-align: right; }
        .inv-title   { font-size: 28px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; line-height: 1.2; }
        .inv-number  { font-size: 13px; color: rgba(255,255,255,.65); margin-top: 6px; }
        .inv-date    { font-size: 11px; color: rgba(255,255,255,.45); margin-top: 3px; }

        /* ── Type strip ── */
        .type-strip {
            background: #f8f4fc;
            border-bottom: 1px solid #e0ccf0;
            padding: 10px 48px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11.5px;
            color: #555;
        }

        .type-pill {
            background: #e8d5f8;
            color: #3b1460;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        /* ── Body ── */
        .inv-body { padding: 36px 48px; }

        /* ── Parties ── */
        .parties { display: flex; gap: 20px; margin-bottom: 28px; }

        .party {
            flex: 1;
            border: 1px solid #e8d5f8;
            border-radius: 8px;
            padding: 18px 20px;
            border-top: 3px solid #2d1248;
        }

        .party.right { border-top-color: #8e44ad; }

        .party-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #2d1248;
            margin-bottom: 10px;
        }

        .party.right .party-label { color: #8e44ad; }

        .party-name { font-size: 15px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .party-info { font-size: 12px; color: #666; line-height: 1.8; }

        /* ── Stats ── */
        .stats-row { display: flex; gap: 14px; margin-bottom: 28px; }

        .stat-card {
            flex: 1;
            background: #f8f4fc;
            border: 1px solid #e0ccf0;
            border-radius: 8px;
            padding: 14px 16px;
            text-align: center;
        }

        .stat-val   { font-size: 18px; font-weight: 800; color: #2d1248; }
        .stat-label { font-size: 10px; color: #888; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-top: 3px; }

        /* ── Table ── */
        .sec-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 10px;
        }

        .items-tbl { width: 100%; border-collapse: collapse; margin-bottom: 28px; }

        .items-tbl thead tr { background: #2d1248; color: #fff; }

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

        .items-tbl tbody tr { border-bottom: 1px solid #f4f0f8; }
        .items-tbl tbody tr:nth-child(even) { background: #faf7fd; }

        .items-tbl tbody td {
            padding: 12px 14px;
            font-size: 12.5px;
            color: #333;
            vertical-align: middle;
        }

        .items-tbl tbody td:not(:first-child):not(:last-child) { text-align: center; }
        .items-tbl tbody td:last-child { text-align: right; font-weight: 600; color: #5a2d82; }

        .items-tbl tfoot td {
            padding: 10px 14px;
            font-size: 12px;
            background: #f8f4fc;
            font-weight: 600;
            color: #444;
        }

        .items-tbl tfoot td:last-child { text-align: right; color: #5a2d82; }

        .row-num  { color: #ccc; font-size: 12px; }
        .date-txt { color: #999; font-size: 11px; }

        .method-tag {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            background: #ede8f8;
            color: #3b1460;
            text-transform: capitalize;
        }

        /* ── Summary ── */
        .summary-wrap { display: flex; justify-content: flex-end; margin-bottom: 28px; }

        .summary-box {
            width: 290px;
            border: 1px solid #e0ccf0;
            border-radius: 8px;
            overflow: hidden;
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 16px;
            font-size: 13px;
            color: #555;
            border-bottom: 1px solid #f4f0f8;
        }

        .sum-row:last-child { border-bottom: none; }

        .sum-row.total {
            background: #2d1248;
            color: #fff;
            padding: 12px 16px;
        }

        .sum-row.total .sum-val { font-size: 17px; font-weight: 800; }

        /* ── Notes ── */
        .notes-box {
            background: #f9f9fb;
            border-left: 3px solid #8e44ad;
            padding: 14px 18px;
            border-radius: 0 6px 6px 0;
        }

        .notes-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #8e44ad; margin-bottom: 6px; }
        .notes-text  { font-size: 12px; color: #666; line-height: 1.7; }

        /* ── Footer ── */
        .inv-footer {
            background: #f8f4fc;
            border-top: 1px solid #e0ccf0;
            padding: 18px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #999;
        }

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
    <a href="{{ url()->previous() }}" class="btn-back">
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
            <div class="inv-title">Payment<br>Invoice</div>
            <div class="inv-number">{{ $invoiceNumber }}</div>
            <div class="inv-date">Generated: {{ now()->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Type Strip --}}
    <div class="type-strip">
        <span class="type-pill">Supplier Payment Invoice</span>
        <span>All payments made to this supplier</span>
        <span style="margin-left:auto;">{{ $payments->count() }} records</span>
    </div>

    {{-- Body --}}
    <div class="inv-body">

        {{-- Parties --}}
        <div class="parties">
            <div class="party">
                <div class="party-label">Paid To (Supplier)</div>
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
                    <strong>Total Payments:</strong> {{ $payments->count() }}<br>
                    <strong>Paid By:</strong> Banglabazar24/7 Accounts
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-val">{{ $payments->count() }}</div>
                <div class="stat-label">Total Payments</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">৳{{ number_format($totalPaid, 0) }}</div>
                <div class="stat-label">Total Paid</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">
                    ৳{{ $payments->count() > 0 ? number_format($totalPaid / $payments->count(), 0) : '0' }}
                </div>
                <div class="stat-label">Avg per Payment</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">
                    {{ $payments->isNotEmpty() ? $payments->first()->payment_date->format('d M Y') : '—' }}
                </div>
                <div class="stat-label">Last Payment</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="sec-label">Payment History</div>
        <table class="items-tbl">
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th style="text-align:left">Date</th>
                    <th>Method</th>
                    <th style="text-align:left">Note</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $i => $payment)
                <tr>
                    <td><span class="row-num">{{ $i + 1 }}</span></td>
                    <td><span class="date-txt">{{ $payment->payment_date->format('d M Y') }}</span></td>
                    <td>
                        <span class="method-tag">{{ $payment->method ?? 'Cash' }}</span>
                    </td>
                    <td style="text-align:left;font-size:12px;color:#777;">
                        {{ $payment->note ?? '—' }}
                    </td>
                    <td>৳{{ number_format($payment->paid_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:28px;color:#aaa;">No payment records found.</td>
                </tr>
                @endforelse
            </tbody>
            @if($payments->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right;">Total Paid:</td>
                    <td>৳{{ number_format($totalPaid, 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>

        {{-- Summary --}}
        <div class="summary-wrap">
            <div class="summary-box">
                <div class="sum-row">
                    <span>Number of Payments</span>
                    <span>{{ $payments->count() }}</span>
                </div>
                <div class="sum-row">
                    <span>Average per Payment</span>
                    <span>৳{{ $payments->count() > 0 ? number_format($totalPaid / $payments->count(), 2) : '0.00' }}</span>
                </div>
                <div class="sum-row total">
                    <span style="font-size:14px;font-weight:700;">Total Paid</span>
                    <span class="sum-val">৳{{ number_format($totalPaid, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="notes-box">
            <div class="notes-title">Notes</div>
            <div class="notes-text">
                This invoice is the official payment record for {{ $supplier->name }}.
                All amounts are in BDT (Bangladeshi Taka).
                This is a system-generated document and is valid without a signature.
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="inv-footer">
        <div>
            <div class="footer-brand">Banglabazar24/7 — Accounts</div>
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