@extends('layouts.admin')
@section('title', 'New Order')
@section('page-title', 'Create New Order')

@push('styles')
<style>
    /* ========== THEME VARIABLES ========== */
    .order-create-wrapper {
        --card-bg: #ffffff;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.15);
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --text-muted: #858796;
        --gradient-green: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --gradient-blue: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --gradient-purple: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        --gradient-pink: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        --section-bg: #f8f9fc;
        --border-color: #e3e6f0;
    }

    /* Dark Theme */
    body.dark-mode .order-create-wrapper,
    body.sidebar-dark-primary .order-create-wrapper,
    [data-theme="dark"] .order-create-wrapper,
    [data-bs-theme="dark"] .order-create-wrapper {
        --card-bg: #1e2936;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.6);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.9);
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --section-bg: #141A21;
        --border-color: #3d4954;
    }

    .order-create-wrapper {
        background: var(--section-bg);
        min-height: 100vh;
        padding: 0;
        margin: 0;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ========== HEADER ========== */
    .page-header {
        background: var(--gradient-green);
        padding: 3rem;
        position: relative;
        overflow: hidden;
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-header::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        top: -150px;
        right: -100px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 15s ease-in-out infinite;
    }

    .page-header::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        bottom: -100px;
        left: -50px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float2 20s ease-in-out infinite;
    }

    @keyframes float1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(30px, 30px) rotate(180deg); }
    }

    @keyframes float2 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-30px, -30px) rotate(-180deg); }
    }

    .page-header-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .page-icon {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
        animation: pulse 3s ease-in-out infinite;
        border: 3px solid rgba(255,255,255,0.3);
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .page-title {
        color: white;
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0;
        text-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }

    .page-subtitle {
        color: rgba(255,255,255,0.95);
        margin: 0.5rem 0 0 0;
        font-size: 1.1rem;
    }

    .order-badge {
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        padding: 10px 24px;
        border-radius: 30px;
        color: white;
        font-weight: 800;
        font-size: 1.1rem;
        border: 2px solid rgba(255,255,255,0.3);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    /* ========== CONTENT ========== */
    .content-section {
        padding: 3rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ========== CARDS ========== */
    .details-card {
        background: var(--card-bg);
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 2px solid var(--border-color);
        animation: scaleIn 0.6s ease-out;
        transition: all 0.3s;
    }

    .details-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-5px);
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .card-header-custom {
        background: var(--gradient-green);
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-header-blue { background: var(--gradient-blue); }

    .card-title-custom {
        color: white;
        font-size: 1.4rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .card-body-custom {
        padding: 2.5rem;
    }

    /* ========== FORM FIELDS ========== */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .field-group {
        display: flex;
        align-items: start;
        gap: 1.5rem;
        padding: 1.2rem;
        background: var(--section-bg);
        border-radius: 16px;
        border: 2px solid transparent;
        transition: all 0.3s;
        animation: slideIn 0.5s ease-out backwards;
    }

    .field-group:hover {
        background: var(--card-bg);
        border-color: var(--border-color);
        transform: translateX(8px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .field-group:nth-child(1) { animation-delay: 0.1s; }
    .field-group:nth-child(2) { animation-delay: 0.15s; }
    .field-group:nth-child(3) { animation-delay: 0.2s; }
    .field-group:nth-child(4) { animation-delay: 0.25s; }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .field-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .icon-purple { background: var(--gradient-purple); }
    .icon-pink   { background: var(--gradient-pink); }
    .icon-green  { background: var(--gradient-green); }
    .icon-warn   { background: var(--gradient-warning); }

    .field-content { flex: 1; }

    .field-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.6rem;
        display: block;
    }

    .field-control {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.95rem;
        color: var(--text-primary);
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
    }

    .field-control:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16,185,129,0.12);
        transform: translateY(-2px);
    }

    /* ========== SECTION DIVIDER ========== */
    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--border-color);
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-green);
    }

    .section-title i { color: #10b981; font-size: 1.3rem; }

    /* ========== ORDER ITEMS ========== */
    .order-item-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
        padding: 1.5rem;
        background: var(--section-bg);
        border-radius: 16px;
        margin-bottom: 1rem;
        border: 2px solid transparent;
        transition: all 0.3s;
        animation: fadeInUp 0.4s ease-out backwards;
    }

    .order-item-row:hover {
        border-color: var(--border-color);
        box-shadow: 0 5px 20px rgba(0,0,0,0.07);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .item-label {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .btn-add-item {
        background: rgba(59,130,246,0.1);
        color: #3b82f6;
        border: 2px dashed #3b82f6;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    .btn-add-item:hover {
        background: var(--gradient-blue);
        color: white;
        border-color: transparent;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(59,130,246,0.35);
    }

    .btn-remove {
        background: var(--gradient-danger);
        color: white;
        border: none;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(239,68,68,0.3);
        flex-shrink: 0;
        align-self: flex-end;
    }

    .btn-remove:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 8px 25px rgba(239,68,68,0.5);
    }

    /* ========== TOTAL BOX ========== */
    .total-box {
        background: linear-gradient(135deg, rgba(16,185,129,0.12) 0%, rgba(5,150,105,0.06) 100%);
        border-left: 5px solid #10b981;
        padding: 1.8rem 2rem;
        border-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease-out 0.3s backwards;
    }

    .total-label {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .total-label i { color: #10b981; }

    .total-amount {
        font-size: 1.8rem;
        font-weight: 900;
        color: #10b981;
        text-shadow: 0 2px 10px rgba(16,185,129,0.3);
    }

    /* ========== ACTION BUTTONS ========== */
    .actions-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: fadeInUp 0.6s ease-out 0.4s backwards;
    }

    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 6px 20px rgba(108,117,125,0.3);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-back:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(108,117,125,0.4);
        color: white;
    }

    .btn-submit {
        background: var(--gradient-green);
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 6px 20px rgba(16,185,129,0.4);
        font-size: 0.9rem;
    }

    .btn-submit:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(16,185,129,0.55);
    }

    /* ========== ALERT ========== */
    .error-alert {
        background: linear-gradient(135deg, rgba(239,68,68,0.1) 0%, rgba(220,38,38,0.05) 100%);
        border-left: 5px solid #ef4444;
        padding: 1.2rem 1.5rem;
        border-radius: 14px;
        margin-bottom: 2rem;
    }

    /* ========== MENU REFERENCE (right sidebar) ========== */
    .menu-ref-card {
        background: var(--card-bg);
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        border: 2px solid var(--border-color);
        animation: scaleIn 0.6s ease-out 0.15s backwards;
        position: sticky;
        top: 1.5rem;
    }

    .menu-ref-body {
        max-height: 600px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #10b981 transparent;
    }

    .menu-category {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .menu-cat-label {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #10b981;
        margin-bottom: 0.8rem;
    }

    .menu-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.4rem 0;
        border-radius: 8px;
        transition: all 0.2s;
        padding: 0.4rem 0.6rem;
    }

    .menu-item-row:hover {
        background: var(--section-bg);
        transform: translateX(4px);
    }

    .menu-item-name { font-size: 0.88rem; color: var(--text-secondary); }
    .menu-item-price { font-size: 0.88rem; font-weight: 800; color: #10b981; }

    /* ========== TWO-COLUMN LAYOUT ========== */
    .main-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 2rem;
        align-items: start;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        .main-layout { grid-template-columns: 1fr; }
        .menu-ref-card { position: static; }
    }

    @media (max-width: 768px) {
        .page-header { padding: 2rem 1.5rem; }
        .page-title { font-size: 1.8rem; }
        .content-section { padding: 1.5rem; }
        .form-grid { grid-template-columns: 1fr; gap: 1rem; }
        .order-item-row { grid-template-columns: 1fr 1fr; grid-template-rows: auto auto; }
    }
</style>
@endpush

@section('content')
<div class="order-create-wrapper">

    <!-- ========== PAGE HEADER ========== -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="header-left">
                <div class="page-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <h1 class="page-title">Create New Order</h1>
                    <p class="page-subtitle">Fill in the details to place a new order</p>
                </div>
            </div>
            <div class="order-badge">
                <i class="fas fa-plus me-2"></i>New Order
            </div>
        </div>
    </div>

    <!-- ========== CONTENT ========== -->
    <div class="content-section">
        <div class="main-layout">

            <!-- LEFT: FORM -->
            <div>
                <form method="POST" action="{{ route('admin.orders.store') }}" id="orderForm">
                    @csrf

                    <!-- Error Alert -->
                    @if($errors->any())
                    <div class="error-alert mb-4">
                        @foreach($errors->all() as $e)
                        <div class="small fw-semibold" style="color:#ef4444;">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ $e }}
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- ===== ORDER INFO CARD ===== -->
                    <div class="details-card">
                        <div class="card-header-custom">
                            <h2 class="card-title-custom">
                                <i class="fas fa-info-circle"></i>
                                Order Information
                            </h2>
                        </div>
                        <div class="card-body-custom">
                            <div class="form-grid">

                                <!-- Order Type -->
                                <div class="field-group">
                                    <div class="field-icon icon-purple">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div class="field-content">
                                        <label class="field-label">Order Type *</label>
                                        <select name="order_type" class="field-control" required>
                                            <option value="dine_in">🍽️ Dine In</option>
                                            <option value="takeaway">🥡 Takeaway</option>
                                            <option value="delivery">🚴 Delivery</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="field-group">
                                    <div class="field-icon icon-pink">
                                        <i class="fas fa-chair"></i>
                                    </div>
                                    <div class="field-content">
                                        <label class="field-label">Table</label>
                                        <select name="table_id" class="field-control">
                                            <option value="">-- No Table --</option>
                                            @foreach($tables as $table)
                                            <option value="{{ $table->id }}">
                                                Table #{{ $table->table_number }} ({{ $table->capacity }} persons)
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="field-group">
                                    <div class="field-icon icon-green">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="field-content">
                                        <label class="field-label">Payment Method</label>
                                        <select name="payment_method" class="field-control">
                                            <option value="cash">💵 Cash</option>
                                            <option value="card">💳 Card</option>
                                            <option value="online">📱 Online</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="field-group">
                                    <div class="field-icon icon-warn">
                                        <i class="fas fa-sticky-note"></i>
                                    </div>
                                    <div class="field-content">
                                        <label class="field-label">Notes</label>
                                        <input type="text" name="notes" class="field-control"
                                               placeholder="Special instructions...">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ===== ORDER ITEMS CARD ===== -->
                    <div class="details-card" style="animation-delay:0.1s;">
                        <div class="card-header-custom card-header-blue">
                            <h2 class="card-title-custom">
                                <i class="fas fa-utensils"></i>
                                Select Items
                            </h2>
                        </div>
                        <div class="card-body-custom">

                            <div id="orderItems">
                                <div class="order-item-row">
                                    <div>
                                        <span class="item-label">Item *</span>
                                        <select name="items[0][id]" class="field-control item-select"
                                                onchange="calculateTotal()" required>
                                            <option value="">-- Select Item --</option>
                                            @foreach($menuItems->groupBy('category.name') as $cat => $items)
                                            <optgroup label="{{ $cat ?? 'Uncategorized' }}">
                                                @foreach($items as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }} — Rs.{{ number_format($item->price, 0) }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="item-label">Qty *</span>
                                        <input type="number" name="items[0][qty]" class="field-control item-qty"
                                               value="1" min="1" onchange="calculateTotal()" required>
                                    </div>
                                    <div>
                                        <span class="item-label">Item Note</span>
                                        <input type="text" name="items[0][note]" class="field-control"
                                               placeholder="e.g. no onion">
                                    </div>
                                    <button type="button" class="btn-remove" onclick="removeItem(this)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="button" class="btn-add-item" onclick="addItem()">
                                <i class="fas fa-plus-circle"></i>
                                Add Another Item
                            </button>

                            <!-- Total -->
                            <div class="total-box">
                                <span class="total-label">
                                    <i class="fas fa-calculator"></i>
                                    Total Amount
                                </span>
                                <span class="total-amount" id="totalDisplay">Rs. 0</span>
                            </div>

                            <!-- Actions -->
                            <div class="actions-row">
                                <a href="{{ route('admin.orders.index') }}" class="btn-back">
                                    <i class="fas fa-arrow-left"></i>
                                    Back
                                </a>
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-check-circle"></i>
                                    Create Order
                                </button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>

            <!-- RIGHT: MENU REFERENCE -->
            <div>
                <div class="menu-ref-card">
                    <div class="card-header-custom">
                        <h2 class="card-title-custom" style="font-size:1.1rem;">
                            <i class="fas fa-list-alt"></i>
                            Menu Reference
                        </h2>
                    </div>
                    <div class="menu-ref-body">
                        @foreach($menuItems->groupBy('category.name') as $cat => $items)
                        <div class="menu-category">
                            <div class="menu-cat-label">{{ $cat ?? 'Uncategorized' }}</div>
                            @foreach($items as $item)
                            <div class="menu-item-row">
                                <span class="menu-item-name">{{ $item->name }}</span>
                                <span class="menu-item-price">Rs.{{ number_format($item->price, 0) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div><!-- /main-layout -->
    </div><!-- /content-section -->

</div><!-- /order-create-wrapper -->
@endsection

@push('scripts')
<script>
let itemIndex = 1;
const menuPrices = @json($menuItems->pluck('price', 'id'));

function getMenuOptions() {
    let opts = '<option value="">-- Select Item --</option>';
    @foreach($menuItems->groupBy('category.name') as $cat => $items)
    opts += '<optgroup label="{{ addslashes($cat ?? 'Uncategorized') }}">';
    @foreach($items as $item)
    opts += '<option value="{{ $item->id }}">{{ addslashes($item->name) }} — Rs.{{ number_format($item->price, 0) }}</option>';
    @endforeach
    opts += '</optgroup>';
    @endforeach
    return opts;
}

function addItem() {
    const container = document.getElementById('orderItems');
    const div = document.createElement('div');
    div.className = 'order-item-row';
    div.style.animationDelay = '0s';
    div.innerHTML = `
        <div>
            <span class="item-label">Item *</span>
            <select name="items[${itemIndex}][id]" class="field-control item-select" onchange="calculateTotal()" required>
                ${getMenuOptions()}
            </select>
        </div>
        <div>
            <span class="item-label">Qty *</span>
            <input type="number" name="items[${itemIndex}][qty]" class="field-control item-qty"
                   value="1" min="1" onchange="calculateTotal()" required>
        </div>
        <div>
            <span class="item-label">Item Note</span>
            <input type="text" name="items[${itemIndex}][note]" class="field-control" placeholder="e.g. no onion">
        </div>
        <button type="button" class="btn-remove" onclick="removeItem(this)">
            <i class="fas fa-trash-alt"></i>
        </button>
    `;
    container.appendChild(div);
    itemIndex++;
    calculateTotal();
}

function removeItem(btn) {
    const items = document.querySelectorAll('.order-item-row');
    if (items.length > 1) {
        btn.closest('.order-item-row').remove();
        calculateTotal();
    }
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.order-item-row').forEach(function(row) {
        const select = row.querySelector('.item-select');
        const qty    = row.querySelector('.item-qty');
        if (select && select.value && qty) {
            const price = menuPrices[select.value] || 0;
            total += price * parseInt(qty.value || 1);
        }
    });
    document.getElementById('totalDisplay').textContent = 'Rs. ' + total.toLocaleString();
}
</script>
@endpush