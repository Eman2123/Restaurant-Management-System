@extends('layouts.customer')
@section('title', 'My Orders')

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">

    <div class="container py-5">

        <!-- Header -->
        <div class="text-center mb-5">
            <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:15px;
                      display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-history" style="margin-right:10px; font-size:13px;"></i>
                Your History
            </p>
            <h2 style="font-family:'Playfair Display',serif;
                       color:#fff; font-size:42px; font-weight:400;">
                My Orders
            </h2>
        </div>

        @forelse($orders as $order)
        <div style="background:linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
                    border:1px solid #2a2a2a;
                    margin-bottom:20px; padding:25px; border-radius:8px;
                    transition:all 0.3s ease;
                    box-shadow:0 2px 8px rgba(0,0,0,0.3);"
             onmouseover="this.style.borderColor='#c8a951'; this.style.boxShadow='0 8px 24px rgba(200,169,81,0.2)';"
             onmouseout="this.style.borderColor='#2a2a2a'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.3)';">

            <div class="row align-items-center">
                <!-- Order ID & Date -->
                <div class="col-md-3 mb-3 mb-md-0">
                    <div style="color:#c8a951; font-size:11px;
                                letter-spacing:2px; text-transform:uppercase;
                                margin-bottom:6px; font-weight:600;
                                display:flex; align-items:center;">
                        <i class="fas fa-receipt" style="margin-right:8px; font-size:13px;"></i>
                        Order
                    </div>
                    <div style="color:#fff; font-size:24px; font-weight:700;
                                margin-bottom:4px;">
                        #{{ $order->id }}
                    </div>
                    <div style="color:#888; font-size:12px;
                                display:flex; align-items:center;">
                        <i class="fas fa-calendar-alt" style="margin-right:6px; font-size:11px;"></i>
                        {{ $order->created_at->format('d M Y') }}
                    </div>
                    <div style="color:#777; font-size:11px; margin-top:4px;
                                display:flex; align-items:center;">
                        <i class="fas fa-clock" style="margin-right:6px; font-size:11px;"></i>
                        {{ $order->created_at->format('h:i A') }}
                    </div>
                </div>

                <!-- Items -->
                <div class="col-md-3 mb-3 mb-md-0">
                    <div style="color:#c8a951; font-size:11px;
                                letter-spacing:2px; text-transform:uppercase;
                                margin-bottom:8px; font-weight:600;
                                display:flex; align-items:center;">
                        <i class="fas fa-utensils" style="margin-right:8px; font-size:13px;"></i>
                        Items
                    </div>
                    @forelse($order->orderItems->take(3) as $item)
                    <div style="color:#ddd; font-size:13px; margin-bottom:4px;
                                display:flex; align-items:center;">
                        <span style="background:#111; padding:2px 8px;
                                     border-radius:3px; color:#c8a951;
                                     font-weight:600; margin-right:8px;
                                     font-size:11px;">{{ $item->quantity }}x</span>
                        {{ $item->menuItem->name }}
                    </div>
                    @empty
                    <div style="color:#888; font-size:12px;">
                        <i class="fas fa-inbox" style="margin-right:4px;"></i>
                        No items
                    </div>
                    @endforelse
                    @if($order->orderItems->count() > 3)
                    <div style="color:#888; font-size:12px; margin-top:6px;
                                padding-top:6px; border-top:1px solid #333;">
                        <i class="fas fa-ellipsis-h" style="margin-right:4px;"></i>
                        +{{ $order->orderItems->count() - 3 }} more items
                    </div>
                    @endif
                </div>

                <!-- Total -->
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <div style="color:#888; font-size:11px;
                                letter-spacing:2px; text-transform:uppercase;
                                margin-bottom:8px; font-weight:600;
                                display:flex; align-items:center;
                                justify-content:center;">
                        <i class="fas fa-calculator" style="margin-right:6px; font-size:12px;"></i>
                        Total
                    </div>
                    <div style="color:#c8a951; font-size:22px;
                                font-weight:700;">
                        Rs.{{ number_format($order->total_amount, 0) }}
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <div style="color:#888; font-size:11px;
                                letter-spacing:2px; text-transform:uppercase;
                                margin-bottom:8px; font-weight:600;
                                display:flex; align-items:center;
                                justify-content:center;">
                        <i class="fas fa-tag" style="margin-right:6px; font-size:12px;"></i>
                        Status
                    </div>
                    <span style="display:inline-flex; align-items:center; gap:6px;
                                 padding:8px 14px; font-size:11px;
                                 font-weight:700; letter-spacing:1px;
                                 text-transform:uppercase;
                                 border-radius:4px;
                                 background:{{
                                     $order->status === 'served'    ? 'rgba(25,135,84,0.2)' :
                                     ($order->status === 'cooking'  ? 'rgba(253,126,20,0.2)' :
                                     ($order->status === 'ready'    ? 'rgba(13,110,253,0.2)' :
                                     ($order->status === 'cancelled'? 'rgba(220,53,69,0.2)' :
                                      'rgba(255,193,7,0.2)'))) }};
                                 color:{{
                                     $order->status === 'served'    ? '#198754' :
                                     ($order->status === 'cooking'  ? '#fd7e14' :
                                     ($order->status === 'ready'    ? '#0d6efd' :
                                     ($order->status === 'cancelled'? '#dc3545' :
                                      '#ffc107'))) }};
                                 border:1px solid {{
                                     $order->status === 'served'    ? '#198754' :
                                     ($order->status === 'cooking'  ? '#fd7e14' :
                                     ($order->status === 'ready'    ? '#0d6efd' :
                                     ($order->status === 'cancelled'? '#dc3545' :
                                      '#ffc107'))) }};">
                        @if($order->status === 'pending')
                            <i class="fas fa-hourglass-start"></i>
                        @elseif($order->status === 'cooking')
                            <i class="fas fa-fire"></i>
                        @elseif($order->status === 'ready')
                            <i class="fas fa-check-circle"></i>
                        @elseif($order->status === 'served')
                            <i class="fas fa-utensils"></i>
                        @elseif($order->status === 'cancelled')
                            <i class="fas fa-times-circle"></i>
                        @endif
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Actions -->
                <div class="col-md-2 text-center">
                    <a href="{{ route('customer.orders.show', $order) }}"
                       style="display:inline-block; border:1px solid #c8a951;
                              color:#c8a951; padding:10px 18px;
                              text-decoration:none; font-size:11px;
                              font-weight:700; letter-spacing:2px;
                              text-transform:uppercase; transition:all 0.3s;
                              border-radius:4px; cursor:pointer;
                              margin-bottom:8px; width:100%;"
                       onmouseover="this.style.background='#c8a951';
                                    this.style.color='#000';
                                    this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='transparent';
                                   this.style.color='#c8a951';
                                   this.style.transform='translateY(0)';">
                        <i class="fas fa-eye" style="margin-right:6px;"></i>
                        Details
                    </a>
                    
                    @if($order->status === 'served' && !$order->reviews()->where('user_id', auth()->id())->exists())
                    <a href="{{ route('customer.review.create', $order) }}"
                       style="display:inline-block; background:#c8a951;
                              color:#000; padding:8px 14px;
                              text-decoration:none; font-size:10px;
                              font-weight:700; letter-spacing:1px;
                              text-transform:uppercase; border-radius:4px;
                              width:100%; cursor:pointer;
                              transition:all 0.3s;"
                       onmouseover="this.style.background='#d4b86a';
                                    this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='#c8a951';
                                   this.style.transform='translateY(0)';">
                        <i class="fas fa-star" style="margin-right:6px;"></i>
                        Rate Order
                    </a>
                    @endif
                </div>
            </div>

        </div>
        @empty
        <div class="text-center py-5">
            <div style="font-size:64px; margin-bottom:20px; color:#c8a951;">
                <i class="fas fa-inbox"></i>
            </div>
            <h4 style="color:#fff; font-family:'Playfair Display',serif;
                       font-size:28px; font-weight:400; margin-bottom:10px;">
                No Orders Yet
            </h4>
            <p style="color:#888; font-size:15px; margin-bottom:30px;
                      max-width:400px; margin-left:auto; margin-right:auto;">
                You haven't placed any orders yet. Explore our menu and start ordering delicious food!
            </p>
            <a href="{{ route('menu') }}"
               style="display:inline-block; background:#c8a951;
                      color:#000; padding:16px 50px; margin-top:10px;
                      text-decoration:none; font-size:11px;
                      font-weight:700; letter-spacing:3px;
                      text-transform:uppercase; border-radius:4px;
                      transition:all 0.3s; cursor:pointer;
                      border:none;"
               onmouseover="this.style.background='#d4b86a'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(200,169,81,0.3)';"
               onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="fas fa-list" style="margin-right:10px;"></i>
                View Menu
            </a>
        </div>
        @endforelse

    </div>
</div>

<!-- Ensure Font Awesome is loaded -->
@if(!View::hasSection('styles'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endif

@endsection