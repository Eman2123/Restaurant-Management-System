@extends('layouts.admin')
@section('title', 'Order #' . $order->id)
@section('page-title', 'Order Details')

@push('styles')
<style>
@media print {
    .no-print,
    #miniSidebar,
    .navbar-glass,
    .sidebar { display: none !important; }
    .card    { box-shadow: none !important; border: 1px solid #ddd !important; }
    body     { font-size: 12px; }
}
</style>
@endpush

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
        --od-badge-bg:     #f1f5f9;
        --od-divider:      #f1f5f9;
        --od-row-muted:    #f8fafc;
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
        --od-badge-bg:     #1e2a3a;
        --od-divider:      #1e2a3a;
        --od-row-muted:    #141A21;
    }

    /* ============================================
       PAGE HEADER
    ============================================ */
    .od-page-header {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        margin-bottom:   22px;
        flex-wrap:       wrap;
        gap:             12px;
    }

    .od-page-left { display: flex; align-items: center; gap: 12px; }

    .od-back-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             7px;
        padding:         9px 16px;
        background:      var(--od-card-bg);
        border:          1.5px solid var(--od-card-border);
        border-radius:   10px;
        font-size:       0.84rem;
        font-weight:     600;
        color:           var(--od-text-body);
        text-decoration: none;
        transition:      all 0.22s ease;
        box-shadow:      var(--od-card-shadow);
    }

    .od-back-btn i { font-size: 0.80rem; transition: transform 0.22s; }

    .od-back-btn:hover {
        border-color:    #3b82f6;
        color:           #3b82f6;
        text-decoration: none;
        transform:       translateY(-1px);
    }

    .od-back-btn:hover i { transform: translateX(-3px); }

    .od-page-title {
        font-size:   1rem;
        font-weight: 700;
        color:       var(--od-text-heading);
        margin:      0;
        display:     flex;
        align-items: center;
        gap:         8px;
    }

    .od-page-title-icon {
        width:           34px;
        height:          34px;
        background:      linear-gradient(135deg,#1d4ed8,#3b82f6);
        border-radius:   9px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        color:           #fff;
        font-size:       0.82rem;
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
    .od-breadcrumb .sep    { font-size: 0.55rem; opacity: 0.4; }
    .od-breadcrumb .cur    { color: var(--od-text-heading); font-weight: 600; }

    /* print button */
    .od-print-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             7px;
        padding:         9px 16px;
        background:      var(--od-card-bg);
        border:          1.5px solid var(--od-card-border);
        border-radius:   10px;
        font-size:       0.84rem;
        font-weight:     600;
        color:           var(--od-text-body);
        cursor:          pointer;
        transition:      all 0.22s ease;
        box-shadow:      var(--od-card-shadow);
    }

    .od-print-btn i { font-size: 0.78rem; }

    .od-print-btn:hover {
        border-color: #64748b;
        color:        var(--od-text-heading);
        transform:    translateY(-1px);
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
        margin-bottom: 20px;
        animation:     od-up 0.42s ease both;
    }

    @keyframes od-up {
        from { opacity:0; transform:translateY(14px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .od-card-hd {
        padding:         15px 20px;
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        border-bottom:   1px solid var(--od-card-border);
        background:      var(--od-row-muted);
        flex-wrap:       wrap;
        gap:             8px;
    }

    .od-card-hd-title {
        font-size:   0.88rem;
        font-weight: 700;
        color:       var(--od-text-heading);
        display:     flex;
        align-items: center;
        gap:         8px;
        margin:      0;
    }

    .od-hd-icon {
        width:           30px;
        height:          30px;
        border-radius:   8px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        font-size:       0.75rem;
        flex-shrink:     0;
    }

    /* ============================================
       ORDER STATUS BADGE
    ============================================ */
    .od-status-badge {
        display:        inline-flex;
        align-items:    center;
        gap:            6px;
        padding:        5px 13px;
        border-radius:  20px;
        font-size:      0.74rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .od-status-badge::before {
        content:       '';
        width:         7px;
        height:        7px;
        border-radius: 50%;
        background:    currentColor;
        flex-shrink:   0;
    }

    .od-badge-pending    { background:rgba(245,158,11,0.10); color:#d97706; border:1px solid rgba(245,158,11,0.22); }
    .od-badge-cooking    { background:rgba(249,115,22,0.10); color:#ea580c; border:1px solid rgba(249,115,22,0.22); }
    .od-badge-ready      { background:rgba(59,130,246,0.10); color:#2563eb; border:1px solid rgba(59,130,246,0.22); }
    .od-badge-served     { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }
    .od-badge-cancelled  { background:rgba(239,68,68,0.10);  color:#dc2626; border:1px solid rgba(239,68,68,0.22); }
    .od-badge-completed  { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }

    /* payment */
    .od-pay-badge {
        display:       inline-flex;
        align-items:   center;
        gap:           5px;
        padding:       4px 10px;
        border-radius: 20px;
        font-size:     0.72rem;
        font-weight:   700;
    }

    .od-pay-paid   { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }
    .od-pay-unpaid { background:rgba(245,158,11,0.10); color:#d97706; border:1px solid rgba(245,158,11,0.22); }

    /* ============================================
       ITEMS TABLE
    ============================================ */
    .od-table {
        width:  100%;
        margin: 0;
        border-collapse: collapse;
    }

    .od-table thead th {
        background:     var(--od-table-head);
        color:          var(--od-text-muted);
        font-size:      0.68rem;
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
        transition:    background 0.18s ease;
    }

    .od-table tbody tr:last-child { border-bottom: none; }
    .od-table tbody tr:hover      { background: var(--od-table-hover); }

    .od-table tbody td {
        padding:        13px 18px;
        vertical-align: middle;
        font-size:      0.865rem;
        color:          var(--od-text-body);
        border:         none;
    }

    /* tfoot */
    .od-table tfoot tr {
        background:    var(--od-table-head);
        border-top:    2px solid var(--od-card-border);
    }

    .od-table tfoot td,
    .od-table tfoot th {
        padding:     13px 18px;
        font-size:   0.865rem;
        border:      none;
        color:       var(--od-text-heading);
    }

    /* item name */
    .od-item-name {
        font-weight: 600;
        font-size:   0.875rem;
        color:       var(--od-text-heading);
        display:     block;
    }

    .od-item-cat {
        font-size:  0.73rem;
        color:      var(--od-text-muted);
        margin-top: 2px;
        display:    flex;
        align-items: center;
        gap:        4px;
    }

    .od-item-cat i { font-size: 0.62rem; }

    /* price */
    .od-price {
        font-weight: 600;
        color:       var(--od-text-heading);
    }

    /* qty badge */
    .od-qty {
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        min-width:       28px;
        height:          28px;
        padding:         0 8px;
        background:      var(--od-badge-bg);
        border:          1px solid var(--od-card-border);
        border-radius:   7px;
        font-size:       0.80rem;
        font-weight:     700;
        color:           var(--od-text-heading);
    }

    /* subtotal */
    .od-subtotal {
        font-weight: 700;
        color:       #059669;
        font-size:   0.895rem;
    }

    /* notes */
    .od-notes-cell {
        font-size: 0.78rem;
        color:     var(--od-text-muted);
        font-style: italic;
    }

    /* total row */
    .od-total-label {
        font-size:   0.82rem;
        font-weight: 700;
        color:       var(--od-text-heading);
        text-align:  right;
    }

    .od-total-val {
        font-size:   1.15rem;
        font-weight: 800;
        color:       #059669;
    }

    /* ============================================
       INFO TABLE (right side)
    ============================================ */
    .od-info-table {
        width:  100%;
        margin: 0;
    }

    .od-info-table tr {
        border-bottom: 1px solid var(--od-table-border);
    }

    .od-info-table tr:last-child { border-bottom: none; }

    .od-info-table td {
        padding:        10px 18px;
        font-size:      0.845rem;
        vertical-align: middle;
        border:         none;
    }

    .od-info-key {
        color:       var(--od-text-muted);
        font-weight: 600;
        font-size:   0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width:       40%;
        white-space: nowrap;
    }

    .od-info-val {
        color:       var(--od-text-heading);
        font-weight: 500;
    }

    .od-info-icon {
        width:           24px;
        height:          24px;
        border-radius:   6px;
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        font-size:       0.62rem;
        flex-shrink:     0;
        margin-right:    6px;
    }

    /* ============================================
       FORM ELEMENTS
    ============================================ */
    .od-form-label {
        display:        block;
        font-size:      0.72rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color:          var(--od-text-muted);
        margin-bottom:  7px;
    }

    .od-select {
        width:         100%;
        background:    var(--od-input-bg);
        border:        1.5px solid var(--od-input-border);
        border-radius: 9px;
        padding:       10px 13px;
        font-size:     0.875rem;
        color:         var(--od-text-heading);
        outline:       none;
        transition:    border-color 0.2s, box-shadow 0.2s;
        appearance:    none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat:   no-repeat;
        background-position: right 12px center;
        padding-right:  36px;
        cursor:         pointer;
    }

    .od-select:focus {
        border-color: #3b82f6;
        box-shadow:   0 0 0 3px rgba(59,130,246,0.10);
    }

    /* ============================================
       ACTION BUTTONS
    ============================================ */
    .od-btn {
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        gap:             7px;
        width:           100%;
        padding:         11px 16px;
        border-radius:   10px;
        font-size:       0.855rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        text-decoration: none;
        transition:      all 0.25s ease;
        white-space:     nowrap;
    }

    .od-btn i { font-size: 0.80rem; }

    .od-btn:hover {
        transform:       translateY(-2px);
        text-decoration: none;
    }

    .od-btn:active { transform: translateY(0); }

    /* update status — amber */
    .od-btn-status {
        background:  linear-gradient(135deg,#b45309,#f59e0b);
        color:       #fff;
        border-color: transparent;
        box-shadow:  0 3px 12px rgba(245,158,11,0.30);
    }

    .od-btn-status:hover {
        box-shadow: 0 6px 20px rgba(245,158,11,0.44);
        color:      #fff;
    }

    /* update payment — green */
    .od-btn-payment {
        background:  linear-gradient(135deg,#065f46,#10b981);
        color:       #fff;
        border-color: transparent;
        box-shadow:  0 3px 12px rgba(16,185,129,0.28);
    }

    .od-btn-payment:hover {
        box-shadow: 0 6px 20px rgba(16,185,129,0.42);
        color:      #fff;
    }

    /* delete — red outline → solid */
    .od-btn-delete {
        background:   rgba(239,68,68,0.06);
        color:        #dc2626;
        border-color: rgba(239,68,68,0.25);
    }

    .od-btn-delete:hover {
        background:   #ef4444;
        color:        #fff;
        border-color: #ef4444;
        box-shadow:   0 6px 20px rgba(239,68,68,0.38);
    }

    /* ============================================
       NOTES CARD
    ============================================ */
    .od-notes-box {
        background:    rgba(245,158,11,0.06);
        border:        1px solid rgba(245,158,11,0.18);
        border-left:   4px solid #f59e0b;
        border-radius: 10px;
        padding:       14px 16px;
    }

    .od-notes-box p {
        margin:    0;
        font-size: 0.875rem;
        color:     var(--od-text-body);
        line-height: 1.6;
    }

    /* ============================================
       DANGER ZONE CARD
    ============================================ */
    .od-danger-card {
        background:    var(--od-card-bg);
        border:        1px solid rgba(239,68,68,0.22) !important;
        border-radius: 14px;
        box-shadow:    var(--od-card-shadow);
        overflow:      hidden;
        margin-bottom: 20px;
        animation:     od-up 0.42s ease both;
    }

    .od-danger-hd {
        padding:       14px 20px;
        border-bottom: 1px solid rgba(239,68,68,0.14);
        background:    rgba(239,68,68,0.04);
        display:       flex;
        align-items:   center;
        gap:           8px;
    }

    .od-danger-hd h6 {
        margin:      0;
        font-size:   0.88rem;
        font-weight: 700;
        color:       #dc2626;
    }

    .od-danger-body { padding: 16px 20px; }

    .od-danger-body p {
        font-size:   0.80rem;
        color:       var(--od-text-muted);
        margin:      0 0 12px;
        line-height: 1.55;
    }

    /* ============================================
       PRINT STYLES
    ============================================ */
    .od-print-header,
    .od-print-footer { display: none; }

    @media print {
        .od-print-header,
        .od-print-footer { display: block; text-align: center; }
        .od-print-header  { margin-bottom: 20px; }
        .od-print-footer  { margin-top: 20px; }
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 767px) {
        .od-page-header   { flex-direction: column; align-items: flex-start; }
        .od-table th:nth-child(5),
        .od-table td:nth-child(5) { display: none; }
    }
</style>

<!-- ========================================================
     PRINT HEADER
======================================================== -->
<div class="od-print-header">
    <h3 style="font-weight:800; margin:0;">The Restaurant</h3>
    <p style="margin:4px 0 0; font-size:0.85rem;">123 Main Street, Karachi &nbsp;|&nbsp; +92 300 1234567</p>
    <hr style="margin:12px 0;">
    <h5 style="font-weight:700; margin:0;">ORDER RECEIPT — #{{ $order->id }}</h5>
</div>

<!-- ========================================================
     PAGE HEADER
======================================================== -->
<div class="od-page-header no-print">
    <div class="od-page-left">
        <a href="{{ route('admin.orders.index') }}" class="od-back-btn">
            <i class="ti ti-arrow-left"></i> Back
        </a>
        <div>
            <h5 class="od-page-title">
                <div class="od-page-title-icon">
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
    <button onclick="window.print()" class="od-print-btn">
        <i class="ti ti-printer"></i> Print Receipt
    </button>
</div>

<!-- ========================================================
     MAIN ROW
======================================================== -->
<div class="row g-4">

    <!-- ===================== LEFT — ITEMS ===================== -->
    <div class="col-lg-8">

        <!-- Order Items Card -->
        <div class="od-card" style="animation-delay:.05s;">
            <div class="od-card-hd">
                <h6 class="od-card-hd-title">
                    <div class="od-hd-icon"
                         style="background:rgba(59,130,246,0.10);color:#3b82f6;">
                        <i class="ti ti-shopping-cart"></i>
                    </div>
                    Order #{{ $order->id }} — Items
                </h6>

                <!-- Status Badge -->
                @php
                    $badgeMap = [
                        'pending'   => 'od-badge-pending',
                        'cooking'   => 'od-badge-cooking',
                        'ready'     => 'od-badge-ready',
                        'served'    => 'od-badge-served',
                        'cancelled' => 'od-badge-cancelled',
                        'completed' => 'od-badge-completed',
                    ];
                    $badgeCls = $badgeMap[$order->status] ?? 'od-badge-pending';
                @endphp
                <span class="od-status-badge {{ $badgeCls }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="od-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th class="no-print">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <span class="od-item-name">
                                    {{ $item->menuItem->name }}
                                </span>
                                <span class="od-item-cat">
                                    <i class="ti ti-tag"></i>
                                    {{ $item->menuItem->category->name }}
                                </span>
                            </td>
                            <td>
                                <span class="od-price">
                                    Rs.&nbsp;{{ number_format($item->unit_price, 0) }}
                                </span>
                            </td>
                            <td>
                                <span class="od-qty">×{{ $item->quantity }}</span>
                            </td>
                            <td>
                                <span class="od-subtotal">
                                    Rs.&nbsp;{{ number_format($item->subtotal, 0) }}
                                </span>
                            </td>
                            <td class="no-print">
                                <span class="od-notes-cell">
                                    {{ $item->special_instructions ?? '—' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td class="od-total-label" colspan="1">
                                Total:
                            </td>
                            <td>
                                <span class="od-total-val">
                                    Rs.&nbsp;{{ number_format($order->total_amount, 0) }}
                                </span>
                            </td>
                            <td class="no-print"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Notes Card -->
        @if($order->notes)
        <div class="od-card" style="animation-delay:.10s;">
            <div class="od-card-hd">
                <h6 class="od-card-hd-title">
                    <div class="od-hd-icon"
                         style="background:rgba(245,158,11,0.10);color:#f59e0b;">
                        <i class="ti ti-note"></i>
                    </div>
                    Order Notes
                </h6>
            </div>
            <div style="padding:18px 20px;">
                <div class="od-notes-box">
                    <p>{{ $order->notes }}</p>
                </div>
            </div>
        </div>
        @endif

    </div>
    <!-- end left col -->

    <!-- ===================== RIGHT — INFO + ACTIONS ===================== -->
    <div class="col-lg-4 no-print">

        <!-- Order Info -->
        <div class="od-card" style="animation-delay:.08s;">
            <div class="od-card-hd">
                <h6 class="od-card-hd-title">
                    <div class="od-hd-icon"
                         style="background:rgba(6,182,212,0.10);color:#06b6d4;">
                        <i class="ti ti-info-circle"></i>
                    </div>
                    Order Info
                </h6>
            </div>
            <table class="od-info-table">
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(59,130,246,0.08);color:#3b82f6;">
                            <i class="ti ti-user"></i>
                        </span>
                        Customer
                    </td>
                    <td class="od-info-val" style="font-weight:700;">
                        {{ $order->user->name ?? 'Guest' }}
                    </td>
                </tr>
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(139,92,246,0.08);color:#8b5cf6;">
                            <i class="ti ti-armchair"></i>
                        </span>
                        Table
                    </td>
                    <td class="od-info-val">
                        @if($order->table)
                            <span style="background:rgba(59,130,246,0.08);
                                         color:#3b82f6;
                                         border:1px solid rgba(59,130,246,0.18);
                                         padding:3px 9px;
                                         border-radius:7px;
                                         font-size:0.80rem;
                                         font-weight:600;">
                                <i class="ti ti-armchair" style="font-size:0.65rem;"></i>
                                Table #{{ $order->table->table_number }}
                            </span>
                        @else
                            <span style="background:rgba(245,158,11,0.08);
                                         color:#d97706;
                                         border:1px solid rgba(245,158,11,0.18);
                                         padding:3px 9px;
                                         border-radius:7px;
                                         font-size:0.80rem;
                                         font-weight:600;">
                                <i class="ti ti-shopping-bag" style="font-size:0.65rem;"></i>
                                Takeaway
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(16,185,129,0.08);color:#10b981;">
                            <i class="ti ti-category"></i>
                        </span>
                        Type
                    </td>
                    <td class="od-info-val">
                        {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
                    </td>
                </tr>
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(245,158,11,0.08);color:#f59e0b;">
                            <i class="ti ti-credit-card"></i>
                        </span>
                        Payment
                    </td>
                    <td class="od-info-val">
                        <span class="od-pay-badge
                            {{ $order->payment_status === 'paid'
                                ? 'od-pay-paid' : 'od-pay-unpaid' }}">
                            <i class="ti ti-circle-filled"
                               style="font-size:0.5rem;"></i>
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(6,182,212,0.08);color:#06b6d4;">
                            <i class="ti ti-cash"></i>
                        </span>
                        Method
                    </td>
                    <td class="od-info-val">
                        {{ ucfirst($order->payment_method) }}
                    </td>
                </tr>
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(139,92,246,0.08);color:#8b5cf6;">
                            <i class="ti ti-list"></i>
                        </span>
                        Items
                    </td>
                    <td class="od-info-val">
                        {{ $order->orderItems->count() }}
                        {{ Str::plural('item', $order->orderItems->count()) }}
                    </td>
                </tr>
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(16,185,129,0.08);color:#10b981;">
                            <i class="ti ti-currency-rupee"></i>
                        </span>
                        Total
                    </td>
                    <td class="od-info-val"
                        style="font-weight:800; color:#059669; font-size:0.95rem;">
                        Rs.&nbsp;{{ number_format($order->total_amount, 0) }}
                    </td>
                </tr>
                <tr>
                    <td class="od-info-key">
                        <span class="od-info-icon"
                              style="background:rgba(148,163,184,0.08);color:#94a3b8;">
                            <i class="ti ti-clock"></i>
                        </span>
                        Date
                    </td>
                    <td class="od-info-val"
                        style="font-size:0.80rem;">
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Update Status -->
        <div class="od-card" style="animation-delay:.12s;">
            <div class="od-card-hd">
                <h6 class="od-card-hd-title">
                    <div class="od-hd-icon"
                         style="background:rgba(245,158,11,0.10);color:#f59e0b;">
                        <i class="ti ti-refresh"></i>
                    </div>
                    Update Order Status
                </h6>
            </div>
            <div style="padding:18px 20px;">
                <form method="POST"
                      action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div style="margin-bottom:14px;">
                        <label class="od-form-label">
                            Current Status
                        </label>
                        <select name="status" class="od-select">
                            @foreach(['pending','cooking','ready','served','cancelled'] as $s)
                            <option value="{{ $s }}"
                                {{ $order->status === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="od-btn od-btn-status">
                        <i class="ti ti-refresh"></i>
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Payment -->
        <div class="od-card" style="animation-delay:.16s;">
            <div class="od-card-hd">
                <h6 class="od-card-hd-title">
                    <div class="od-hd-icon"
                         style="background:rgba(16,185,129,0.10);color:#10b981;">
                        <i class="ti ti-cash"></i>
                    </div>
                    Update Payment
                </h6>
            </div>
            <div style="padding:18px 20px;">
                <form method="POST"
                      action="{{ route('admin.orders.payment', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div style="margin-bottom:14px;">
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
                    <div style="margin-bottom:16px;">
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
                    <button type="submit" class="od-btn od-btn-payment">
                        <i class="ti ti-check"></i>
                        Update Payment
                    </button>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="od-danger-card" style="animation-delay:.20s;">
            <div class="od-danger-hd">
                <div class="od-hd-icon"
                     style="background:rgba(239,68,68,0.10);color:#dc2626;">
                    <i class="ti ti-alert-triangle"></i>
                </div>
                <h6>Danger Zone</h6>
            </div>
            <div class="od-danger-body">
                <p>
                    Permanently deletes Order #{{ $order->id }} and all
                    associated items. This action cannot be undone.
                </p>
                <form method="POST"
                      action="{{ route('admin.orders.destroy', $order) }}"
                      id="deleteOrderForm">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="od-btn od-btn-delete"
                            onclick="confirmDelete()">
                        <i class="ti ti-trash"></i>
                        Delete Order #{{ $order->id }}
                    </button>
                </form>
            </div>
        </div>

    </div>
    <!-- end right col -->

</div>

<!-- ========================================================
     PRINT FOOTER
======================================================== -->
<div class="od-print-footer">
    <hr style="margin:14px 0;">
    <p style="margin:0 0 4px; font-size:0.85rem;">
        <strong>Payment:</strong>
        {{ ucfirst($order->payment_status) }} — {{ ucfirst($order->payment_method) }}
    </p>
    <p style="margin:0 0 4px; font-size:0.85rem;">
        <strong>Date:</strong>
        {{ $order->created_at->format('d M Y, h:i A') }}
    </p>
    <p style="margin:14px 0 0; font-size:0.80rem; color:#666;">
        Thank you for dining with us!
    </p>
</div>

<script>
function confirmDelete() {
    if (confirm(
        'Delete Order #{{ $order->id }}?\n\nThis will permanently remove the order and all items. This cannot be undone!'
    )) {
        document.getElementById('deleteOrderForm').submit();
    }
}

/* dark theme detect */
document.addEventListener('DOMContentLoaded', function () {
    const dark =
        document.body.classList.contains('dark') ||
        document.body.classList.contains('dark-mode') ||
        document.documentElement.getAttribute('data-theme')    === 'dark' ||
        document.documentElement.getAttribute('data-bs-theme') === 'dark';
    if (dark) document.documentElement.setAttribute('data-theme', 'dark');
});
</script>

@endsection