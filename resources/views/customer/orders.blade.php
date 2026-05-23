@extends('layouts.customer')
@section('title', 'My Orders')

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">

    <div class="container py-5">

        <div class="text-center mb-5">
            <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:15px;">
                Your History
            </p>
            <h2 style="font-family:'Playfair Display',serif;
                       color:#fff; font-size:42px;">
                My Orders
            </h2>
        </div>

        @forelse($orders as $order)
        <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                    margin-bottom:20px; padding:25px;">

            <div class="row align-items-center">
                <div class="col-md-3">
                    <div style="color:#c8a951; font-size:11px;
                                letter-spacing:2px; text-transform:uppercase;">
                        Order
                    </div>
                    <div style="color:#fff; font-size:22px; font-weight:700;">
                        #{{ $order->id }}
                    </div>
                    <div style="color:#888; font-size:12px;">
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="color:#888; font-size:12px;
                                margin-bottom:5px;">Items</div>
                    @foreach($order->orderItems->take(3) as $item)
                    <div style="color:#ccc; font-size:13px;">
                        {{ $item->quantity }}x {{ $item->menuItem->name }}
                    </div>
                    @endforeach
                    @if($order->orderItems->count() > 3)
                    <div style="color:#888; font-size:12px;">
                        +{{ $order->orderItems->count() - 3 }} more
                    </div>
                    @endif
                </div>

                <div class="col-md-2 text-center">
                    <div style="color:#888; font-size:12px;
                                margin-bottom:5px;">Total</div>
                    <div style="color:#c8a951; font-size:20px;
                                font-weight:700;">
                        Rs.{{ number_format($order->total_amount, 0) }}
                    </div>
                </div>

                <div class="col-md-2 text-center">
                    <span style="padding:6px 16px; font-size:11px;
                                 font-weight:700; letter-spacing:1px;
                                 text-transform:uppercase;
                                 background:{{
                                     $order->status === 'served'    ? '#198754' :
                                     ($order->status === 'cooking'  ? '#fd7e14' :
                                     ($order->status === 'ready'    ? '#0d6efd' :
                                     ($order->status === 'cancelled'? '#dc3545' :
                                      '#ffc107'))) }};
                                 color:{{
                                     $order->status === 'pending' ? '#000' : '#fff'
                                 }};">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="col-md-2 text-center">
                    <a href="{{ route('customer.orders.show', $order) }}"
                       style="display:inline-block; border:1px solid #c8a951;
                              color:#c8a951; padding:8px 20px;
                              text-decoration:none; font-size:11px;
                              font-weight:700; letter-spacing:2px;
                              text-transform:uppercase; transition:all 0.3s;"
                       onmouseover="this.style.background='#c8a951';
                                    this.style.color='#000'"
                       onmouseout="this.style.background='transparent';
                                   this.style.color='#c8a951'">
                        Details
                    </a>
                    <br>
                    
                    @if($order->status === 'served' && !$order->reviews()->where('user_id', auth()->id())->exists())
                    <a href="{{ route('customer.review.create', $order) }}"
                       style="display:inline-block; background:#ffc107;
                              color:#000; padding:6px 16px;
                              text-decoration:none; font-size:10px;
                              font-weight:700; letter-spacing:1px;
                              text-transform:uppercase; margin-top:8px;">
                        Rate Order
                    </a>
                    @endif
                </div>
            </div>

        </div>
        @empty
        <div class="text-center py-5">
            <div style="font-size:60px; margin-bottom:20px;">🍽</div>
            <h4 style="color:#fff; font-family:'Playfair Display',serif;">
                No Orders Yet
            </h4>
            <p style="color:#888;">
                You haven't placed any orders yet.
            </p>
            <a href="{{ route('menu') }}"
               style="display:inline-block; background:#c8a951;
                      color:#fff; padding:14px 40px; margin-top:20px;
                      text-decoration:none; font-size:11px;
                      font-weight:700; letter-spacing:3px;
                      text-transform:uppercase;">
                View Menu
            </a>
        </div>
        @endforelse

    </div>
</div>
@endsection