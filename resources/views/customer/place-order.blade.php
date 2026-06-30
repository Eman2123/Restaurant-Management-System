@extends('layouts.customer')
@section('title', 'Place Order')

@section('content')
<div style="padding-top:90px; background:#0d0d0d; min-height:100vh;">

    <!-- Header -->
    <div style="background:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),
                url('{{ asset('vendor/thevenue/images/menu.jpg') }}')
                center/cover; padding:60px 0; text-align:center;">
        <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                  text-transform:uppercase; margin-bottom:15px;
                  display:flex; align-items:center; justify-content:center;">
            <i class="fas fa-shopping-cart" style="margin-right:10px; font-size:13px;"></i>
            Order Online
        </p>
        <h1 style="color:#fff; font-family:'Playfair Display',serif;
                   font-size:48px; font-weight:400;">
            Place Your Order
        </h1>
    </div>

    <div class="container py-5">
        <div class="row">

            <!-- Left: Menu Items -->
            <div class="col-lg-8">

                @if($errors->any())
                <div style="background:rgba(220,53,69,0.15);
                            border-left:4px solid #dc3545;
                            color:#dc3545; padding:16px 18px; margin-bottom:25px;
                            border-radius:4px;">
                    <div style="display:flex; align-items:center; margin-bottom:8px;">
                        <i class="fas fa-exclamation-circle" style="margin-right:10px; font-size:18px;"></i>
                        <strong>Please check the following:</strong>
                    </div>
                    @foreach($errors->all() as $e)
                    <div style="margin-left:28px; font-size:13px; margin-top:6px;">
                        • {{ $e }}
                    </div>
                    @endforeach
                </div>
                @endif

                <form method="POST"
                      action="{{ route('customer.order.store') }}"
                      id="orderForm">
                    @csrf

                    <!-- Order Details -->
                    <div style="background:#1a1a1a; padding:30px;
                                margin-bottom:30px; border:1px solid #2a2a2a;
                                border-radius:8px;">
                        <h5 style="color:#c8a951; font-size:11px;
                                    letter-spacing:3px; text-transform:uppercase;
                                    margin-bottom:25px; font-weight:600;
                                    display:flex; align-items:center;">
                            <i class="fas fa-clipboard-list" style="margin-right:10px; font-size:14px;"></i>
                            Order Details
                        </h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label style="color:#888; font-size:12px;
                                              letter-spacing:1px; display:block;
                                              margin-bottom:8px; font-weight:600;
                                              display:flex; align-items:center;">
                                    <i class="fas fa-list" style="margin-right:6px; color:#c8a951; font-size:13px;"></i>
                                    Order Type *
                                </label>
                                <select name="order_type" id="orderType"
                                        onchange="toggleTable()"
                                        style="width:100%; background:#111;
                                               border:1px solid #333; color:#fff;
                                               padding:11px; font-size:14px;
                                               border-radius:4px; cursor:pointer;
                                               transition:border-color 0.2s ease;"
                                        onfocus="this.style.borderColor='#c8a951';"
                                        onblur="this.style.borderColor='#333';">
                                    <option value="dine_in">Dine In</option>
                                    <option value="takeaway">Takeaway</option>
                                    <option value="delivery">Delivery</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3" id="tableField">
                                <label style="color:#888; font-size:12px;
                                              letter-spacing:1px; display:block;
                                              margin-bottom:8px; font-weight:600;
                                              display:flex; align-items:center;">
                                    <i class="fas fa-chair" style="margin-right:6px; color:#c8a951; font-size:13px;"></i>
                                    Select Table
                                </label>
                                <select name="table_id"
                                        style="width:100%; background:#111;
                                               border:1px solid #333; color:#fff;
                                               padding:11px; font-size:14px;
                                               border-radius:4px; cursor:pointer;
                                               transition:border-color 0.2s ease;"
                                        onfocus="this.style.borderColor='#c8a951';"
                                        onblur="this.style.borderColor='#333';">
                                    <option value="">-- No Preference --</option>
                                    @foreach($tables as $table)
                                    <option value="{{ $table->id }}">
                                        Table #{{ $table->table_number }}
                                        ({{ $table->capacity }} persons)
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="color:#888; font-size:12px;
                                              letter-spacing:1px; display:block;
                                              margin-bottom:8px; font-weight:600;
                                              display:flex; align-items:center;">
                                    <i class="fas fa-credit-card" style="margin-right:6px; color:#c8a951; font-size:13px;"></i>
                                    Payment Method
                                </label>
                                <select name="payment_method"
                                        style="width:100%; background:#111;
                                               border:1px solid #333; color:#fff;
                                               padding:11px; font-size:14px;
                                               border-radius:4px; cursor:pointer;
                                               transition:border-color 0.2s ease;"
                                        onfocus="this.style.borderColor='#c8a951';"
                                        onblur="this.style.borderColor='#333';">
                                    <option value="cash">
                                        <i class="fas fa-money-bill"></i> Cash
                                    </option>
                                    <option value="card">Card</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label style="color:#888; font-size:12px;
                                              letter-spacing:1px; display:block;
                                              margin-bottom:8px; font-weight:600;
                                              display:flex; align-items:center;">
                                    <i class="fas fa-sticky-note" style="margin-right:6px; color:#c8a951; font-size:13px;"></i>
                                    Special Notes
                                </label>
                                <input type="text" name="notes"
                                       placeholder="Any special instructions..."
                                       style="width:100%; background:#111;
                                              border:1px solid #333; color:#fff;
                                              padding:11px; font-size:14px;
                                              border-radius:4px;
                                              transition:border-color 0.2s ease;"
                                       onfocus="this.style.borderColor='#c8a951';"
                                       onblur="this.style.borderColor='#333';">
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter Tabs -->
                    <div style="display:flex; gap:8px; flex-wrap:wrap;
                                margin-bottom:25px; align-items:center;">
                        <span style="color:#c8a951; font-size:11px;
                                     letter-spacing:2px; text-transform:uppercase;
                                     font-weight:600; margin-right:8px;">
                            <i class="fas fa-filter" style="margin-right:6px;"></i>
                            Filter:
                        </span>
                        <button type="button"
                                onclick="filterCategory('all')"
                                class="cat-btn"
                                data-cat="all"
                                style="background:#c8a951; color:#000;
                                       border:none;
                                       padding:10px 20px; font-size:11px;
                                       letter-spacing:2px;
                                       text-transform:uppercase;
                                       cursor:pointer; border-radius:4px;
                                       font-weight:600;
                                       transition:all 0.2s ease;">
                            All Items
                        </button>
                        @foreach($categories as $cat)
                        <button type="button"
                                onclick="filterCategory('{{ $cat->id }}')"
                                class="cat-btn" data-cat="{{ $cat->id }}"
                                style="background:transparent; color:#888;
                                       border:1px solid #333; padding:9px 18px;
                                       font-size:11px; letter-spacing:2px;
                                       text-transform:uppercase;
                                       cursor:pointer; border-radius:4px;
                                       transition:all 0.2s ease;"
                                onmouseover="this.style.borderColor='#c8a951'; this.style.color='#c8a951';"
                                onmouseout="this.style.borderColor='#333'; this.style.color='#888';">
                            {{ $cat->name }}
                        </button>
                        @endforeach
                    </div>

                    <!-- Menu Items -->
                    @foreach($categories as $cat)
                        @foreach($cat->menuItems as $item)
                        <div class="menu-item-card"
                             data-cat="{{ $cat->id }}"
                             id="card-{{ $item->id }}"
                             style="background:linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
                                    border:1px solid #2a2a2a;
                                    padding:18px; margin-bottom:12px;
                                    display:flex; align-items:center;
                                    gap:16px; transition:all 0.3s ease;
                                    border-radius:6px;
                                    cursor:pointer;"
                             onmouseover="this.style.borderColor='#c8a951'; this.style.boxShadow='0 4px 16px rgba(200,169,81,0.15)';"
                             onmouseout="this.style.borderColor='#2a2a2a'; this.style.boxShadow='none';">

                            <!-- Image -->
                            <div style="width:80px; height:80px;
                                        flex-shrink:0; overflow:hidden;
                                        border-radius:6px; background:#111;
                                        border:1px solid #333;">
                                @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}"
                                     style="width:100%; height:100%;
                                            object-fit:cover;">
                                @else
                                <div style="width:100%; height:100%;
                                            background:#222;
                                            display:flex; align-items:center;
                                            justify-content:center;">
                                    <i class="fas fa-image" style="font-size:32px; color:#444;"></i>
                                </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <div style="flex:1;">
                                <div style="color:#fff; font-size:16px;
                                            font-weight:600; margin-bottom:4px;">
                                    {{ $item->name }}
                                </div>
                                <div style="color:#888; font-size:12px;
                                            margin-bottom:8px;">
                                    {{ Str::limit($item->description, 60) }}
                                </div>
                                <div style="color:#c8a951; font-size:18px;
                                            font-weight:700;">
                                    Rs.{{ number_format($item->price, 0) }}
                                </div>
                            </div>

                            <!-- Qty Controls -->
                            <div style="text-align:center; flex-shrink:0;
                                        min-width:110px;">

                                <!-- Qty Controller (hidden initially) -->
                                <div id="qty-ctrl-{{ $item->id }}"
                                     style="display:none; align-items:center;
                                            gap:6px; margin-bottom:8px;
                                            justify-content:center;">
                                    <button type="button"
                                            onclick="changeQty({{ $item->id }}, -1)"
                                            style="width:36px; height:36px;
                                                   background:#333; border:none;
                                                   color:#fff; font-size:18px;
                                                   cursor:pointer; border-radius:4px;
                                                   line-height:1; transition:all 0.2s ease;"
                                            onmouseover="this.style.background='#c8a951'; this.style.color='#000';"
                                            onmouseout="this.style.background='#333'; this.style.color='#fff';">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span id="qty-{{ $item->id }}"
                                          style="color:#c8a951; font-size:18px;
                                                 font-weight:700; min-width:28px;
                                                 text-align:center;">0</span>
                                    <button type="button"
                                            onclick="changeQty({{ $item->id }}, 1)"
                                            style="width:36px; height:36px;
                                                   background:#c8a951; border:none;
                                                   color:#000; font-size:18px;
                                                   cursor:pointer; border-radius:4px;
                                                   line-height:1; transition:all 0.2s ease;
                                                   font-weight:700;"
                                            onmouseover="this.style.background='#d4b86a';"
                                            onmouseout="this.style.background='#c8a951';">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Add Button -->
                                <button type="button"
                                        id="add-{{ $item->id }}"
                                        onclick="addItem({{ $item->id }},
                                                 '{{ addslashes($item->name) }}',
                                                 {{ $item->price }})"
                                        style="background:#c8a951; color:#000;
                                               border:none; padding:10px 18px;
                                               font-size:11px; letter-spacing:2px;
                                               text-transform:uppercase;
                                               cursor:pointer; border-radius:4px;
                                               transition:all 0.2s ease;
                                               font-weight:600;
                                               width:100%;"
                                        onmouseover="this.style.background='#d4b86a'; this.style.transform='translateY(-2px)';"
                                        onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)';">
                                    <i class="fas fa-plus-circle" style="margin-right:6px;"></i>
                                    Add
                                </button>

                                <!-- Hidden inputs -->
                                <input type="hidden"
                                       name="items[{{ $item->id }}][id]"
                                       id="input-id-{{ $item->id }}"
                                       value="">
                                <input type="hidden"
                                       name="items[{{ $item->id }}][qty]"
                                       id="input-qty-{{ $item->id }}"
                                       value="0">
                            </div>
                        </div>
                        @endforeach
                    @endforeach

                    <!-- Coupon + hidden fields -->
                    <input type="hidden" name="coupon_code" id="couponCode">
                    <input type="hidden" name="discount_amount"
                           id="discountAmount" value="0">

                </form>
            </div>

            <!-- Right: Cart Sidebar -->
            <div class="col-lg-4">
                <div style="background:linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
                            border:1px solid #2a2a2a;
                            padding:28px; position:sticky; top:100px;
                            border-radius:8px;">

                    <h5 style="color:#c8a951; font-size:11px;
                                letter-spacing:3px; text-transform:uppercase;
                                margin-bottom:20px; font-weight:600;
                                display:flex; align-items:center;">
                        <i class="fas fa-shopping-bag" style="margin-right:10px; font-size:14px;"></i>
                        Your Order
                    </h5>

                    <!-- Cart Items -->
                    <div id="cartItems" style="min-height:100px;
                                               margin-bottom:20px;
                                               max-height:300px; overflow-y:auto;">
                        <div id="emptyCart"
                             style="text-align:center; color:#666;
                                    padding:40px 0; font-size:14px;
                                    display:flex; flex-direction:column;
                                    align-items:center; gap:12px;">
                            <i class="fas fa-inbox" style="font-size:32px; color:#444;"></i>
                            <span>No items added yet</span>
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div style="border-top:1px solid #2a2a2a;
                                padding-top:18px; margin-bottom:20px;">
                        <div style="color:#c8a951; font-size:11px;
                                    letter-spacing:2px; text-transform:uppercase;
                                    margin-bottom:10px; font-weight:600;
                                    display:flex; align-items:center;">
                            <i class="fas fa-ticket-alt" style="margin-right:8px;"></i>
                            Coupon Code
                        </div>
                        <div style="display:flex; gap:8px;">
                            <input type="text" id="couponInput"
                                   placeholder="Enter code..."
                                   style="flex:1; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:10px 12px; font-size:13px;
                                          text-transform:uppercase; outline:none;
                                          border-radius:4px;
                                          transition:border-color 0.2s ease;"
                                   onfocus="this.style.borderColor='#c8a951';"
                                   onblur="this.style.borderColor='#333';">
                            <button type="button" onclick="applyCoupon()"
                                    style="background:#c8a951; color:#000;
                                           border:none; padding:10px 16px;
                                           font-size:11px; font-weight:700;
                                           cursor:pointer; border-radius:4px;
                                           white-space:nowrap;
                                           transition:all 0.2s ease;"
                                    onmouseover="this.style.background='#d4b86a'; this.style.transform='translateY(-2px)';"
                                    onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)';">
                                <i class="fas fa-check" style="margin-right:4px;"></i>
                                Apply
                            </button>
                        </div>
                        <div id="couponMsg"
                             style="font-size:12px; margin-top:8px;
                                    min-height:18px;"></div>
                    </div>

                    <!-- Total -->
                    <div style="border-top:1px solid #2a2a2a;
                                padding-top:18px; margin-bottom:25px;">
                        <div id="subtotalRow"
                             style="display:none; justify-content:space-between;
                                    margin-bottom:8px; font-size:13px;
                                    color:#888;">
                            <span>Subtotal:</span>
                            <span id="subtotalAmt">Rs. 0</span>
                        </div>
                        <div id="discountRow"
                             style="display:none; justify-content:space-between;
                                    margin-bottom:8px; font-size:13px;
                                    color:#198754;">
                            <i class="fas fa-tag" style="margin-right:4px;"></i>
                            <span>Discount:</span>
                            <span id="discountAmt">-Rs. 0</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;
                                    align-items:center; padding-top:8px;
                                    border-top:1px solid #333;">
                            <span style="color:#888; font-size:14px;
                                        font-weight:600;
                                        display:flex; align-items:center;">
                                <i class="fas fa-calculator" style="margin-right:8px; font-size:13px; color:#c8a951;"></i>
                                Total
                            </span>
                            <span id="cartTotal"
                                  style="color:#c8a951; font-size:26px;
                                         font-weight:700;">
                                Rs. 0
                            </span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" form="orderForm"
                            id="placeOrderBtn"
                            disabled
                            style="width:100%; background:#555; color:#fff;
                                   border:none; padding:16px; font-size:12px;
                                   font-weight:700; letter-spacing:3px;
                                   text-transform:uppercase; cursor:not-allowed;
                                   transition:all 0.3s ease; border-radius:4px;">
                        <i class="fas fa-check-circle" style="margin-right:8px;"></i>
                        Place Order
                    </button>

                    <a href="{{ route('menu') }}"
                       style="display:block; text-align:center;
                              color:#888; font-size:12px; margin-top:14px;
                              text-decoration:none;
                              transition:all 0.2s ease;"
                       onmouseover="this.style.color='#c8a951';"
                       onmouseout="this.style.color='#888';">
                        <i class="fas fa-arrow-left" style="margin-right:6px;"></i>
                        Browse Menu
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Ensure Font Awesome is loaded -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@push('scripts')
<script>
let cart     = {};
let total    = 0;
let discount = 0;
let appliedCoupon = '';

// Add item to cart
function addItem(id, name, price) {
    cart[id] = { name, price, qty: 1 };
    document.getElementById('input-id-'+id).value  = id;
    document.getElementById('input-qty-'+id).value = 1;
    document.getElementById('qty-'+id).textContent = 1;
    document.getElementById('add-'+id).style.display     = 'none';
    document.getElementById('qty-ctrl-'+id).style.display = 'flex';
    document.getElementById('card-'+id).style.borderColor = '#c8a951';
    recalculate();
}

// Change quantity
function changeQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) {
        delete cart[id];
        document.getElementById('input-id-'+id).value  = '';
        document.getElementById('input-qty-'+id).value = 0;
        document.getElementById('qty-'+id).textContent = 0;
        document.getElementById('add-'+id).style.display      = 'inline-block';
        document.getElementById('qty-ctrl-'+id).style.display = 'none';
        document.getElementById('card-'+id).style.borderColor = '#2a2a2a';
    } else {
        document.getElementById('input-qty-'+id).value = cart[id].qty;
        document.getElementById('qty-'+id).textContent = cart[id].qty;
    }
    recalculate();
}

// Recalculate totals
function recalculate() {
    total = 0;
    const keys = Object.keys(cart);
    let cartHtml = '';

    keys.forEach(id => {
        const item     = cart[id];
        const subtotal = item.price * item.qty;
        total += subtotal;
        cartHtml += `
            <div style="display:flex; justify-content:space-between;
                         align-items:center; margin-bottom:12px;
                         padding-bottom:12px;
                         border-bottom:1px solid #333;">
                <div>
                    <div style="color:#fff; font-size:13px;
                                font-weight:600;">${item.name}</div>
                    <div style="color:#888; font-size:12px;">
                        <i class="fas fa-times" style="margin-right:4px;"></i>
                        ${item.qty} × Rs.${item.price.toLocaleString()}
                    </div>
                </div>
                <div style="color:#c8a951; font-weight:700; font-size:14px;">
                    Rs.${subtotal.toLocaleString()}
                </div>
            </div>`;
    });

    const emptyDiv = document.getElementById('emptyCart');
    document.getElementById('cartItems').innerHTML =
        emptyDiv.outerHTML + cartHtml;

    const btn = document.getElementById('placeOrderBtn');

    if (keys.length === 0) {
        btn.disabled = true;
        btn.style.background = '#555';
        btn.style.cursor = 'not-allowed';
        discount = 0;
        appliedCoupon = '';
        document.getElementById('couponCode').value = '';
        document.getElementById('discountAmount').value = 0;
        document.getElementById('couponMsg').textContent = '';
        document.getElementById('couponInput').value = '';
    } else {
        btn.disabled = false;
        btn.style.background = '#c8a951';
        btn.style.color = '#000';
        btn.style.cursor = 'pointer';
    }

    updateTotalDisplay();
}

// Update total display
function updateTotalDisplay() {
    const finalTotal = Math.max(0, total - discount);

    document.getElementById('cartTotal').textContent =
        'Rs. ' + finalTotal.toLocaleString();

    if (discount > 0) {
        document.getElementById('subtotalRow').style.display = 'flex';
        document.getElementById('discountRow').style.display = 'flex';
        document.getElementById('subtotalAmt').textContent =
            'Rs. ' + total.toLocaleString();
        document.getElementById('discountAmt').textContent =
            '-Rs. ' + discount.toLocaleString();
    } else {
        document.getElementById('subtotalRow').style.display = 'none';
        document.getElementById('discountRow').style.display = 'none';
    }
}

// Apply coupon
function applyCoupon() {
    const code = document.getElementById('couponInput').value.trim();
    const msg  = document.getElementById('couponMsg');

    if (!code) {
        msg.innerHTML = '<i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>Please enter a coupon code.';
        msg.style.color = '#dc3545';
        return;
    }

    if (total === 0) {
        msg.innerHTML = '<i class="fas fa-info-circle" style="margin-right:6px;"></i>Add items first before applying coupon.';
        msg.style.color = '#ffc107';
        return;
    }

    msg.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i>Checking...';
    msg.style.color = '#888';

    fetch('{{ route("coupon.apply") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: code, total: total })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            discount      = data.discount;
            appliedCoupon = data.code;
            document.getElementById('couponCode').value     = data.code;
            document.getElementById('discountAmount').value = data.discount;
            msg.innerHTML = '<i class="fas fa-check-circle" style="margin-right:6px;"></i>' + data.message;
            msg.style.color = '#198754';
            updateTotalDisplay();
        } else {
            discount = 0;
            document.getElementById('couponCode').value     = '';
            document.getElementById('discountAmount').value = 0;
            msg.innerHTML = '<i class="fas fa-times-circle" style="margin-right:6px;"></i>' + data.message;
            msg.style.color = '#dc3545';
            updateTotalDisplay();
        }
    })
    .catch(() => {
        msg.innerHTML = '<i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>Error checking coupon.';
        msg.style.color = '#dc3545';
    });
}

// Category filter
function filterCategory(catId) {
    document.querySelectorAll('.menu-item-card').forEach(card => {
        card.style.display =
            (catId === 'all' || card.dataset.cat === catId)
            ? 'flex' : 'none';
    });
    document.querySelectorAll('.cat-btn').forEach(btn => {
        btn.style.background  = 'transparent';
        btn.style.color       = '#888';
        btn.style.border      = '1px solid #333';
    });
    const active = document.querySelector(`.cat-btn[data-cat="${catId}"]`);
    if (active) {
        active.style.background = '#c8a951';
        active.style.color      = '#000';
        active.style.border     = '1px solid #c8a951';
    }
}

// Toggle table field
function toggleTable() {
    const type = document.getElementById('orderType').value;
    document.getElementById('tableField').style.display =
        type === 'dine_in' ? 'block' : 'none';
}

// Before submit — disable empty inputs
document.getElementById('orderForm').addEventListener('submit', function(e) {
    if (Object.keys(cart).length === 0) {
        e.preventDefault();
        alert('Please add at least one item!');
        return false;
    }

    // Disable inputs with no value
    document.querySelectorAll('[id^="input-id-"]').forEach(input => {
        if (!input.value) {
            input.disabled = true;
            const num = input.id.replace('input-id-', '');
            const qtyInput = document.getElementById('input-qty-' + num);
            if (qtyInput) qtyInput.disabled = true;
        }
    });
});
</script>
@endpush

@endsection