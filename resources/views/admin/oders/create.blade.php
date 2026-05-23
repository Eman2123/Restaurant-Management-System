@extends('layouts.admin')
@section('title', 'New Order')
@section('page-title', 'Create New Order')

@push('styles')
<style>
    /* ============================================
       THEME VARIABLES
    ============================================ */
    :root {
        --no-card-bg:      #ffffff;
        --no-card-border:  #e8ecf0;
        --no-card-shadow:  0 2px 16px rgba(0,0,0,0.07);
        --no-text-heading: #1e293b;
        --no-text-body:    #4a5568;
        --no-text-muted:   #94a3b8;
        --no-input-bg:     #f8fafc;
        --no-input-border: #e2e8f0;
        --no-input-text:   #1e293b;
        --no-input-focus:  #ffffff;
        --no-badge-bg:     #f1f5f9;
        --no-divider:      #f1f5f9;
        --no-table-head:   #f7f9fc;
        --no-row-bg:       #f8fafc;
        --no-row-hover:    #f0f7ff;
    }

    [data-theme="dark"],
    body.dark,
    body.dark-mode,
    html[data-bs-theme="dark"] {
        --no-card-bg:      #1c2333;
        --no-card-border:  #2a3447;
        --no-card-shadow:  0 2px 20px rgba(0,0,0,0.35);
        --no-text-heading: #e2e8f0;
        --no-text-body:    #94a3b8;
        --no-text-muted:   #4a5568;
        --no-input-bg:     #141A21;
        --no-input-border: #2a3447;
        --no-input-text:   #e2e8f0;
        --no-input-focus:  #1a2234;
        --no-badge-bg:     #1e2a3a;
        --no-divider:      #1e2a3a;
        --no-table-head:   #141A21;
        --no-row-bg:       #141A21;
        --no-row-hover:    #1e2d40;
    }

    /* ============================================
       PAGE HEADER
    ============================================ */
    .no-page-header {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        margin-bottom:   22px;
        flex-wrap:       wrap;
        gap:             12px;
    }

    .no-page-title {
        font-size:   1.05rem;
        font-weight: 700;
        color:       var(--no-text-heading);
        display:     flex;
        align-items: center;
        gap:         9px;
        margin:      0;
    }

    .no-title-icon {
        width:           36px;
        height:          36px;
        background:      linear-gradient(135deg,#065f46,#10b981);
        border-radius:   10px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        color:           #fff;
        font-size:       0.88rem;
        flex-shrink:     0;
        box-shadow:      0 3px 10px rgba(16,185,129,0.28);
    }

    .no-breadcrumb {
        display:     flex;
        align-items: center;
        gap:         5px;
        font-size:   0.75rem;
        color:       var(--no-text-muted);
        margin-top:  3px;
    }

    .no-breadcrumb a {
        color:           var(--no-text-muted);
        text-decoration: none;
        transition:      color 0.2s;
    }

    .no-breadcrumb a:hover { color: #10b981; }
    .no-breadcrumb .sep    { font-size: 0.52rem; opacity: 0.4; }
    .no-breadcrumb .cur    { color: var(--no-text-heading); font-weight: 600; }

    /* ============================================
       CARDS
    ============================================ */
    .no-card {
        background:    var(--no-card-bg);
        border:        1px solid var(--no-card-border);
        border-radius: 14px;
        box-shadow:    var(--no-card-shadow);
        overflow:      hidden;
        margin-bottom: 20px;
        animation:     no-up 0.42s ease both;
    }

    @keyframes no-up {
        from { opacity:0; transform:translateY(14px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .no-card-hd {
        padding:       16px 22px;
        border-bottom: 1px solid var(--no-card-border);
        background:    var(--no-table-head);
        display:       flex;
        align-items:   center;
        gap:           10px;
    }

    .no-card-hd h6 {
        margin:      0;
        font-size:   0.90rem;
        font-weight: 700;
        color:       var(--no-text-heading);
        display:     flex;
        align-items: center;
        gap:         8px;
    }

    .no-hd-icon {
        width:           30px;
        height:          30px;
        border-radius:   8px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        font-size:       0.75rem;
        flex-shrink:     0;
    }

    .no-card-body { padding: 22px; }

    /* ============================================
       ERROR ALERT
    ============================================ */
    .no-alert {
        background:    rgba(239,68,68,0.07);
        border:        1px solid rgba(239,68,68,0.20);
        border-left:   4px solid #ef4444;
        border-radius: 10px;
        padding:       13px 16px;
        margin-bottom: 22px;
        animation:     no-shake 0.4s ease;
    }

    @keyframes no-shake {
        0%,100% { transform:translateX(0); }
        25%     { transform:translateX(-5px); }
        75%     { transform:translateX(5px); }
    }

    .no-alert-hd {
        display:       flex;
        align-items:   center;
        gap:           7px;
        font-size:     0.80rem;
        font-weight:   700;
        color:         #dc2626;
        margin-bottom: 7px;
    }

    .no-alert ul {
        margin:       0;
        padding-left: 16px;
    }

    .no-alert ul li {
        font-size:   0.80rem;
        color:       #dc2626;
        line-height: 1.7;
    }

    /* ============================================
       SECTION LABEL
    ============================================ */
    .no-section-label {
        font-size:      0.70rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color:          var(--no-text-muted);
        margin-bottom:  14px;
        display:        flex;
        align-items:    center;
        gap:            7px;
        padding-bottom: 10px;
        border-bottom:  1px solid var(--no-divider);
    }

    .no-section-label i { color: #10b981; font-size: 0.82rem; }

    /* ============================================
       FORM ELEMENTS
    ============================================ */
    .no-form-group { margin-bottom: 16px; }

    .no-label {
        display:        block;
        font-size:      0.72rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color:          var(--no-text-muted);
        margin-bottom:  7px;
    }

    .no-label .req { color: #ef4444; margin-left: 2px; }

    .no-input,
    .no-select,
    .no-textarea {
        width:         100%;
        background:    var(--no-input-bg);
        border:        1.5px solid var(--no-input-border);
        border-radius: 9px;
        padding:       10px 13px;
        font-size:     0.875rem;
        color:         var(--no-input-text);
        outline:       none;
        transition:    border-color 0.22s, box-shadow 0.22s, background 0.22s;
        display:       block;
    }

    .no-input::placeholder,
    .no-textarea::placeholder { color: var(--no-text-muted); }

    .no-input:focus,
    .no-select:focus,
    .no-textarea:focus {
        border-color: #10b981;
        background:   var(--no-input-focus);
        box-shadow:   0 0 0 3px rgba(16,185,129,0.12);
    }

    .no-select {
        appearance:          none;
        background-image:    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat:   no-repeat;
        background-position: right 12px center;
        background-size:     12px;
        padding-right:       36px;
        cursor:              pointer;
    }

    /* ============================================
       ORDER ITEMS ROWS
    ============================================ */
    .no-items-container {
        display:        flex;
        flex-direction: column;
        gap:            10px;
        margin-bottom:  16px;
    }

    .no-item-row {
        background:    var(--no-row-bg);
        border:        1.5px solid var(--no-card-border);
        border-radius: 12px;
        padding:       14px 16px;
        display:       grid;
        grid-template-columns: 1fr 100px 1fr 40px;
        gap:           10px;
        align-items:   end;
        transition:    border-color 0.22s, background 0.22s;
        animation:     no-row-in 0.32s ease both;
        position:      relative;
    }

    @keyframes no-row-in {
        from { opacity:0; transform:translateY(8px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .no-item-row:hover {
        border-color: rgba(16,185,129,0.30);
        background:   var(--no-row-hover);
    }

    /* row number badge */
    .no-item-num {
        position:      absolute;
        top:           -9px;
        left:          14px;
        background:    linear-gradient(135deg,#065f46,#10b981);
        color:         #fff;
        font-size:     0.60rem;
        font-weight:   700;
        padding:       1px 7px;
        border-radius: 20px;
    }

    /* remove button */
    .no-remove-btn {
        width:           36px;
        height:          36px;
        border-radius:   9px;
        background:      rgba(239,68,68,0.08);
        border:          1.5px solid rgba(239,68,68,0.20);
        color:           #dc2626;
        display:         flex;
        align-items:     center;
        justify-content: center;
        cursor:          pointer;
        transition:      all 0.22s ease;
        flex-shrink:     0;
        font-size:       0.82rem;
    }

    .no-remove-btn:hover {
        background:   #ef4444;
        color:        #fff;
        border-color: #ef4444;
        transform:    scale(1.08);
        box-shadow:   0 4px 10px rgba(239,68,68,0.30);
    }

    /* add item button */
    .no-add-item-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             7px;
        padding:         9px 18px;
        background:      rgba(59,130,246,0.08);
        color:           #3b82f6;
        border:          1.5px solid rgba(59,130,246,0.22);
        border-radius:   9px;
        font-size:       0.845rem;
        font-weight:     600;
        cursor:          pointer;
        transition:      all 0.22s ease;
        margin-bottom:   20px;
    }

    .no-add-item-btn i    { font-size: 0.78rem; }
    .no-add-item-btn:hover {
        background:   #3b82f6;
        color:        #fff;
        border-color: #3b82f6;
        transform:    translateY(-1px);
        box-shadow:   0 4px 12px rgba(59,130,246,0.28);
    }

    /* ============================================
       TOTAL BOX
    ============================================ */
    .no-total-box {
        background:    linear-gradient(135deg,rgba(16,185,129,0.08),rgba(5,150,105,0.05));
        border:        1.5px solid rgba(16,185,129,0.22);
        border-radius: 12px;
        padding:       16px 20px;
        display:       flex;
        align-items:   center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .no-total-label {
        display:     flex;
        align-items: center;
        gap:         8px;
        font-size:   0.88rem;
        font-weight: 700;
        color:       var(--no-text-heading);
    }

    .no-total-label i { color: #10b981; }

    .no-total-val {
        font-size:   1.4rem;
        font-weight: 800;
        color:       #059669;
        font-family: monospace;
        transition:  all 0.3s ease;
    }

    /* ============================================
       FOOTER BUTTONS
    ============================================ */
    .no-footer {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        gap:             10px;
        padding-top:     4px;
    }

    .no-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             7px;
        padding:         11px 22px;
        border-radius:   10px;
        font-size:       0.855rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        text-decoration: none;
        transition:      all 0.25s ease;
        white-space:     nowrap;
    }

    .no-btn i    { font-size: 0.80rem; }
    .no-btn:hover { transform: translateY(-2px); text-decoration: none; }
    .no-btn:active { transform: translateY(0); }

    .no-btn-back {
        background:   var(--no-input-bg);
        color:        var(--no-text-body);
        border-color: var(--no-input-border);
    }

    .no-btn-back:hover {
        border-color: #64748b;
        color:        var(--no-text-heading);
        box-shadow:   0 4px 14px rgba(0,0,0,0.08);
    }

    .no-btn-back:hover i { transform: translateX(-3px); }

    .no-btn-create {
        background:  linear-gradient(135deg,#065f46,#10b981);
        color:       #fff;
        border-color: transparent;
        box-shadow:  0 3px 12px rgba(16,185,129,0.30);
    }

    .no-btn-create:hover {
        box-shadow: 0 7px 20px rgba(16,185,129,0.44);
        color:      #fff;
    }

    .no-btn-create.no-loading {
        pointer-events: none;
        opacity:        0.80;
    }

    @keyframes no-spin { to { transform: rotate(360deg); } }

    /* ============================================
       MENU REFERENCE SIDEBAR
    ============================================ */
    .no-ref-card { animation-delay: .08s; }

    .no-ref-category {
        padding:       12px 18px;
        border-bottom: 1px solid var(--no-divider);
    }

    .no-ref-category:last-child { border-bottom: none; }

    .no-ref-cat-name {
        font-size:      0.68rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color:          var(--no-text-muted);
        margin-bottom:  8px;
        display:        flex;
        align-items:    center;
        gap:            5px;
    }

    .no-ref-cat-name i { color: #10b981; font-size: 0.70rem; }

    .no-ref-item {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        padding:         5px 0;
        border-bottom:   1px solid var(--no-divider);
        cursor:          pointer;
        border-radius:   6px;
        transition:      background 0.18s;
    }

    .no-ref-item:last-child { border-bottom: none; }

    .no-ref-item:hover {
        background: var(--no-row-hover);
        padding:    5px 6px;
    }

    .no-ref-item-name {
        font-size:   0.815rem;
        color:       var(--no-text-body);
        display:     flex;
        align-items: center;
        gap:         6px;
    }

    .no-ref-item-name i {
        font-size: 0.65rem;
        color:     var(--no-text-muted);
    }

    .no-ref-price {
        font-size:   0.815rem;
        font-weight: 700;
        color:       #059669;
    }

    /* search in ref */
    .no-ref-search-wrap {
        padding:  12px 18px;
        border-bottom: 1px solid var(--no-divider);
    }

    .no-ref-search {
        width:         100%;
        background:    var(--no-input-bg);
        border:        1.5px solid var(--no-input-border);
        border-radius: 8px;
        padding:       7px 10px 7px 28px;
        font-size:     0.80rem;
        color:         var(--no-input-text);
        outline:       none;
        transition:    border-color 0.2s, box-shadow 0.2s;
    }

    .no-ref-search::placeholder { color: var(--no-text-muted); }
    .no-ref-search:focus        { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.10); }

    .no-ref-sw {
        position: relative;
    }

    .no-ref-sw i {
        position:       absolute;
        left:           9px;
        top:            50%;
        transform:      translateY(-50%);
        color:          var(--no-text-muted);
        font-size:      0.70rem;
        pointer-events: none;
    }

    /* order summary in sidebar */
    .no-summary-card {
        background:    var(--no-card-bg);
        border:        1px solid var(--no-card-border);
        border-radius: 14px;
        box-shadow:    var(--no-card-shadow);
        overflow:      hidden;
        margin-bottom: 16px;
        animation:     no-up 0.42s 0.12s ease both;
    }

    .no-summary-item {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        padding:         9px 18px;
        border-bottom:   1px solid var(--no-divider);
        font-size:       0.82rem;
    }

    .no-summary-item:last-child { border-bottom: none; }

    .no-summary-key {
        color:       var(--no-text-muted);
        font-weight: 600;
        font-size:   0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .no-summary-val {
        font-weight: 600;
        color:       var(--no-text-heading);
        font-size:   0.845rem;
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 767px) {
        .no-item-row {
            grid-template-columns: 1fr 80px;
            grid-template-rows:    auto auto;
        }

        .no-item-row > :nth-child(3) {
            grid-column: 1;
        }

        .no-item-row > :nth-child(4) {
            grid-column: 2;
            grid-row:    2;
        }

        .no-footer { flex-direction: column-reverse; }
        .no-btn    { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')

<!-- ========================================================
     PAGE HEADER
======================================================== -->
<div class="no-page-header">
    <div>
        <h5 class="no-page-title">
            <div class="no-title-icon">
                <i class="ti ti-receipt"></i>
            </div>
            Create New Order
        </h5>
        <div class="no-breadcrumb">
            <i class="ti ti-home" style="font-size:0.65rem;"></i>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="ti ti-chevron-right sep"></i>
            <a href="{{ route('admin.orders.index') }}">Orders</a>
            <i class="ti ti-chevron-right sep"></i>
            <span class="cur">New Order</span>
        </div>
    </div>
    <a href="{{ route('admin.orders.index') }}"
       class="no-btn no-btn-back" style="transform:none;">
        <i class="ti ti-arrow-left"></i> Back to Orders
    </a>
</div>

<div class="row g-4">

    <!-- ===================== LEFT — FORM ===================== -->
    <div class="col-lg-8">
        <div class="no-card">

            <!-- Header -->
            <div class="no-card-hd">
                <div class="no-hd-icon"
                     style="background:rgba(16,185,129,0.10);color:#10b981;">
                    <i class="ti ti-plus"></i>
                </div>
                <h6>New Order Details</h6>
            </div>

            <div class="no-card-body">

                <!-- Error Alert -->
                @if($errors->any())
                <div class="no-alert">
                    <div class="no-alert-hd">
                        <i class="ti ti-alert-circle"></i>
                        Please fix the following errors:
                    </div>
                    <ul>
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.orders.store') }}"
                      id="orderForm">
                    @csrf

                    <!-- ---- Order Settings ---- -->
                    <div class="no-section-label">
                        <i class="ti ti-settings"></i>
                        Order Settings
                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <div class="no-form-group">
                                <label class="no-label">
                                    Order Type <span class="req">*</span>
                                </label>
                                <select name="order_type"
                                        class="no-select"
                                        id="orderType"
                                        required>
                                    <option value="dine_in">Dine In</option>
                                    <option value="takeaway">Takeaway</option>
                                    <option value="delivery">Delivery</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="no-form-group">
                                <label class="no-label">Table</label>
                                <select name="table_id" class="no-select">
                                    <option value="">— No Table (Takeaway) —</option>
                                    @foreach($tables as $table)
                                    <option value="{{ $table->id }}">
                                        Table #{{ $table->table_number }}
                                        ({{ $table->capacity }} persons)
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="no-form-group">
                                <label class="no-label">Payment Method</label>
                                <select name="payment_method" class="no-select">
                                    <option value="cash">
                                        Cash
                                    </option>
                                    <option value="card">
                                        Card
                                    </option>
                                    <option value="online">
                                        Online
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="no-form-group">
                                <label class="no-label">Notes</label>
                                <input type="text"
                                       name="notes"
                                       class="no-input"
                                       placeholder="Special instructions...">
                            </div>
                        </div>

                    </div>

                    <!-- ---- Menu Items ---- -->
                    <div class="no-section-label">
                        <i class="ti ti-tools-kitchen-2"></i>
                        Select Menu Items
                    </div>

                    <!-- Items Container -->
                    <div class="no-items-container" id="orderItems">

                        <!-- First row (static) -->
                        <div class="no-item-row">
                            <span class="no-item-num">Item 1</span>

                            <div>
                                <label class="no-label">
                                    Menu Item <span class="req">*</span>
                                </label>
                                <select name="items[0][id]"
                                        class="no-select item-select"
                                        onchange="updatePrice(this)"
                                        required>
                                    <option value="">— Select Item —</option>
                                    @foreach($menuItems->groupBy('category.name') as $cat => $items)
                                    <optgroup label="{{ $cat }}">
                                        @foreach($items as $item)
                                        <option value="{{ $item->id }}"
                                                data-price="{{ $item->price }}">
                                            {{ $item->name }}
                                            — Rs.{{ number_format($item->price, 0) }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="no-label">
                                    Qty <span class="req">*</span>
                                </label>
                                <input type="number"
                                       name="items[0][qty]"
                                       class="no-input item-qty"
                                       value="1"
                                       min="1"
                                       onchange="calculateTotal()"
                                       required>
                            </div>

                            <div>
                                <label class="no-label">Note</label>
                                <input type="text"
                                       name="items[0][note]"
                                       class="no-input"
                                       placeholder="e.g. no onion">
                            </div>

                            <button type="button"
                                    class="no-remove-btn"
                                    onclick="removeItem(this)"
                                    title="Remove item">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>

                    </div>

                    <!-- Add Item Button -->
                    <button type="button"
                            class="no-add-item-btn"
                            onclick="addItem()">
                        <i class="ti ti-plus"></i>
                        Add Another Item
                    </button>

                    <!-- Total Box -->
                    <div class="no-total-box">
                        <div class="no-total-label">
                            <i class="ti ti-currency-rupee"></i>
                            Total Amount
                        </div>
                        <div class="no-total-val" id="totalDisplay">
                            Rs. 0
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="no-footer">
                        <a href="{{ route('admin.orders.index') }}"
                           class="no-btn no-btn-back">
                            <i class="ti ti-arrow-left"></i>
                            Cancel
                        </a>
                        <button type="submit"
                                class="no-btn no-btn-create"
                                id="createBtn">
                            <i class="ti ti-check" id="createIcon"></i>
                            <span id="createText">Create Order</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- ===================== RIGHT SIDEBAR ===================== -->
    <div class="col-lg-4">

        <!-- Live Summary Card -->
        <div class="no-summary-card">
            <div class="no-card-hd">
                <div class="no-hd-icon"
                     style="background:rgba(16,185,129,0.10);color:#10b981;">
                    <i class="ti ti-chart-bar"></i>
                </div>
                <h6>Order Summary</h6>
            </div>
            <div class="no-summary-item">
                <span class="no-summary-key">Items Added</span>
                <span class="no-summary-val" id="summaryItems">0</span>
            </div>
            <div class="no-summary-item">
                <span class="no-summary-key">Total Qty</span>
                <span class="no-summary-val" id="summaryQty">0</span>
            </div>
            <div class="no-summary-item">
                <span class="no-summary-key">Total Amount</span>
                <span class="no-summary-val"
                      style="color:#059669; font-size:1rem; font-weight:800;"
                      id="summaryTotal">Rs. 0</span>
            </div>
        </div>

        <!-- Menu Reference Card -->
        <div class="no-card no-ref-card">
            <div class="no-card-hd">
                <div class="no-hd-icon"
                     style="background:rgba(59,130,246,0.10);color:#3b82f6;">
                    <i class="ti ti-list"></i>
                </div>
                <h6>Menu Reference</h6>
            </div>

            <!-- Search -->
            <div class="no-ref-search-wrap">
                <div class="no-ref-sw">
                    <i class="ti ti-search"></i>
                    <input type="text"
                           class="no-ref-search"
                           id="refSearch"
                           placeholder="Search menu...">
                </div>
            </div>

            <!-- Menu Items List -->
            <div id="refList" style="max-height:420px; overflow-y:auto;">
                @foreach($menuItems->groupBy('category.name') as $cat => $items)
                <div class="no-ref-category ref-cat-block">
                    <div class="no-ref-cat-name">
                        <i class="ti ti-tag"></i>
                        {{ $cat }}
                    </div>
                    @foreach($items as $item)
                    <div class="no-ref-item ref-item-entry"
                         data-name="{{ strtolower($item->name) }}"
                         title="Click to add to order"
                         onclick="quickAdd({{ $item->id }}, {{ $item->price }})">
                        <span class="no-ref-item-name">
                            <i class="ti ti-point"></i>
                            {{ $item->name }}
                        </span>
                        <span class="no-ref-price">
                            Rs.&nbsp;{{ number_format($item->price, 0) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
let itemIndex = 1;

/* --- menu item prices from Laravel --- */
const menuPrices = @json($menuItems->pluck('price', 'id'));
const menuNames  = @json($menuItems->pluck('name',  'id'));

/* --------------------------------------------------------
   Build <option> HTML for all menu items
-------------------------------------------------------- */
function getMenuOptions(selectedId = '') {
    let html = '<option value="">— Select Item —</option>';
    @foreach($menuItems->groupBy('category.name') as $cat => $items)
    html += `<optgroup label="{{ $cat }}">`;
    @foreach($items as $item)
    html += `<option value="{{ $item->id }}"
                     data-price="{{ $item->price }}"
                     ${selectedId == {{ $item->id }} ? 'selected' : ''}>
                {{ $item->name }} — Rs.{{ number_format($item->price, 0) }}
             </option>`;
    @endforeach
    html += '</optgroup>';
    @endforeach
    return html;
}

/* --------------------------------------------------------
   Add new item row
-------------------------------------------------------- */
function addItem(preSelectId = '') {
    const container = document.getElementById('orderItems');
    const rowNum    = container.querySelectorAll('.no-item-row').length + 1;

    const div       = document.createElement('div');
    div.className   = 'no-item-row';
    div.innerHTML   = `
        <span class="no-item-num">Item ${rowNum}</span>

        <div>
            <label class="no-label">
                Menu Item <span class="req">*</span>
            </label>
            <select name="items[${itemIndex}][id]"
                    class="no-select item-select"
                    onchange="updatePrice(this)"
                    required>
                ${getMenuOptions(preSelectId)}
            </select>
        </div>

        <div>
            <label class="no-label">
                Qty <span class="req">*</span>
            </label>
            <input type="number"
                   name="items[${itemIndex}][qty]"
                   class="no-input item-qty"
                   value="1" min="1"
                   onchange="calculateTotal()"
                   required>
        </div>

        <div>
            <label class="no-label">Note</label>
            <input type="text"
                   name="items[${itemIndex}][note]"
                   class="no-input"
                   placeholder="e.g. no onion">
        </div>

        <button type="button"
                class="no-remove-btn"
                onclick="removeItem(this)"
                title="Remove item">
            <i class="ti ti-trash"></i>
        </button>
    `;

    container.appendChild(div);
    itemIndex++;

    /* trigger total update */
    calculateTotal();
    renumberRows();
}

/* --------------------------------------------------------
   Quick add from menu reference
-------------------------------------------------------- */
function quickAdd(itemId, price) {
    /* check if item already exists */
    const selects = document.querySelectorAll('.item-select');
    for (let s of selects) {
        if (s.value == itemId) {
            /* increment qty instead */
            const row = s.closest('.no-item-row');
            const qty = row.querySelector('.item-qty');
            qty.value = parseInt(qty.value) + 1;
            calculateTotal();
            qty.classList.add('highlight');
            setTimeout(() => qty.classList.remove('highlight'), 600);
            return;
        }
    }
    addItem(itemId);
}

/* --------------------------------------------------------
   Remove item row
-------------------------------------------------------- */
function removeItem(btn) {
    const rows = document.querySelectorAll('.no-item-row');
    if (rows.length > 1) {
        btn.closest('.no-item-row').remove();
        calculateTotal();
        renumberRows();
    }
}

/* --------------------------------------------------------
   Renumber row labels
-------------------------------------------------------- */
function renumberRows() {
    document.querySelectorAll('.no-item-row').forEach((row, i) => {
        const lbl = row.querySelector('.no-item-num');
        if (lbl) lbl.textContent = 'Item ' + (i + 1);
    });
}

/* --------------------------------------------------------
   Update price on select change
-------------------------------------------------------- */
function updatePrice(select) {
    calculateTotal();
}

/* --------------------------------------------------------
   Calculate & display total
-------------------------------------------------------- */
function calculateTotal() {
    let total    = 0;
    let itemsCnt = 0;
    let qtyCnt   = 0;

    document.querySelectorAll('.no-item-row').forEach(row => {
        const sel = row.querySelector('.item-select');
        const qty = row.querySelector('.item-qty');
        if (sel && sel.value && qty) {
            const price  = parseFloat(menuPrices[sel.value] || 0);
            const q      = parseInt(qty.value || 1);
            total       += price * q;
            qtyCnt      += q;
            itemsCnt++;
        }
    });

    const fmt = 'Rs. ' + total.toLocaleString();
    document.getElementById('totalDisplay').textContent  = fmt;
    document.getElementById('summaryTotal').textContent  = fmt;
    document.getElementById('summaryItems').textContent  = itemsCnt;
    document.getElementById('summaryQty').textContent    = qtyCnt;
}

/* --------------------------------------------------------
   Submit loading state
-------------------------------------------------------- */
document.getElementById('orderForm').addEventListener('submit', function () {
    const btn  = document.getElementById('createBtn');
    const icon = document.getElementById('createIcon');
    const txt  = document.getElementById('createText');
    btn.classList.add('no-loading');
    icon.className       = 'ti ti-loader-2';
    icon.style.animation = 'no-spin 0.7s linear infinite';
    txt.textContent      = 'Creating...';
});

/* --------------------------------------------------------
   Menu reference search
-------------------------------------------------------- */
document.getElementById('refSearch').addEventListener('input', function () {
    const q       = this.value.toLowerCase().trim();
    const entries = document.querySelectorAll('.ref-item-entry');
    const cats    = document.querySelectorAll('.ref-cat-block');

    entries.forEach(e => {
        e.style.display = e.dataset.name.includes(q) ? '' : 'none';
    });

    /* hide empty category blocks */
    cats.forEach(c => {
        const visible = [...c.querySelectorAll('.ref-item-entry')]
            .some(e => e.style.display !== 'none');
        c.style.display = visible ? '' : 'none';
    });
});

/* --------------------------------------------------------
   Dark theme detect
-------------------------------------------------------- */
document.addEventListener('DOMContentLoaded', function () {
    const dark =
        document.body.classList.contains('dark') ||
        document.body.classList.contains('dark-mode') ||
        document.documentElement.getAttribute('data-theme')    === 'dark' ||
        document.documentElement.getAttribute('data-bs-theme') === 'dark';
    if (dark) document.documentElement.setAttribute('data-theme','dark');

    calculateTotal();
});
</script>

<style>
/* qty highlight flash */
@keyframes no-highlight {
    0%,100% { border-color: var(--no-input-border); }
    50%      { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.20); }
}

.no-input.highlight {
    animation: no-highlight 0.6s ease;
}
</style>
@endpush