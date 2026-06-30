@extends('layouts.customer')
@section('title', 'Order #' . $order->id)

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Header -->
                <div style="display:flex; justify-content:space-between;
                            align-items:center; margin-bottom:30px;
                            flex-wrap:wrap; gap:15px;">
                    <a href="{{ route('customer.orders') }}"
                       style="color:#c8a951; text-decoration:none;
                              font-size:13px; font-weight:600;
                              letter-spacing:1px;
                              transition:all 0.2s ease;
                              display:flex; align-items:center;"
                       onmouseover="this.style.color='#d4b86a'; this.style.transform='translateX(-4px)';"
                       onmouseout="this.style.color='#c8a951'; this.style.transform='translateX(0)';">
                        <i class="fas fa-arrow-left" style="margin-right:8px;"></i>
                        Back to Orders
                    </a>
                    <small style="color:#888; display:flex; align-items:center;">
                        <i class="fas fa-clock" style="margin-right:8px; color:#c8a951;"></i>
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </small>
                </div>

                <!-- Order Tracking Bar -->
                @php
                    $steps = ['pending','cooking','ready','served'];
                    $currentStep = array_search($order->status, $steps);
                    if($order->status === 'cancelled') $currentStep = -1;
                @endphp

                @if($order->status !== 'cancelled')
                <div style="background:linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
                            border:1px solid #2a2a2a;
                            padding:35px; margin-bottom:30px;
                            border-radius:8px;">
                    <h5 style="color:#c8a951; font-size:11px;
                                letter-spacing:3px; text-transform:uppercase;
                                margin-bottom:30px; text-align:center;
                                font-weight:600;
                                display:flex; align-items:center;
                                justify-content:center;">
                        <i class="fas fa-tasks" style="margin-right:10px;"></i>
                        Order Status
                    </h5>

                    <div style="display:flex; align-items:center;
                                justify-content:center; position:relative;">

                        @foreach($steps as $i => $step)

                        <!-- Step Circle -->
                        <div style="text-align:center; position:relative;
                                    z-index:2;">
                            <div style="width:60px; height:60px;
                                        border-radius:50%;
                                        background:{{ $i <= $currentStep ? '#c8a951' : '#111' }};
                                        border:2px solid {{ $i <= $currentStep ? '#c8a951' : '#333' }};
                                        display:flex; align-items:center;
                                        justify-content:center;
                                        margin:0 auto 12px;
                                        transition:all 0.5s ease;
                                        box-shadow:{{ $i === $currentStep ? '0 0 20px rgba(200,169,81,0.4)' : 'none' }};">
                                @if($i < $currentStep)
                                    <i class="fas fa-check" style="color:#000; font-size:22px;"></i>
                                @elseif($i === $currentStep)
                                    @if($step === 'pending')
                                        <i class="fas fa-hourglass-start" style="color:#000; font-size:22px;"></i>
                                    @elseif($step === 'cooking')
                                        <i class="fas fa-fire" style="color:#000; font-size:22px;"></i>
                                    @elseif($step === 'ready')
                                        <i class="fas fa-check-circle" style="color:#000; font-size:22px;"></i>
                                    @else
                                        <i class="fas fa-utensils" style="color:#000; font-size:22px;"></i>
                                    @endif
                                @else
                                    <i class="fas fa-circle" style="color:#555; font-size:12px;"></i>
                                @endif
                            </div>
                            <div style="color:{{ $i <= $currentStep ? '#c8a951' : '#555' }};
                                         font-size:11px; letter-spacing:1px;
                                         text-transform:uppercase;
                                         font-weight:{{ $i === $currentStep ? '700' : '400' }};
                                         transition:all 0.3s ease;">
                                {{ ucfirst($step) }}
                            </div>
                        </div>

                        <!-- Connector Line -->
                        @if($i < count($steps) - 1)
                        <div style="flex:1; height:3px;
                                    background:{{ $i < $currentStep ? '#c8a951' : '#333' }};
                                    margin:0 8px; margin-bottom:28px;
                                    transition:background 0.5s ease;
                                    border-radius:2px;">
                        </div>
                        @endif

                        @endforeach
                    </div>
                </div>
                @else
                <div style="background:rgba(220,53,69,0.15);
                            border-left:4px solid #dc3545;
                            padding:20px 22px; margin-bottom:30px;
                            border-radius:4px;
                            display:flex; align-items:center;">
                    <i class="fas fa-times-circle" style="color:#dc3545; font-size:24px; margin-right:15px;"></i>
                    <span style="color:#dc3545; font-size:15px;
                                 font-weight:600;">
                        This order has been cancelled
                    </span>
                </div>
                @endif

                <!-- Order Info -->
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:30px; margin-bottom:25px; border-radius:8px;">
                    <div style="display:flex; align-items:center; margin-bottom:25px;">
                        <i class="fas fa-receipt" style="color:#c8a951; font-size:24px; margin-right:12px;"></i>
                        <h4 style="color:#fff;
                                    font-family:'Playfair Display',serif;
                                    margin:0; font-size:26px; font-weight:400;">
                            Order #{{ $order->id }}
                        </h4>
                    </div>
                    <div class="row" style="color:#888; font-size:14px;">
                        <div class="col-md-4 mb-3">
                            <div style="color:#c8a951; font-size:11px;
                                        letter-spacing:2px;
                                        text-transform:uppercase;
                                        margin-bottom:8px; font-weight:600;
                                        display:flex; align-items:center;">
                                <i class="fas fa-chair" style="margin-right:6px; font-size:13px;"></i>
                                Table
                            </div>
                            <div style="color:#ddd;">
                                @if($order->table)
                                    <i class="fas fa-home" style="margin-right:4px; color:#c8a951;"></i>
                                    Table #{{ $order->table->table_number }}
                                @else
                                    <i class="fas fa-shopping-bag" style="margin-right:4px; color:#c8a951;"></i>
                                    Takeaway
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="color:#c8a951; font-size:11px;
                                        letter-spacing:2px;
                                        text-transform:uppercase;
                                        margin-bottom:8px; font-weight:600;
                                        display:flex; align-items:center;">
                                <i class="fas fa-list" style="margin-right:6px; font-size:13px;"></i>
                                Type
                            </div>
                            <div style="color:#ddd;">
                                {{ ucfirst(str_replace('_',' ',
                                   $order->order_type)) }}
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="color:#c8a951; font-size:11px;
                                        letter-spacing:2px;
                                        text-transform:uppercase;
                                        margin-bottom:8px; font-weight:600;
                                        display:flex; align-items:center;">
                                <i class="fas fa-credit-card" style="margin-right:6px; font-size:13px;"></i>
                                Payment
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="color:{{ $order->payment_status === 'paid' ? '#198754' : '#ffc107' }};
                                             font-weight:600;">
                                    @if($order->payment_status === 'paid')
                                        <i class="fas fa-check-circle" style="margin-right:4px;"></i>
                                    @else
                                        <i class="fas fa-clock" style="margin-right:4px;"></i>
                                    @endif
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                <span style="color:#888; font-size:12px;">
                                    ({{ ucfirst($order->payment_method) }})
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:30px; margin-bottom:25px; border-radius:8px;">
                    <h5 style="color:#c8a951; font-size:11px;
                                letter-spacing:3px; text-transform:uppercase;
                                margin-bottom:25px; font-weight:600;
                                display:flex; align-items:center;">
                        <i class="fas fa-utensils" style="margin-right:10px; font-size:14px;"></i>
                        Items Ordered
                    </h5>

                    @forelse($order->orderItems as $item)
                    <div style="display:flex; justify-content:space-between;
                                align-items:flex-start; padding:16px 0;
                                border-bottom:1px solid #2a2a2a;
                                transition:all 0.2s ease;"
                         onmouseover="this.style.background='rgba(200,169,81,0.05)'; this.style.paddingLeft='8px'; this.style.paddingRight='8px'; this.style.borderRadius='4px';"
                         onmouseout="this.style.background='transparent'; this.style.paddingLeft='0'; this.style.paddingRight='0';">
                        <div style="flex:1;">
                            <div style="color:#fff; font-size:15px;
                                        font-weight:500; margin-bottom:6px;">
                                {{ $item->menuItem->name }}
                            </div>
                            @if($item->special_instructions)
                            <div style="color:#888; font-size:12px;
                                        display:flex; align-items:flex-start;">
                                <i class="fas fa-sticky-note" style="margin-right:6px; margin-top:2px; flex-shrink:0; font-size:11px;"></i>
                                <span>{{ $item->special_instructions }}</span>
                            </div>
                            @endif
                        </div>
                        <div style="text-align:right; margin-left:20px; flex-shrink:0;">
                            <div style="color:#888; font-size:13px; margin-bottom:4px;">
                                <span style="background:#111; padding:4px 8px; border-radius:3px;
                                            border:1px solid #333;">
                                    {{ $item->quantity }} ×
                                </span>
                                Rs.{{ number_format($item->unit_price,0) }}
                            </div>
                            <div style="color:#c8a951; font-weight:700; font-size:15px;">
                                Rs.{{ number_format($item->subtotal,0) }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center; color:#888; padding:20px;">
                        <i class="fas fa-inbox" style="font-size:24px; margin-bottom:10px; display:block;"></i>
                        No items in this order
                    </div>
                    @endforelse

                    <div style="display:flex; justify-content:space-between;
                                align-items:center; padding-top:25px;
                                margin-top:15px; border-top:2px solid #2a2a2a;">
                        <span style="color:#fff; font-size:16px;
                                     font-weight:600;
                                     display:flex; align-items:center;">
                            <i class="fas fa-calculator" style="margin-right:10px; color:#c8a951;"></i>
                            Total
                        </span>
                        <span style="color:#c8a951; font-size:28px;
                                     font-weight:700;">
                            Rs.{{ number_format($order->total_amount,0) }}
                        </span>
                    </div>
                </div>

                @if($order->notes)
                <div style="background:rgba(200,169,81,0.08);
                            border:1px solid rgba(200,169,81,0.3);
                            border-left:4px solid #c8a951;
                            padding:20px 22px; margin-bottom:30px;
                            border-radius:4px;">
                    <div style="color:#c8a951; font-size:11px;
                                letter-spacing:2px; text-transform:uppercase;
                                margin-bottom:10px; font-weight:600;
                                display:flex; align-items:center;">
                        <i class="fas fa-note-sticky" style="margin-right:8px;"></i>
                        Special Notes
                    </div>
                    <p style="color:#bbb; margin:0; line-height:1.6;">
                        {{ $order->notes }}
                    </p>
                </div>
                @endif

                <div style="text-align:center; margin-top:35px;">
                    <a href="{{ route('customer.order.create') }}"
                       style="display:inline-block; background:#c8a951;
                              color:#000; padding:16px 50px;
                              text-decoration:none; font-size:11px;
                              font-weight:700; letter-spacing:3px;
                              text-transform:uppercase; border-radius:4px;
                              transition:all 0.3s ease; cursor:pointer;
                              border:none;"
                       onmouseover="this.style.background='#d4b86a'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(200,169,81,0.3)';"
                       onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fas fa-plus-circle" style="margin-right:10px;"></i>
                        Order Again
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Ensure Font Awesome is loaded -->
@if(!View::hasSection('styles'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endif

@endsection