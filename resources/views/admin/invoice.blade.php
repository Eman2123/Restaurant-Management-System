<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            padding: 30px 15px;
        }
        .receipt {
            background: #fff;
            width: 300px;
            padding: 24px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .receipt-header { text-align: center; margin-bottom: 20px; }
        .receipt-header h1 {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }
        .receipt-header p {
            font-size: 11px;
            color: #666;
            line-height: 1.6;
        }
        .divider-dashed {
            border: none;
            border-top: 2px dashed #ddd;
            margin: 14px 0;
        }
        .divider-solid {
            border: none;
            border-top: 2px solid #000;
            margin: 14px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 5px;
        }
        .info-row .label { color: #888; }
        .info-row .value { font-weight: 700; }
        .items-header {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            font-size: 12px;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dotted #eee;
        }
        .item-row:last-child { border-bottom: none; }
        .item-left { flex: 1; }
        .item-name { font-weight: 600; margin-bottom: 2px; }
        .item-detail { font-size: 10px; color: #888; }
        .item-price { font-weight: 700; white-space: nowrap; margin-left: 10px; }
        .totals { margin-top: 10px; }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 5px;
        }
        .total-row.grand {
            font-size: 16px;
            font-weight: 900;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 2px solid #000;
        }
        .payment-box {
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 12px;
            margin: 14px 0;
        }
        .payment-status {
            text-align: center;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 2px;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        .paid   { background: #d4edda; color: #155724; }
        .unpaid { background: #fff3cd; color: #856404; }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
        }
        .receipt-footer p {
            font-size: 11px;
            color: #666;
            line-height: 1.8;
        }
        .receipt-footer .thank {
            font-size: 15px;
            font-weight: 900;
            color: #000;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .barcode {
            font-size: 40px;
            letter-spacing: 4px;
            margin: 10px 0;
            font-family: 'Libre Barcode 39', cursive;
        }
        .order-number {
            font-size: 28px;
            font-weight: 900;
            color: #000;
            letter-spacing: 3px;
        }

        /* Print styles */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                width: 100%;
                max-width: 300px;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="receipt">

    <!-- Header -->
    <div class="receipt-header">
        <h1>THE RESTAURANT</h1>
        <p>
            123 Main Street, Karachi<br>
            Tel: +92 300 1234567<br>
            info@restaurant.com
        </p>
        <div class="order-number mt-3">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
    </div>

    <hr class="divider-solid">

    <!-- Order Info -->
    <div class="info-row">
        <span class="label">Date:</span>
        <span class="value">
            {{ $order->created_at->format('d M Y, h:i A') }}
        </span>
    </div>
    <div class="info-row">
        <span class="label">Customer:</span>
        <span class="value">{{ $order->user->name ?? 'Walk-in' }}</span>
    </div>
    <div class="info-row">
        <span class="label">Table:</span>
        <span class="value">
            {{ $order->table
                ? 'Table #'.$order->table->table_number
                : 'Takeaway' }}
        </span>
    </div>
    <div class="info-row">
        <span class="label">Type:</span>
        <span class="value">
            {{ ucfirst(str_replace('_',' ',$order->order_type)) }}
        </span>
    </div>

    <hr class="divider-dashed">

    <!-- Items Header -->
    <div class="items-header">
        <span>Item</span>
        <span>Amount</span>
    </div>

    <!-- Items -->
    @foreach($order->orderItems as $item)
    <div class="item-row">
        <div class="item-left">
            <div class="item-name">{{ $item->menuItem->name }}</div>
            <div class="item-detail">
                {{ $item->quantity }} x
                Rs.{{ number_format($item->unit_price, 0) }}
            </div>
            @if($item->special_instructions)
            <div class="item-detail" style="color:#fd7e14;">
                * {{ $item->special_instructions }}
            </div>
            @endif
        </div>
        <div class="item-price">
            Rs.{{ number_format($item->subtotal, 0) }}
        </div>
    </div>
    @endforeach

    <hr class="divider-dashed">

    <!-- Totals -->
    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rs.{{ number_format($order->total_amount, 0) }}</span>
        </div>
        <div class="total-row">
            <span>Tax (0%):</span>
            <span>Rs. 0</span>
        </div>
        <div class="total-row">
            <span>Discount:</span>
            <span>Rs. 0</span>
        </div>
        <div class="total-row grand">
            <span>TOTAL:</span>
            <span>Rs.{{ number_format($order->total_amount, 0) }}</span>
        </div>
    </div>

    <!-- Payment -->
    <div class="payment-box">
        <div class="payment-status
             {{ $order->payment_status === 'paid' ? 'paid' : 'unpaid' }}">
            {{ strtoupper($order->payment_status) }}
        </div>
        <div class="info-row mb-0">
            <span class="label">Method:</span>
            <span class="value">
                {{ ucfirst($order->payment_method) }}
            </span>
        </div>
        <div class="info-row mb-0">
            <span class="label">Status:</span>
            <span class="value">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    @if($order->notes)
    <div style="font-size:11px; color:#666; margin-bottom:14px;">
        <strong>Note:</strong> {{ $order->notes }}
    </div>
    @endif

    <hr class="divider-dashed">

    <!-- Footer -->
    <div class="receipt-footer">
        <div class="thank">Thank You!</div>
        <p>
            Please visit us again<br>
            Powered by RMS
        </p>
    </div>

</div>

<!-- Print Buttons -->
<div class="no-print"
     style="position:fixed; top:20px; right:20px;
            display:flex; flex-direction:column; gap:10px;">
    <button onclick="window.print()"
            style="background:#198754; color:#fff; border:none;
                   padding:12px 24px; border-radius:8px;
                   font-weight:700; cursor:pointer; font-size:14px;">
        🖨 Print Receipt
    </button>
    <a href="{{ route('admin.orders.invoice.download', $order) }}"
       style="background:#0d6efd; color:#fff; border:none;
              padding:12px 24px; border-radius:8px;
              font-weight:700; cursor:pointer; font-size:14px;
              text-align:center; text-decoration:none;">
        ⬇ Download PDF
    </a>
    <a href="{{ route('admin.orders.show', $order) }}"
       style="background:#6c757d; color:#fff; border:none;
              padding:12px 24px; border-radius:8px;
              font-weight:700; cursor:pointer; font-size:14px;
              text-align:center; text-decoration:none;">
        ← Back
    </a>
</div>

</body>
</html>