@extends('layouts.customer')
@section('title', $menuItem->name)

@section('content')
<div style="padding-top:80px; background:#0d0d0d; min-height:100vh;">

    <!-- Header -->
    <div style="background:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),
                url('{{ asset('vendor/thevenue/images/menu.jpg') }}')
                center/cover; padding:70px 0; text-align:center;">
        <small style="color:#c8a951; letter-spacing:3px; font-size:11px;
                      text-transform:uppercase;">
            {{ $menuItem->category->name }}
        </small>
        <h1 style="color:#fff; font-family:'Playfair Display',serif;
                   font-size:48px; font-weight:400; margin-top:10px;">
            {{ $menuItem->name }}
        </h1>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- Back -->
                <a href="{{ route('menu') }}"
                   style="color:#c8a951; text-decoration:none;
                          font-size:13px; display:inline-block;
                          margin-bottom:30px;">
                    ← Back to Menu
                </a>

                <div class="row">

                    <!-- Image -->
                    <div class="col-md-5 mb-4">
                        @if($menuItem->image)
                        <img src="{{ asset('storage/'.$menuItem->image) }}"
                             alt="{{ $menuItem->name }}"
                             style="width:100%; border-radius:4px;
                                    object-fit:cover; max-height:350px;">
                        @else
                        <img src="{{ asset('vendor/thevenue/images/sig_1.jpg') }}"
                             alt="{{ $menuItem->name }}"
                             style="width:100%; border-radius:4px;
                                    object-fit:cover; max-height:350px;">
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="col-md-7 mb-4">
                        <div style="background:#1a1a1a;
                                    border:1px solid #2a2a2a;
                                    padding:35px; height:100%;">

                            <div style="color:#c8a951; font-size:11px;
                                        letter-spacing:3px;
                                        text-transform:uppercase;
                                        margin-bottom:10px;">
                                {{ $menuItem->category->name }}
                            </div>

                            <h2 style="color:#fff;
                                       font-family:'Playfair Display',serif;
                                       font-size:32px; margin-bottom:15px;">
                                {{ $menuItem->name }}
                            </h2>

                            <div style="color:#c8a951; font-size:28px;
                                        font-weight:700; margin-bottom:20px;">
                                Rs.{{ number_format($menuItem->price, 0) }}
                            </div>

                            @if($menuItem->description)
                            <p style="color:#888; font-size:15px;
                                       line-height:1.9; margin-bottom:25px;">
                                {{ $menuItem->description }}
                            </p>
                            @endif

                            <div style="display:flex; gap:10px;
                                        flex-wrap:wrap; margin-bottom:25px;">
                                <span style="background:rgba(200,169,81,0.1);
                                             border:1px solid rgba(200,169,81,0.3);
                                             color:#c8a951; padding:6px 14px;
                                             font-size:11px; letter-spacing:1px;
                                             text-transform:uppercase;">
                                    {{ $menuItem->is_available
                                        ? 'Available' : 'Not Available' }}
                                </span>
                                @if($menuItem->is_featured)
                                <span style="background:rgba(255,193,7,0.1);
                                             border:1px solid rgba(255,193,7,0.3);
                                             color:#ffc107; padding:6px 14px;
                                             font-size:11px; letter-spacing:1px;
                                             text-transform:uppercase;">
                                    Featured
                                </span>
                                @endif
                            </div>

                            <!-- Buttons Container for alignment -->
                            <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
                                @auth
                                <a href="{{ route('customer.order.create') }}"
                                   style="display:inline-block;
                                          background:#c8a951; color:#fff;
                                          padding:14px 40px; font-size:11px;
                                          font-weight:700; letter-spacing:3px;
                                          text-transform:uppercase;
                                          text-decoration:none;">
                                    Order Now
                                </a>
                                @else
                                <a href="{{ route('login') }}"
                                   style="display:inline-block;
                                          border:1px solid #c8a951;
                                          color:#c8a951; padding:14px 40px;
                                          font-size:11px; font-weight:700;
                                          letter-spacing:3px;
                                          text-transform:uppercase;
                                          text-decoration:none;">
                                    Login to Order
                                </a>
                                @endauth

                                @php $wp = \App\Models\Setting::get('whatsapp_number'); @endphp
                                @if($wp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wp) }}
                                         ?text=I want to order: {{ urlencode($menuItem->name) }}"
                                   target="_blank"
                                   style="display:inline-block; background:#25d366;
                                          color:#fff; padding:14px 30px;
                                          font-size:11px; font-weight:700;
                                          letter-spacing:2px; text-transform:uppercase;
                                          text-decoration:none;">
                                    <i class="fab fa-whatsapp me-2"></i>Order via WhatsApp
                                </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Related Items -->
                @if(isset($related) && $related->count())
                <div style="margin-top:50px;">
                    <h4 style="color:#fff;
                               font-family:'Playfair Display',serif;
                               font-size:28px; margin-bottom:25px;">
                        You May Also Like
                    </h4>
                    <div class="row">
                        @foreach($related as $item)
                        <div class="col-md-4 mb-4">
                            <a href="{{ route('menu.show', $item) }}"
                               style="text-decoration:none; display:block;
                                      background:#1a1a1a;
                                      border:1px solid #2a2a2a;
                                      transition:border-color 0.3s;"
                               onmouseover="this.style.borderColor='#c8a951'"
                               onmouseout="this.style.borderColor='#2a2a2a'">
                                @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}"
                                     style="width:100%; height:150px;
                                            object-fit:cover;">
                                @else
                                <img src="{{ asset('vendor/thevenue/images/sig_2.jpg') }}"
                                     style="width:100%; height:150px;
                                            object-fit:cover; opacity:0.6;">
                                @endif
                                <div style="padding:15px;">
                                    <div style="color:#fff; font-weight:600;
                                                margin-bottom:5px;">
                                        {{ $item->name }}
                                    </div>
                                    <div style="color:#c8a951; font-weight:700;">
                                        Rs.{{ number_format($item->price,0) }}
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection