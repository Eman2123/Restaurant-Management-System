@extends('layouts.customer')
@section('title', 'Order #' . $order->id)

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Header -->
                <div class="d-flex justify-content-between
                            align-items-center mb-4">
                    <a href="{{ route('customer.orders') }}"
                       style="color:#c8a951; text-decoration:none;
                              font-size:13px;">
                        ← Back to Orders
                    </a>
                    <small style="color:#888;">
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
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:30px; margin-bottom:25px;">
                    <h5 style="color:#c8a951; font-size:11px;
                                letter-spacing:3px; text-transform:uppercase;
                                margin-bottom:25px; text-align:center;">
                        Order Status
                    </h5>

                    <div style="display:flex; align-items:center;
                                justify-content:center; position:relative;">

                        @foreach($steps as $i => $step)

                        <!-- Step Circle -->
                        <div style="text-align:center; position:relative;
                                    z-index:2;">
                            <div style="width:50px; height:50px;
                                        border-radius:50%;
                                        background:{{ $i <= $currentStep ? '#c8a951' : '#2a2a2a' }};
                                        border:2px solid {{ $i <= $currentStep ? '#c8a951' : '#333' }};
                                        display:flex; align-items:center;
                                        justify-content:center;
                                        margin:0 auto 8px;
                                        transition:all 0.5s;">
                                @if($i < $currentStep)
                                    <span style="color:#fff; font-size:18px;">✓</span>
                                @elseif($i === $currentStep)
                                    <span style="color:#fff; font-size:18px;">
                                        @if($step === 'pending') ⏳
                                        @elseif($step === 'cooking') 🔥
                                        @elseif($step === 'ready') ✅
                                        @else 🍽
                                        @endif
                                    </span>
                                @else
                                    <span style="color:#555; font-size:16px;">○</span>
                                @endif
                            </div>
                            <div style="color:{{ $i <= $currentStep ? '#fff' : '#555' }};
                                         font-size:11px; letter-spacing:1px;
                                         text-transform:uppercase;
                                         font-weight:{{ $i === $currentStep ? '700' : '400' }};">
                                {{ ucfirst($step) }}
                            </div>
                        </div>

                        <!-- Connector Line -->
                        @if($i < count($steps) - 1)
                        <div style="flex:1; height:2px;
                                    background:{{ $i < $currentStep ? '#c8a951' : '#2a2a2a' }};
                                    margin:0 5px; margin-bottom:25px;
                                    transition:background 0.5s;">
                        </div>
                        @endif

                        @endforeach
                    </div>
                </div>
                @else
                <div style="background:rgba(220,53,69,0.1);
                            border:1px solid rgba(220,53,69,0.3);
                            padding:20px; margin-bottom:25px;
                            text-align:center;">
                    <span style="color:#dc3545; font-size:16px;
                                 font-weight:600;">
                        Order Cancelled
                    </span>
                </div>
                @endif

                <!-- Order Info -->
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:25px; margin-bottom:20px;">
                    <h4 style="color:#fff;
                                font-family:'Playfair Display',serif;
                                margin-bottom:20px; font-size:22px;">
                        Order #{{ $order->id }}
                    </h4>
                    <div class="row" style="color:#888; font-size:14px;">
                        <div class="col-md-4 mb-3">
                            <div style="color:#c8a951; font-size:11px;
                                        letter-spacing:2px;
                                        text-transform:uppercase;
                                        margin-bottom:5px;">
                                Table
                            </div>
                            {{ $order->table
                                ? 'Table #'.$order->table->table_number
                                : 'Takeaway' }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="color:#c8a951; font-size:11px;
                                        letter-spacing:2px;
                                        text-transform:uppercase;
                                        margin-bottom:5px;">
                                Type
                            </div>
                            {{ ucfirst(str_replace('_',' ',
                               $order->order_type)) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="color:#c8a951; font-size:11px;
                                        letter-spacing:2px;
                                        text-transform:uppercase;
                                        margin-bottom:5px;">
                                Payment
                            </div>
                            <span style="color:{{ $order->payment_status === 'paid' ? '#198754' : '#ffc107' }};">
                                {{ ucfirst($order->payment_status) }}
                                — {{ ucfirst($order->payment_method) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:25px; margin-bottom:20px;">
                    <h5 style="color:#c8a951; font-size:11px;
                                letter-spacing:3px; text-transform:uppercase;
                                margin-bottom:20px;">
                        Items Ordered
                    </h5>

                    @foreach($order->orderItems as $item)
                    <div style="display:flex; justify-content:space-between;
                                align-items:center; padding:12px 0;
                                border-bottom:1px solid #2a2a2a;">
                        <div>
                            <div style="color:#fff; font-size:15px;
                                        font-weight:500;">
                                {{ $item->menuItem->name }}
                            </div>
                            @if($item->special_instructions)
                            <div style="color:#888; font-size:12px;">
                                Note: {{ $item->special_instructions }}
                            </div>
                            @endif
                        </div>
                        <div style="text-align:right;">
                            <div style="color:#888; font-size:13px;">
                                {{ $item->quantity }} ×
                                Rs.{{ number_format($item->unit_price,0) }}
                            </div>
                            <div style="color:#c8a951; font-weight:700;">
                                Rs.{{ number_format($item->subtotal,0) }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div style="display:flex; justify-content:space-between;
                                align-items:center; padding-top:20px;">
                        <span style="color:#fff; font-size:16px;
                                     font-weight:600;">
                            Total
                        </span>
                        <span style="color:#c8a951; font-size:26px;
                                     font-weight:700;">
                            Rs.{{ number_format($order->total_amount,0) }}
                        </span>
                    </div>
                </div>

                @if($order->notes)
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:20px; margin-bottom:20px;">
                    <div style="color:#c8a951; font-size:11px;
                                letter-spacing:2px; text-transform:uppercase;
                                margin-bottom:8px;">
                        Special Notes
                    </div>
                    <p style="color:#888; margin:0;">{{ $order->notes }}</p>
                </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('customer.order.create') }}"
                       style="display:inline-block; background:#c8a951;
                              color:#fff; padding:14px 50px;
                              text-decoration:none; font-size:11px;
                              font-weight:700; letter-spacing:3px;
                              text-transform:uppercase;">
                        Order Again
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection