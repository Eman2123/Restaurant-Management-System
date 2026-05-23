@extends('layouts.admin')
@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')

<style>
    /* ============================================
       THEME VARIABLES
    ============================================ */
    :root {
        --od-card-bg:      #ffffff;
        --od-card-border:  #e8ecf0;
        --od-card-shadow:  0 2px 16px rgba(0,0,0,0.07);
        --od-text-heading: #1e293b;
        --od-text-body:    #4a5568;
        --od-text-muted:   #94a3b8;
        --od-table-head:   #f7f9fc;
        --od-table-border: #f1f5f9;
        --od-table-hover:  #f8faff;
        --od-input-bg:     #f8fafc;
        --od-input-border: #e2e8f0;
        --od-input-text:   #1e293b;
        --od-input-focus:  #ffffff;
        --od-badge-bg:     #f1f5f9;
        --od-divider:      #f1f5f9;
        --od-row-bg:       #f7f9fc;
    }

    [data-theme="dark"],
    body.dark,
    body.dark-mode,
    html[data-bs-theme="dark"] {
        --od-card-bg:      #1c2333;
        --od-card-border:  #2a3447;
        --od-card-shadow:  0 2px 20px rgba(0,0,0,0.35);
        --od-text-heading: #e2e8f0;
        --od-text-body:    #94a3b8;
        --od-text-muted:   #4a5568;
        --od-table-head:   #141A21;
        --od-table-border: #1e2a3a;
        --od-table-hover:  #1e2d40;
        --od-input-bg:     #141A21;
        --od-input-border: #2a3447;
        --od-input-text:   #e2e8f0;
        --od-input-focus:  #1a2234;
        --od-badge-bg:     #1e2a3a;
        --od-divider:      #1e2a3a;
        --od-row-bg:       #141A21;
    }

    /* ============================================
       PAGE HEADER
    ============================================ */
    .od-header {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        margin-bottom:   22px;
        flex-wrap:       wrap;
        gap:             12px;
    }

    .od-header-left { display: flex; align-items: center; gap: 10px; }

    .od-page-title {
        font-size:   1.05rem;
        font-weight: 700;
        color:       var(--od-text-heading);
        display:     flex;
        align-items: center;
        gap:         9px;
        margin:      0;
    }

    .od-title-icon {
        width:           36px;
        height:          36px;
        background:      linear-gradient(135deg,#1d4ed8,#3b82f6);
        border-radius:   10px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        color:           #fff;
        font-size:       0.88rem;
        flex-shrink:     0;
        box-shadow:      0 3px 10px rgba(59,130,246,0.28);
    }

    .od-breadcrumb {
        display:     flex;
        align-items: center;
        gap:         5px;
        font-size:   0.75rem;
        color:       var(--od-text-muted);
        margin-top:  3px;
    }

    .od-breadcrumb a {
        color:           var(--od-text-muted);
        text-decoration: none;
        transition:      color 0.2s;
    }

    .od-breadcrumb a:hover { color: #3b82f6; }
    .od-breadcrumb .sep    { font-size: 0.52rem; opacity: 0.4; }
    .od-breadcrumb .cur    { color: var(--od-text-heading); font-weight: 600; }

    /* header action buttons */
    .od-header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .od-hdr-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             6px;
        padding:         9px 16px;
        border-radius:   10px;
        font-size:       0.845rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        text-decoration: none;
        transition:      all 0.22s ease;
        white-space:     nowrap;
    }

    .od-hdr-btn i    { font-size: 0.78rem; }
    .od-hdr-btn:hover {
        transform:       translateY(-2px);
        text-decoration: none;
    }

    .od-btn-back {
        background:   var(--od-card-bg);
        color:        var(--od-text-body);
        border-color: var(--od-card-border);
        box-shadow:   var(--od-card-shadow);
    }

    .od-btn-back:hover {
        border-color: #64748b;
        color:        var(--od-text-heading);
    }

    .od-btn-back:hover i { transform: translateX(-3px); }

    .od-btn-invoice {
        background:  linear-gradient(135deg,#065f46,#10b981);
        color:       #fff;
        box-shadow:  0 3px 10px rgba(16,185,129,0.26);
    }

    .od-btn-invoice:hover {
        box-shadow: 0 6px 18px rgba(16,185,129,0.40);
        color:      #fff;
    }

    /* ============================================
       CARDS
    ============================================ */
    .od-card {
        background:    var(--od-card-bg);
        border:        1px solid var(--od-card-border);
        border-radius: 14px;
        box-shadow:    var(--od-card-shadow);
        overflow:      hidden;
        height:        100%;
        animation:     od-up 0.42s ease both;
    }

    @keyframes od-up {
        from { opacity:0; transform:translateY(14px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .od-card-hd {
        padding:       13px 18px;
        border-bottom: 1px solid var(--od-card-border);
        background:    var(--od-row-bg);
        display:       flex;
        align-items:   center;
        gap:           8px;
    }

    .od-card-hd h6 {
        margin:      0;
        font-size:   0.85rem;
        font-weight: 700;
        color:       var(--od-text-heading);
        display:     flex;
        align-items: center;
        gap:         7px;
    }

    .od-hd-icon {
        width:           28px;
        height:          28px;
        border-radius:   7px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        font-size:       0.72rem;
        flex-shrink:     0;
    }

    .od-card-body { padding: 16px 18px; }

    /* info label */
    .od-info-label {
        font-size:      0.66rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.9px;
        color:          var(--od-text-muted);
        margin-bottom:  6px;
        display:        block;
    }

    .od-info-val {
        font-size:   0.92rem;
        font-weight: 700;
        color:       var(--od-text-heading);
        display:     block;
        margin-bottom: 3px;
    }

    .od-info-sub {
        font-size: 0.78rem;
        color:     var(--od-text-muted);
        display:   block;
    }

    /* type badge */
    .od-type-badge {
        display:        inline-flex;
        align-items:    center;
        gap:            5px;
        padding:        4px 10px;
        border-radius:  20px;
        font-size:      0.70rem;
        font-weight:    700;
        margin-top:     4px;
        background:     rgba(6,182,212,0.10);
        color:          #0891b2;
        border:         1px solid rgba(6,182,212,0.20);
    }

    /* ============================================
       STATUS & PAYMENT CARDS
    ============================================ */
    .od-form-label {
        display:        block;
        font-size:      0.66rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color:          var(--od-text-muted);
        margin-bottom:  6px;
    }

    .od-select {
        width:               100%;
        background:          var(--od-input-bg);
        border:              1.5px solid var(--od-input-border);
        border-radius:       9px;
        padding:             9px 32px 9px 12px;
        font-size:           0.845rem;
        color:               var(--od-input-text);
        outline:             none;
        transition:          border-color 0.2s, box-shadow 0.2s;
        appearance:          none;
        background-image:    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat:   no-repeat;
        background-position: right 11px center;
        cursor:              pointer;
    }

    .od-select:focus {
        border-color: #3b82f6;
        box-shadow:   0 0 0 3px rgba(59,130,246,0.10);
    }

    .od-select-group {
        display:   flex;
        flex-direction: column;
        gap:       10px;
        margin-bottom: 12px;
    }

    /* action buttons inside cards */
    .od-action-btn {
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        gap:             6px;
        width:           100%;
        padding:         9px 14px;
        border-radius:   9px;
        font-size:       0.838rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        transition:      all 0.22s ease;
        white-space:     nowrap;
    }

    .od-action-btn i    { font-size: 0.78rem; }
    .od-action-btn:hover { transform: translateY(-1px); }

    .od-btn-primary {
        background:  linear-gradient(135deg,#1d4ed8,#3b82f6);
        color:       #fff;
        box-shadow:  0 3px 10px rgba(59,130,246,0.26);
    }

    .od-btn-primary:hover { box-shadow: 0 6px 18px rgba(59,130,246,0.40); color:#fff; }

    .od-btn-success {
        background:  linear-gradient(135deg,#065f46,#10b981);
        color:       #fff;
        box-shadow:  0 3px 10px rgba(16,185,129,0.26);
    }

    .od-btn-success:hover { box-shadow: 0 6px 18px rgba(16,185,129,0.40); color:#fff; }

    .od-btn-info {
        background:  linear-gradient(135deg,#0e7490,#06b6d4);
        color:       #fff;
        box-shadow:  0 3px 10px rgba(6,182,212,0.26);
    }

    .od-btn-info:hover { box-shadow: 0 6px 18px rgba(6,182,212,0.40); color:#fff; }

    /* current status pill */
    .od-cur-status {
        display:        inline-flex;
        align-items:    center;
        gap:            6px;
        padding:        5px 12px;
        border-radius:  20px;
        font-size:      0.71rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom:  10px;
    }

    .od-cur-status::before {
        content:       '';
        width:         6px;
        height:        6px;
        border-radius: 50%;
        background:    currentColor;
        flex-shrink:   0;
    }

    .od-s-pending   { background:rgba(245,158,11,0.10); color:#d97706; border:1px solid rgba(245,158,11,0.22); }
    .od-s-confirmed { background:rgba(59,130,246,0.10); color:#2563eb; border:1px solid rgba(59,130,246,0.22); }
    .od-s-cooking   { background:rgba(249,115,22,0.10); color:#ea580c; border:1px solid rgba(249,115,22,0.22); }
    .od-s-ready     { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }
    .od-s-served    { background:rgba(6,182,212,0.10);  color:#0891b2; border:1px solid rgba(6,182,212,0.22); }
    .od-s-cancelled { background:rgba(148,163,184,0.10);color:#64748b; border:1px solid rgba(148,163,184,0.20); }

    /* payment badge */
    .od-pay-badge {
        display:        inline-flex;
        align-items:    center;
        gap:            5px;
        padding:        4px 10px;
        border-radius:  20px;
        font-size:      0.70rem;
        font-weight:    700;
        margin-bottom:  10px;
    }

    .od-pay-paid   { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }
    .od-pay-unpaid { background:rgba(245,158,11,0.10); color:#d97706; border:1px solid rgba(245,158,11,0.22); }

    /* assigned waiter badge */
    .od-waiter-badge {
        display:       inline-flex;
        align-items:   center;
        gap:           6px;
        background:    rgba(6,182,212,0.08);
        border:        1px solid rgba(6,182,212,0.18);
        color:         #0891b2;
        padding:       4px 10px;
        border-radius: 20px;
        font-size:     0.75rem;
        font-weight:   600;
        margin-bottom: 10px;
    }

    .od-waiter-badge i { font-size: 0.65rem; }

    /* ============================================
       ORDER ITEMS TABLE
    ============================================ */
    .od-table-card {
        background:    var(--od-card-bg);
        border:        1px solid var(--od-card-border);
        border-radius: 14px;
        box-shadow:    var(--od-card-shadow);
        overflow:      hidden;
        margin-bottom: 20px;
        animation:     od-up 0.45s 0.15s ease both;
    }

    .od-table {
        width:           100%;
        margin:          0;
        border-collapse: collapse;
    }

    .od-table thead th {
        background:     var(--od-table-head);
        color:          var(--od-text-muted);
        font-size:      0.67rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.9px;
        padding:        11px 18px;
        border-bottom:  2px solid var(--od-card-border);
        border-top:     none;
        white-space:    nowrap;
    }

    .od-table tbody tr {
        border-bottom: 1px solid var(--od-table-border);
        transition:    background 0.18s;
        animation:     od-row 0.36s ease both;
    }

    .od-table tbody tr:last-child { border-bottom: none; }
    .od-table tbody tr:hover      { background: var(--od-table-hover); }

    .od-table tbody td {
        padding:        12px 18px;
        vertical-align: middle;
        font-size:      0.862rem;
        color:          var(--od-text-body);
        border:         none;
    }

    .od-table tfoot tr {
        background: var(--od-table-head);
        border-top: 2px solid var(--od-card-border);
    }

    .od-table tfoot td,
    .od-table tfoot th {
        padding: 13px 18px;
        border:  none;
    }

    @keyframes od-row {
        from { opacity:0; transform:translateX(-6px); }
        to   { opacity:1; transform:translateX(0); }
    }

    .od-table tbody tr:nth-child(1) { animation-delay:.04s; }
    .od-table tbody tr:nth-child(2) { animation-delay:.08s; }
    .od-table tbody tr:nth-child(3) { animation-delay:.12s; }
    .od-table tbody tr:nth-child(4) { animation-delay:.16s; }
    .od-table tbody tr:nth-child(5) { animation-delay:.20s; }

    /* item name */
    .od-item-name {
        font-weight: 600;
        color:       var(--od-text-heading);
        display:     block;
        font-size:   0.875rem;
    }

    .od-item-note {
        font-size:  0.74rem;
        color:      var(--od-text-muted);
        margin-top: 2px;
        display:    flex;
        align-items: center;
        gap:        4px;
        font-style: italic;
    }

    .od-item-note i { font-size: 0.62rem; }

    /* qty badge */
    .od-qty {
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        min-width:       30px;
        height:          30px;
        padding:         0 8px;
        background:      var(--od-badge-bg);
        border:          1px solid var(--od-card-border);
        border-radius:   8px;
        font-size:       0.82rem;
        font-weight:     700;
        color:           var(--od-text-heading);
    }

    /* price / subtotal */
    .od-price   { font-weight: 600; color: var(--od-text-heading); }
    .od-subtotal { font-weight: 800; color: #059669; }

    /* total row */
    .od-total-label {
        font-size:   0.82rem;
        font-weight: 700;
        color:       var(--od-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .od-total-val {
        font-size:   1.15rem;
        font-weight: 800;
        color:       #059669;
    }

    /* ============================================
       NOTES CARD
    ============================================ */
    .od-notes-card {
        background:    var(--od-card-bg);
        border:        1px solid var(--od-card-border);
        border-radius: 14px;
        box-shadow:    var(--od-card-shadow);
        overflow:      hidden;
        margin-bottom: 20px;
        animation:     od-up 0.45s 0.20s ease both;
    }

    .od-notes-box {
        background:    rgba(245,158,11,0.06);
        border:        1px solid rgba(245,158,11,0.18);
        border-left:   4px solid #f59e0b;
        border-radius: 10px;
        padding:       13px 16px;
        font-size:     0.875rem;
        color:         var(--od-text-body);
        line-height:   1.6;
        margin:        0;
    }

    /* ============================================
       ANIMATION DELAYS (info cards row)
    ============================================ */
    .od-col-1 .od-card { animation-delay:.05s; }
    .od-col-2 .od-card { animation-delay:.08s; }
    .od-col-3 .od-card { animation-delay:.11s; }
    .od-act-1 .od-card { animation-delay:.14s; }
    .od-act-2 .od-card { animation-delay:.17s; }
    .od-act-3 .od-card { animation-delay:.20s; }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 767px) {
        .od-header        { flex-direction: column; align-items: flex-start; }
        .od-header-actions { width: 100%; }
        .od-hdr-btn       { flex: 1; justify-content: center; }
        .od-table th:nth-child(3),
        .od-table td:nth-child(3) { display: none; }
    }
</style>

<!-- ========================================================
     PAGE HEADER
======================================================== -->
<div class="od-header">
    <div class="od-header-left">
        <div>
            <h5 class="od-page-title">
                <div class="od-title-icon">
                    <i class="ti ti-receipt"></i>
                </div>
                Order #{{ $order->id }}
            </h5>
            <div class="od-breadcrumb">
                <i class="ti ti-home" style="font-size:0.65rem;"></i>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <i class="ti ti-chevron-right sep"></i>
                <a href="{{ route('admin.orders.index') }}">Orders</a>
                <i class="ti ti-chevron-right sep"></i>
                <span class="cur">#{{ $order->id }}</span>
            </div>
        </div>
    </div>

    <div class="od-header-actions">
        <a href="{{ route('admin.orders.index') }}" class="od-hdr-btn od-btn-back">
            <i class="ti ti-arrow-left"></i> Back
        </a>
        <a href="{{ route('admin.orders.invoice', $order) }}"
           target="_blank"
           class="od-hdr-btn od-btn-invoice">
            <i class="ti ti-receipt"></i> View Invoice
        </a>
    </div>
</div>

<!-- ========================================================
     INFO CARDS ROW
======================================================== -->
<div class="row g-3 mb-3">

    <!-- Customer -->
    <div class="col-md-4 od-col-1">
        <div class="od-card">
            <div class="od-card-hd">
                <div class="od-hd-icon"
                     style="background:rgba(59,130,246,0.10);color:#3b82f6;">
                    <i class="ti ti-user"></i>
                </div>
                <h6>Customer</h6>
            </div>
            <div class="od-card-body">
                <span class="od-info-val">
                    {{ $order->user->name ?? 'Guest' }}
                </span>
                <span class="od-info-sub">
                    {{ $order->user->email ?? '—' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Table & Type -->
    <div class="col-md-4 od-col-2">
        <div class="od-card">
            <div class="od-card-hd">
                <div class="od-hd-icon"
                     style="background:rgba(139,92,246,0.10);color:#8b5cf6;">
                    <i class="ti ti-armchair"></i>
                </div>
                <h6>Table & Type</h6>
            </div>
            <div class="od-card-body">
                <span class="od-info-val">
                    @if($order->table)
                        <i class="ti ti-armchair"
                           style="color:#8b5cf6; font-size:0.80rem;"></i>
                        Table #{{ $order->table->table_number }}
                    @else
                        <i class="ti ti-shopping-bag"
                           style="color:#f59e0b; font-size:0.80rem;"></i>
                        No Table
                    @endif
                </span>
                <span class="od-type-badge">
                    {{ ucfirst(str_replace('_',' ', $order->order_type ?? 'dine_in')) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Date & Time -->
    <div class="col-md-4 od-col-3">
        <div class="od-card">
            <div class="od-card-hd">
                <div class="od-hd-icon"
                     style="background:rgba(16,185,129,0.10);color:#10b981;">
                    <i class="ti ti-calendar"></i>
                </div>
                <h6>Date & Time</h6>
            </div>
            <div class="od-card-body">
                <span class="od-info-val">
                    {{ $order->created_at->format('d M Y') }}
                </span>
                <span class="od-info-sub">
                    <i class="ti ti-clock"
                       style="font-size:0.70rem; margin-right:3px;"></i>
                    {{ $order->created_at->format('h:i A') }}
                </span>
            </div>
        </div>
    </div>

</div>

<!-- ========================================================
     ACTION CARDS ROW
======================================================== -->
<div class="row g-3 mb-4">

    <!-- Update Status -->
    <div class="col-md-4 od-act-1">
        <div class="od-card">
            <div class="od-card-hd">
                <div class="od-hd-icon"
                     style="background:rgba(245,158,11,0.10);color:#f59e0b;">
                    <i class="ti ti-refresh"></i>
                </div>
                <h6>Order Status</h6>
            </div>
            <div class="od-card-body">
                <!-- current status -->
                @php
                    $sMap = [
                        'pending'   => 'od-s-pending',
                        'confirmed' => 'od-s-confirmed',
                        'cooking'   => 'od-s-cooking',
                        'ready'     => 'od-s-ready',
                        'served'    => 'od-s-served',
                        'cancelled' => 'od-s-cancelled',
                    ];
                    $sCls = $sMap[$order->status] ?? 'od-s-pending';
                @endphp
                <span class="od-cur-status {{ $sCls }}">
                    {{ ucfirst($order->status) }}
                </span>

                <form method="POST"
                      action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="od-select-group">
                        <div>
                            <label class="od-form-label">Change To</label>
                            <select name="status" class="od-select">
                                @foreach(['pending','confirmed','cooking','ready','served','cancelled'] as $s)
                                <option value="{{ $s }}"
                                    {{ $order->status === $s ? 'selected':'' }}>
                                    {{ ucfirst($s) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="od-action-btn od-btn-primary">
                        <i class="ti ti-refresh"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Payment -->
    <div class="col-md-4 od-act-2">
        <div class="od-card">
            <div class="od-card-hd">
                <div class="od-hd-icon"
                     style="background:rgba(16,185,129,0.10);color:#10b981;">
                    <i class="ti ti-cash"></i>
                </div>
                <h6>Payment</h6>
            </div>
            <div class="od-card-body">
                <!-- current payment -->
                <span class="od-pay-badge
                    {{ $order->payment_status === 'paid'
                        ? 'od-pay-paid' : 'od-pay-unpaid' }}">
                    <i class="ti {{ $order->payment_status === 'paid'
                        ? 'ti-circle-check' : 'ti-clock' }}"
                       style="font-size:0.60rem;"></i>
                    {{ ucfirst($order->payment_status) }}
                    — {{ ucfirst($order->payment_method) }}
                </span>

                <form method="POST"
                      action="{{ route('admin.orders.payment', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="od-select-group">
                        <div>
                            <label class="od-form-label">Payment Status</label>
                            <select name="payment_status" class="od-select">
                                <option value="unpaid"
                                    {{ $order->payment_status === 'unpaid' ? 'selected':'' }}>
                                    Unpaid
                                </option>
                                <option value="paid"
                                    {{ $order->payment_status === 'paid' ? 'selected':'' }}>
                                    Paid
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="od-form-label">Payment Method</label>
                            <select name="payment_method" class="od-select">
                                @foreach(['cash','card','online'] as $m)
                                <option value="{{ $m }}"
                                    {{ $order->payment_method === $m ? 'selected':'' }}>
                                    {{ ucfirst($m) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="od-action-btn od-btn-success">
                        <i class="ti ti-check"></i> Update Payment
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Assign Waiter -->
    <div class="col-md-4 od-act-3">
        <div class="od-card">
            <div class="od-card-hd">
                <div class="od-hd-icon"
                     style="background:rgba(6,182,212,0.10);color:#06b6d4;">
                    <i class="ti ti-user-check"></i>
                </div>
                <h6>Assign Waiter</h6>
            </div>
            <div class="od-card-body">
                <!-- currently assigned -->
                @if($order->waiter_id)
                    @php $waiter = \App\Models\User::find($order->waiter_id); @endphp
                    @if($waiter)
                    <span class="od-waiter-badge">
                        <i class="ti ti-user-check"></i>
                        {{ $waiter->name }}
                    </span>
                    @endif
                @else
                    <span class="od-waiter-badge"
                          style="background:rgba(148,163,184,0.08);
                                 color:#64748b;
                                 border-color:rgba(148,163,184,0.18);">
                        <i class="ti ti-user-x"></i>
                        Not Assigned
                    </span>
                @endif

                <form method="POST"
                      action="{{ route('admin.orders.waiter', $order) }}">
                    @csrf
                    @method('PATCH')
                    @php
                        $staff = \App\Models\User::whereIn('role',['staff','admin'])->get();
                    @endphp
                    <div class="od-select-group">
                        <div>
                            <label class="od-form-label">Select Waiter</label>
                            <select name="waiter_id" class="od-select">
                                <option value="">— No Waiter —</option>
                                @foreach($staff as $st)
                                <option value="{{ $st->id }}"
                                    {{ $order->waiter_id == $st->id ? 'selected':'' }}>
                                    {{ $st->name }}
                                    ({{ ucfirst($st->role) }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="od-action-btn od-btn-info">
                        <i class="ti ti-user-check"></i> Assign Waiter
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- ========================================================
     ORDER ITEMS TABLE
======================================================== -->
<div class="od-table-card">
    <div class="od-card-hd">
        <div class="od-hd-icon"
             style="background:rgba(59,130,246,0.10);color:#3b82f6;">
            <i class="ti ti-list-details"></i>
        </div>
        <h6>
            Order Items
            <span style="background:var(--od-badge-bg);
                         border:1px solid var(--od-card-border);
                         color:var(--od-text-muted);
                         padding:1px 8px;
                         border-radius:20px;
                         font-size:0.68rem;
                         font-weight:600;
                         margin-left:6px;">
                {{ $order->orderItems->count() }} items
            </span>
        </h6>
    </div>
    <div class="table-responsive">
        <table class="od-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align:center; width:70px;">Qty</th>
                    <th style="text-align:right;">Unit Price</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->orderItems as $item)
                <tr>
                    <td>
                        <span class="od-item-name">
                            {{ $item->menuItem->name ?? 'Item' }}
                        </span>
                        @if($item->special_instructions)
                        <span class="od-item-note">
                            <i class="ti ti-note"></i>
                            {{ $item->special_instructions }}
                        </span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <span class="od-qty">
                            ×{{ $item->quantity }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <span class="od-price">
                            Rs.&nbsp;{{ number_format($item->unit_price ?? $item->price, 0) }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <span class="od-subtotal">
                            Rs.&nbsp;{{ number_format(
                                $item->subtotal ??
                                ($item->quantity * ($item->unit_price ?? $item->price)),
                            0) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4"
                        style="text-align:center;
                               padding:40px 20px;
                               color:var(--od-text-muted);
                               font-size:0.855rem;">
                        <i class="ti ti-shopping-cart-off"
                           style="font-size:1.8rem;
                                  display:block;
                                  margin-bottom:8px;
                                  opacity:0.35;"></i>
                        No items found
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align:right;">
                        <span class="od-total-label">Total Amount</span>
                    </td>
                    <td style="text-align:right;">
                        <span class="od-total-val">
                            Rs.&nbsp;{{ number_format($order->total_amount, 0) }}
                        </span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- ========================================================
     NOTES CARD
======================================================== -->
@if($order->notes)
<div class="od-notes-card">
    <div class="od-card-hd">
        <div class="od-hd-icon"
             style="background:rgba(245,158,11,0.10);color:#f59e0b;">
            <i class="ti ti-note"></i>
        </div>
        <h6>Order Notes</h6>
    </div>
    <div style="padding:16px 18px;">
        <div class="od-notes-box">
            {{ $order->notes }}
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dark =
        document.body.classList.contains('dark') ||
        document.body.classList.contains('dark-mode') ||
        document.documentElement.getAttribute('data-theme')    === 'dark' ||
        document.documentElement.getAttribute('data-bs-theme') === 'dark';
    if (dark) document.documentElement.setAttribute('data-theme','dark');
});
</script>

@endsection