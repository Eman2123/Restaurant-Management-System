@extends('layouts.customer')
@section('title', $menuItem->name)

@push('styles')
<style>
    /* ── Page base ── */
    .item-page {
        padding-top: 80px;
        background: #0d0d0d;
        min-height: 100vh;
        font-family: 'Raleway', sans-serif;
    }

    /* ── Hero ── */
    .item-hero {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                    url('{{ asset('vendor/thevenue/images/menu.jpg') }}') center/cover;
        padding: 70px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .item-hero::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #c8a951, transparent);
    }
    .item-hero small {
        color: #c8a951;
        letter-spacing: 3px;
        font-size: 11px;
        text-transform: uppercase;
        display: block;
        margin-bottom: 10px;
        opacity: 0;
        transform: translateY(10px);
        animation: fadeUp 0.6s ease forwards 0.1s;
    }
    .item-hero h1 {
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 48px;
        font-weight: 400;
        margin-top: 10px;
        opacity: 0;
        transform: translateY(14px);
        animation: fadeUp 0.7s ease forwards 0.25s;
    }

    /* ── Keyframes ── */
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; } to { opacity: 1; }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position:  200% center; }
    }

    /* ── Back link ── */
    .back-link {
        color: #c8a951;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 30px;
        transition: gap 0.25s, opacity 0.2s, color 0.3s;
        opacity: 0;
        animation: fadeIn 0.5s ease forwards 0.4s;
    }
    .back-link:hover { 
        gap: 12px; 
        opacity: 0.8; 
        color: #d4b86a;
    }
    .back-link i { transition: transform 0.25s; }
    .back-link:hover i { transform: translateX(-4px); }

    /* ── Item image ── */
    .item-img-wrap {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        opacity: 0;
        animation: slideInLeft 0.7s ease forwards 0.5s;
        border: 1px solid #2a2a2a;
        transition: border-color 0.3s;
    }
    .item-img-wrap:hover {
        border-color: #c8a951;
    }
    .item-img-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(200,169,81,0.12) 0%, transparent 60%);
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.4s;
    }
    .item-img-wrap:hover::after { opacity: 1; }
    .item-img {
        width: 100%;
        border-radius: 8px;
        object-fit: cover;
        max-height: 400px;
        display: block;
        transition: transform 0.5s ease;
    }
    .item-img-wrap:hover .item-img { transform: scale(1.04); }

    /* ── Detail card ── */
    .detail-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        padding: 40px;
        height: 100%;
        position: relative;
        opacity: 0;
        animation: slideInRight 0.7s ease forwards 0.5s;
        transition: border-color 0.3s;
        border-radius: 8px;
    }
    .detail-card:hover { 
        border-color: #3a3a3a;
    }
    .detail-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #c8a951, transparent);
        transform: scaleX(0);
        transition: transform 0.5s ease;
        border-radius: 8px 8px 0 0;
    }
    .detail-card:hover::before { transform: scaleX(1); }

    /* ── Category label ── */
    .detail-category {
        color: #c8a951;
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 10px;
        font-weight: 600;
    }

    /* ── Item name ── */
    .detail-name {
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 400;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    /* ── Price ── */
    .detail-price {
        color: #c8a951;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 25px;
        display: inline-block;
        background: linear-gradient(90deg, #c8a951, #e8c96a, #c8a951);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }

    /* ── Description ── */
    .detail-desc {
        color: #999;
        font-size: 15px;
        line-height: 1.9;
        margin-bottom: 30px;
    }

    /* ── Badges ── */
    .badge-wrap { 
        display: flex; 
        gap: 12px; 
        flex-wrap: wrap; 
        margin-bottom: 30px; 
    }
    .badge {
        padding: 8px 16px;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 4px;
        font-weight: 600;
    }
    .badge:hover { 
        transform: translateY(-2px);
    }
    .badge-available {
        background: rgba(25,135,84,0.15);
        border: 1px solid rgba(25,135,84,0.3);
        color: #198754;
    }
    .badge-unavailable {
        background: rgba(220,53,69,0.15);
        border: 1px solid rgba(220,53,69,0.3);
        color: #dc3545;
    }
    .badge-featured {
        background: rgba(255,193,7,0.15);
        border: 1px solid rgba(255,193,7,0.3);
        color: #ffc107;
    }

    /* ── Buttons ── */
    .btn-wrap { 
        display: flex; 
        align-items: center; 
        flex-wrap: wrap; 
        gap: 12px; 
    }

    .btn-order {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #c8a951;
        color: #fff;
        padding: 14px 40px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        text-decoration: none;
        position: relative;
        overflow: hidden;
        transition: color 0.3s;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-family: 'Raleway', sans-serif;
    }
    .btn-order::before {
        content: '';
        position: absolute;
        inset: 0;
        background: #b8943e;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
        z-index: 0;
    }
    .btn-order:hover::before { transform: scaleX(1); }
    .btn-order:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(200,169,81,0.3);
    }
    .btn-order span, .btn-order i { 
        position: relative; 
        z-index: 1; 
    }

    .btn-login {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #c8a951;
        color: #c8a951;
        padding: 14px 40px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        text-decoration: none;
        transition: background 0.3s, color 0.3s, transform 0.2s;
        border-radius: 4px;
        font-family: 'Raleway', sans-serif;
    }
    .btn-login:hover { 
        background: #c8a951; 
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-whatsapp {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25d366;
        color: #fff;
        padding: 14px 30px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-decoration: none;
        transition: background 0.25s, transform 0.2s;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-family: 'Raleway', sans-serif;
    }
    .btn-whatsapp:hover { 
        background: #1fb558; 
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37,211,102,0.3);
    }

    /* ── Related section ── */
    .related-title {
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 400;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }
    .related-title::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 50px;
        height: 2px;
        background: #c8a951;
        transition: width 0.4s ease;
    }
    .related-title:hover::after { width: 120px; }

    .related-card {
        text-decoration: none;
        display: block;
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        overflow: hidden;
        transition: border-color 0.3s, transform 0.3s;
        opacity: 0;
        animation: fadeUp 0.6s ease forwards;
        border-radius: 8px;
    }
    .related-card:hover {
        border-color: #c8a951;
        transform: translateY(-6px);
    }
    .related-card-img-wrap { 
        overflow: hidden;
        position: relative;
        height: 180px;
    }
    .related-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    .related-card:hover img { transform: scale(1.08); }

    .related-info { 
        padding: 18px; 
    }
    .related-info .name {
        color: #fff;
        font-weight: 600;
        margin-bottom: 8px;
        transition: color 0.2s;
        font-family: 'Playfair Display', serif;
        font-size: 16px;
    }
    .related-card:hover .related-info .name { color: #c8a951; }
    .related-info .price { 
        color: #c8a951; 
        font-weight: 700;
        font-size: 16px;
    }
</style>
@endpush

@section('content')
<div class="item-page">

    {{-- Hero --}}
    <div class="item-hero">
        <small>{{ $menuItem->category->name }}</small>
        <h1>{{ $menuItem->name }}</h1>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                {{-- Back --}}
                <a href="{{ route('menu') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Menu
                </a>

                <div class="row">

                    {{-- Image --}}
                    <div class="col-md-5 mb-4">
                        <div class="item-img-wrap">
                            @if($menuItem->image)
                                <img src="{{ asset('storage/'.$menuItem->image) }}"
                                     alt="{{ $menuItem->name }}" class="item-img">
                            @else
                                <div style="width:100%; height:300px; background:#222;
                                           display:flex; align-items:center;
                                           justify-content:center;">
                                    <i class="fas fa-image" style="font-size:48px; color:#444;"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="col-md-7 mb-4">
                        <div class="detail-card">

                            <div class="detail-category">
                                <i class="fas fa-tag" style="margin-right:6px;"></i>
                                {{ $menuItem->category->name }}
                            </div>

                            <h2 class="detail-name">{{ $menuItem->name }}</h2>

                            <div class="detail-price">
                                Rs.{{ number_format($menuItem->price, 0) }}
                            </div>

                            @if($menuItem->description)
                                <p class="detail-desc">{{ $menuItem->description }}</p>
                            @endif

                            <div class="badge-wrap">
                                <span class="badge {{ $menuItem->is_available ? 'badge-available' : 'badge-unavailable' }}">
                                    <i class="fas {{ $menuItem->is_available ? 'fa-check-circle' : 'fa-times-circle' }}" style="margin-right:6px;"></i>
                                    {{ $menuItem->is_available ? 'Available Now' : 'Currently Unavailable' }}
                                </span>
                                @if($menuItem->is_featured)
                                    <span class="badge badge-featured">
                                        <i class="fas fa-star" style="margin-right:6px;"></i>
                                        Featured Dish
                                    </span>
                                @endif
                            </div>

                            <div class="btn-wrap">
                                @auth
                                    <a href="{{ route('customer.order.create') }}" class="btn-order">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Order Now</span>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login to Order
                                    </a>
                                @endauth

                                @php $wp = \App\Models\Setting::get('whatsapp_number'); @endphp
                                @if($wp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wp) }}?text={{ urlencode('I want to order: '.$menuItem->name.' - Rs.'.$menuItem->price) }}"
                                       target="_blank"
                                       class="btn-whatsapp">
                                        <i class="fab fa-whatsapp"></i>Order via WhatsApp
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Related Items --}}
                @if(isset($related) && $related->count())
                    <div style="margin-top:60px; padding-top:40px;
                                border-top:1px solid #2a2a2a;">
                        <h4 class="related-title">You May Also Like</h4>
                        <div class="row">
                            @foreach($related as $i => $item)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ route('menu.show', $item) }}"
                                       class="related-card"
                                       style="animation-delay: {{ $i * 0.1 + 0.3 }}s;">
                                        <div class="related-card-img-wrap">
                                            @if($item->image)
                                                <img src="{{ asset('storage/'.$item->image) }}"
                                                     alt="{{ $item->name }}">
                                            @else
                                                <div style="width:100%; height:100%; background:#222;
                                                           display:flex; align-items:center;
                                                           justify-content:center;">
                                                    <i class="fas fa-image" style="font-size:32px; color:#444;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="related-info">
                                            <div class="name">{{ $item->name }}</div>
                                            <div class="price">Rs.{{ number_format($item->price, 0) }}</div>
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