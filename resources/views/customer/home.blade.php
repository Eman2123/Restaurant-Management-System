@extends('layouts.customer')
@section('title', 'The Venue')

@section('content')

{{-- ══ Animation & Effect Styles ══════════════════════════════════════ --}}
<style>
    /* ── Google Fonts ── */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400&family=Raleway:wght@300;400;500;600;700&display=swap');

    /* ── CSS Custom Properties ── */
    :root {
        --gold: #c8a951;
        --gold-dark: #b8943e;
        --gold-light: #d4b86a;
        --dark: #0a0a0a;
        --dark-2: #111111;
        --dark-3: #181818;
        --dark-4: #1e1e1e;
        --text-muted: #777;
        --transition-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        --transition-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* ── Global Reset ── */
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Scroll Reveal Animations ── */
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s var(--transition-smooth),
                    transform 0.8s var(--transition-smooth);
    }
    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal-left {
        opacity: 0;
        transform: translateX(-50px);
        transition: opacity 0.9s var(--transition-smooth),
                    transform 0.9s var(--transition-smooth);
    }
    .reveal-left.visible {
        opacity: 1;
        transform: translateX(0);
    }
    .reveal-right {
        opacity: 0;
        transform: translateX(50px);
        transition: opacity 0.9s var(--transition-smooth),
                    transform 0.9s var(--transition-smooth);
    }
    .reveal-right.visible {
        opacity: 1;
        transform: translateX(0);
    }
    .reveal-scale {
        opacity: 0;
        transform: scale(0.92);
        transition: opacity 0.7s var(--transition-smooth),
                    transform 0.7s var(--transition-bounce);
    }
    .reveal-scale.visible {
        opacity: 1;
        transform: scale(1);
    }

    /* ── Stagger Children ── */
    .stagger-children > * { opacity: 0; transform: translateY(30px); }
    .stagger-children.visible > *:nth-child(1) { animation: fadeUpIn 0.7s var(--transition-smooth) 0.1s forwards; }
    .stagger-children.visible > *:nth-child(2) { animation: fadeUpIn 0.7s var(--transition-smooth) 0.25s forwards; }
    .stagger-children.visible > *:nth-child(3) { animation: fadeUpIn 0.7s var(--transition-smooth) 0.4s forwards; }
    .stagger-children.visible > *:nth-child(4) { animation: fadeUpIn 0.7s var(--transition-smooth) 0.55s forwards; }
    .stagger-children.visible > *:nth-child(5) { animation: fadeUpIn 0.7s var(--transition-smooth) 0.7s forwards; }
    .stagger-children.visible > *:nth-child(6) { animation: fadeUpIn 0.7s var(--transition-smooth) 0.85s forwards; }

    @keyframes fadeUpIn {
        to { opacity: 1; transform: translateY(0); }
    }

    /* ── Hero Animations ── */
    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(50px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes heroLineExpand {
        from { width: 0; }
        to   { width: 60px; }
    }
    @keyframes heroBadgeFade {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes scrollBounce {
        0%, 100% { transform: translateX(-50%) translateY(0); opacity: 0.5; }
        50%       { transform: translateX(-50%) translateY(-12px); opacity: 1; }
    }
    @keyframes particleFloat {
        0%   { transform: translateY(0px) translateX(0px); opacity: 0.3; }
        33%  { transform: translateY(-20px) translateX(10px); opacity: 0.7; }
        66%  { transform: translateY(-10px) translateX(-8px); opacity: 0.4; }
        100% { transform: translateY(0px) translateX(0px); opacity: 0.3; }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    @keyframes rotateSlow {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }
    @keyframes counterUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes borderTrace {
        0%   { clip-path: inset(0 100% 100% 0); }
        25%  { clip-path: inset(0 0 100% 0); }
        50%  { clip-path: inset(0 0 0 0); }
        100% { clip-path: inset(0 0 0 0); }
    }
    @keyframes glowPulse {
        0%, 100% { box-shadow: 0 0 20px rgba(200,169,81,0.2); }
        50%       { box-shadow: 0 0 40px rgba(200,169,81,0.5); }
    }
    @keyframes imagePan {
        0%   { transform: scale(1.05) translateX(0); }
        50%  { transform: scale(1.05) translateX(-15px); }
        100% { transform: scale(1.05) translateX(0); }
    }
    @keyframes lineGrow {
        from { transform: scaleX(0); }
        to   { transform: scaleX(1); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes typewriter {
        from { width: 0; }
        to   { width: 100%; }
    }

    /* ── Cursor Follower ── */
    #cursor-follower {
        width: 40px; height: 40px;
        border: 1px solid rgba(200,169,81,0.6);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.15s ease, opacity 0.3s ease;
        transform: translate(-50%, -50%);
    }
    #cursor-dot {
        width: 5px; height: 5px;
        background: var(--gold);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%);
        transition: opacity 0.3s ease;
    }

    /* ── Particle Canvas ── */
    #particle-canvas {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 1;
    }

    /* ── Gold Shimmer Text ── */
    .gold-shimmer {
        background: linear-gradient(
            90deg,
            var(--gold) 0%,
            #f0d080 30%,
            var(--gold) 50%,
            var(--gold-dark) 70%,
            var(--gold) 100%
        );
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 4s linear infinite;
    }

    /* ── Magnetic Button Effect ── */
    .btn-magnetic {
        position: relative;
        overflow: hidden;
        transition: transform 0.3s var(--transition-bounce),
                    box-shadow 0.3s ease;
    }
    .btn-magnetic::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.08);
        transform: translateX(-100%) skewX(-15deg);
        transition: transform 0.5s ease;
    }
    .btn-magnetic:hover::before { transform: translateX(200%) skewX(-15deg); }

    /* ── Menu Card Tilt ── */
    .menu-card {
        transition: transform 0.4s var(--transition-smooth),
                    box-shadow 0.4s ease;
        transform-style: preserve-3d;
        will-change: transform;
    }
    .menu-card:hover {
        box-shadow: 0 25px 50px rgba(0,0,0,0.6),
                    0 0 30px rgba(200,169,81,0.1);
    }
    .menu-card .card-img-wrap { overflow: hidden; }
    .menu-card .card-img-wrap img {
        transition: transform 0.7s var(--transition-smooth);
    }
    .menu-card:hover .card-img-wrap img { transform: scale(1.08); }

    /* ── Feature Icon Ring ── */
    .feature-icon-ring {
        position: relative;
    }
    .feature-icon-ring::after {
        content: '';
        position: absolute;
        inset: -8px;
        border: 1px solid rgba(200,169,81,0);
        border-radius: 50%;
        transition: all 0.4s ease;
    }
    .feature-icon-ring:hover::after {
        inset: -4px;
        border-color: rgba(200,169,81,0.4);
        animation: glowPulse 2s ease-in-out infinite;
    }

    /* ── Section Divider ── */
    .section-divider {
        width: 60px; height: 1px;
        background: var(--gold);
        margin: 0 auto 15px;
        transform-origin: left center;
        animation: lineGrow 0.8s var(--transition-smooth) 0.3s both;
    }

    /* ── Parallax wrapper ── */
    .parallax-bg {
        will-change: transform;
        transition: transform 0.1s linear;
    }

    /* ── Testimonial Card ── */
    .testimonial-card {
        position: relative;
        overflow: hidden;
        transition: transform 0.4s var(--transition-smooth),
                    border-color 0.4s ease,
                    box-shadow 0.4s ease;
    }
    .testimonial-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 3px; height: 0;
        background: linear-gradient(180deg, var(--gold), transparent);
        transition: height 0.5s ease;
    }
    .testimonial-card:hover::before { height: 100%; }
    .testimonial-card:hover {
        transform: translateY(-8px);
        border-color: rgba(200,169,81,0.3) !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    /* ── Counter Animate ── */
    .counter-num {
        display: inline-block;
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 700;
        color: #000;
    }

    /* ── Loading Screen ── */
    #page-loader {
        position: fixed;
        inset: 0;
        background: #0a0a0a;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        transition: opacity 0.8s ease, visibility 0.8s ease;
    }
    #page-loader.hidden { opacity: 0; visibility: hidden; }
    .loader-logo {
        font-family: 'Playfair Display', serif;
        color: var(--gold);
        font-size: 28px;
        letter-spacing: 6px;
        margin-bottom: 30px;
        animation: fadeIn 0.6s ease 0.2s both;
    }
    .loader-bar-wrap {
        width: 200px; height: 1px;
        background: rgba(255,255,255,0.1);
        overflow: hidden;
    }
    .loader-bar {
        height: 100%;
        background: var(--gold);
        width: 0;
        transition: width 1.5s var(--transition-smooth);
    }

    /* ── Scroll Progress ── */
    #scroll-progress {
        position: fixed;
        top: 0; left: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
        z-index: 9998;
        width: 0%;
        transition: width 0.1s linear;
    }

    /* ── Back to Top ── */
    #back-to-top {
        position: fixed;
        bottom: 35px; right: 35px;
        width: 48px; height: 48px;
        background: var(--gold);
        color: #fff;
        border: none;
        cursor: pointer;
        z-index: 9000;
        display: flex; align-items: center; justify-content: center;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.4s ease, transform 0.4s var(--transition-bounce),
                    background 0.3s ease;
    }
    #back-to-top.show { opacity: 1; transform: translateY(0); }
    #back-to-top:hover { background: var(--gold-dark); transform: translateY(-4px); }

    /* ── Hover Link Underline ── */
    .hover-underline {
        position: relative;
        text-decoration: none;
    }
    .hover-underline::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0;
        width: 0; height: 1px;
        background: var(--gold);
        transition: width 0.3s ease;
    }
    .hover-underline:hover::after { width: 100%; }

    /* ── Section Label Line ── */
    .label-line {
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
    .label-line::before,
    .label-line::after {
        content: '';
        width: 30px; height: 1px;
        background: var(--gold);
        display: block;
    }

    /* ── Image Overlay Hover ── */
    .img-overlay-wrap {
        position: relative;
        overflow: hidden;
    }
    .img-overlay-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            transparent 40%,
            rgba(200,169,81,0.12) 100%
        );
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    .img-overlay-wrap:hover::after { opacity: 1; }

    /* ── Number Ticker ── */
    @keyframes numberBounce {
        0%, 100% { transform: scale(1); }
        50%       { transform: scale(1.1); }
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        #cursor-follower, #cursor-dot { display: none; }
        .hero-title { font-size: 42px !important; }
    }
</style>

{{-- ══ Page Loader ══════════════════════════════════════════════════ --}}
<div id="page-loader">
    <div class="loader-logo">THE VENUE</div>
    <div class="loader-bar-wrap">
        <div class="loader-bar" id="loader-bar"></div>
    </div>
</div>

{{-- ══ Cursor Followers ═══════════════════════════════════════════════ --}}
<div id="cursor-follower"></div>
<div id="cursor-dot"></div>

{{-- ══ Scroll Progress Bar ════════════════════════════════════════════ --}}
<div id="scroll-progress"></div>

{{-- ══ Back to Top ════════════════════════════════════════════════════ --}}
<button id="back-to-top" aria-label="Back to top">
    <i class="fas fa-arrow-up" style="font-size:14px;"></i>
</button>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ HERO SECTION ══════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<section id="hero" style="position:relative; height:100vh; min-height:700px; overflow:hidden;">

    {{-- Background with ken-burns --}}
    <div style="position:absolute; inset:0; overflow:hidden;">
        <div class="parallax-bg" id="hero-bg"
             style="position:absolute; inset:-5%; 
                    background: url('{{ asset('vendor/thevenue/images/main.jpg') }}')
                    center center / cover no-repeat;
                    animation: imagePan 20s ease-in-out infinite;">
        </div>
    </div>

    {{-- Overlay gradient --}}
    <div style="position:absolute; inset:0; z-index:1;
                background: linear-gradient(
                    180deg,
                    rgba(0,0,0,0.3) 0%,
                    rgba(0,0,0,0.55) 50%,
                    rgba(0,0,0,0.8) 100%
                );"></div>

    {{-- Particle Canvas --}}
    <canvas id="particle-canvas"></canvas>

    {{-- Decorative corner lines --}}
    <div style="position:absolute; top:80px; left:40px; z-index:3;
                width:60px; height:60px;
                border-top:1px solid rgba(200,169,81,0.4);
                border-left:1px solid rgba(200,169,81,0.4);
                animation: fadeIn 1.5s ease 1.2s both;">
    </div>
    <div style="position:absolute; top:80px; right:40px; z-index:3;
                width:60px; height:60px;
                border-top:1px solid rgba(200,169,81,0.4);
                border-right:1px solid rgba(200,169,81,0.4);
                animation: fadeIn 1.5s ease 1.4s both;">
    </div>
    <div style="position:absolute; bottom:80px; left:40px; z-index:3;
                width:60px; height:60px;
                border-bottom:1px solid rgba(200,169,81,0.4);
                border-left:1px solid rgba(200,169,81,0.4);
                animation: fadeIn 1.5s ease 1.6s both;">
    </div>
    <div style="position:absolute; bottom:80px; right:40px; z-index:3;
                width:60px; height:60px;
                border-bottom:1px solid rgba(200,169,81,0.4);
                border-right:1px solid rgba(200,169,81,0.4);
                animation: fadeIn 1.5s ease 1.8s both;">
    </div>

    {{-- Hero Content --}}
    <div style="position:relative; z-index:4; height:100%;
                display:flex; align-items:center; justify-content:center;
                text-align:center; color:#fff; padding-top:80px;">
        <div>
            {{-- Pre-heading badge --}}
            <div style="display:inline-flex; align-items:center; gap:12px;
                        border:1px solid rgba(200,169,81,0.35);
                        padding:8px 24px; margin-bottom:30px;
                        animation: heroBadgeFade 1s ease 0.5s both;
                        backdrop-filter: blur(4px);
                        background: rgba(200,169,81,0.06);">
                <span style="width:4px; height:4px; border-radius:50%;
                              background:var(--gold); display:inline-block;
                              animation: glowPulse 2s infinite;"></span>
                <p style="font-family:'Raleway',sans-serif; font-size:11px;
                          letter-spacing:6px; color:var(--gold); margin:0;
                          text-transform:uppercase;">
                    The Venue is
                </p>
                <span style="width:4px; height:4px; border-radius:50%;
                              background:var(--gold); display:inline-block;
                              animation: glowPulse 2s infinite 1s;"></span>
            </div>

            {{-- Main heading --}}
            <h1 class="hero-title"
                style="font-family:'Playfair Display',serif;
                       font-size:78px; font-weight:400; line-height:1.08;
                       margin-bottom:28px;
                       animation: heroFadeUp 1s ease 0.7s both;">
                An Extraordinary<br>
                <em style="font-style:italic; color:var(--gold-light);">Experience</em>
            </h1>

            {{-- Animated divider --}}
            <div style="display:flex; align-items:center; justify-content:center;
                        gap:15px; margin-bottom:28px;
                        animation: heroFadeUp 1s ease 0.9s both;">
                <div style="height:1px; width:40px;
                            background:linear-gradient(90deg,transparent,var(--gold));"></div>
                <i class="fas fa-star" style="color:var(--gold); font-size:8px;"></i>
                <i class="fas fa-star" style="color:var(--gold); font-size:10px;"></i>
                <i class="fas fa-star" style="color:var(--gold); font-size:8px;"></i>
                <div style="height:1px; width:40px;
                            background:linear-gradient(90deg,var(--gold),transparent);"></div>
            </div>

            {{-- Subtitle --}}
            <p style="font-family:'Raleway',sans-serif; font-size:16px;
                      color:rgba(255,255,255,0.7); max-width:480px;
                      margin:0 auto 48px; line-height:1.9; font-weight:300;
                      animation: heroFadeUp 1s ease 1.1s both;">
                Fine dining with fresh ingredients, exquisite flavors
                and an elegant atmosphere
            </p>

            {{-- CTA Buttons --}}
            <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;
                        animation: heroFadeUp 1s ease 1.3s both;">
                <a href="{{ route('menu') }}"
                   class="btn-magnetic"
                   style="display:inline-flex; align-items:center; gap:10px;
                          background:var(--gold); color:#fff;
                          padding:16px 48px; text-decoration:none;
                          font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase;">
                    <i class="fas fa-utensils" style="font-size:12px;"></i> View Menu
                </a>
                @auth
                <a href="{{ route('customer.order.create') }}"
                   class="btn-magnetic"
                   style="display:inline-flex; align-items:center; gap:10px;
                          border:1px solid rgba(255,255,255,0.6); color:#fff;
                          padding:15px 48px; text-decoration:none;
                          font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase; backdrop-filter:blur(4px);">
                    <i class="fas fa-shopping-bag" style="font-size:12px;"></i> Order Now
                </a>
                @else
                <a href="{{ route('reservation.create') }}"
                   class="btn-magnetic"
                   style="display:inline-flex; align-items:center; gap:10px;
                          border:1px solid rgba(255,255,255,0.6); color:#fff;
                          padding:15px 48px; text-decoration:none;
                          font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase; backdrop-filter:blur(4px);">
                    <i class="fas fa-calendar" style="font-size:12px;"></i> Book a Table
                </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div style="position:absolute; bottom:35px; left:50%;
                transform:translateX(-50%); z-index:4; text-align:center;">
        <a href="#features" style="display:flex; flex-direction:column;
                                   align-items:center; gap:8px;
                                   text-decoration:none;
                                   animation: fadeIn 1s ease 2s both;">
            <span style="font-family:'Raleway',sans-serif; font-size:9px;
                         letter-spacing:4px; color:rgba(255,255,255,0.4);
                         text-transform:uppercase;">Scroll</span>
            <div style="width:1px; height:40px;
                        background:linear-gradient(180deg,rgba(200,169,81,0.8),transparent);
                        animation: scrollBounce 2.5s ease-in-out infinite;"></div>
        </a>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ STATS BAR ═══════════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<section style="background:var(--gold); padding:25px 0; overflow:hidden;">
    <div class="container">
        <div class="row text-center stagger-children" id="stats-bar">
            @foreach([
                ['15+', 'Years of Excellence'],
                ['50K+', 'Happy Guests'],
                ['120+', 'Menu Items'],
                ['4.9★', 'Average Rating'],
            ] as $stat)
            <div class="col-6 col-md-3"
                 style="padding:10px; border-right:1px solid rgba(0,0,0,0.1);">
                <div style="font-family:'Playfair Display',serif;
                            font-size:28px; font-weight:700; color:#000;
                            line-height:1;">
                    {{ $stat[0] }}
                </div>
                <div style="font-family:'Raleway',sans-serif; font-size:10px;
                            letter-spacing:2px; text-transform:uppercase;
                            color:rgba(0,0,0,0.65); margin-top:4px;">
                    {{ $stat[1] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ FEATURES BAR ════════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<section id="features" style="background:#111; padding:90px 0;
                               border-bottom:1px solid #1a1a1a;">
    <div class="container">
        <div class="row text-center stagger-children" id="features-row">
            @foreach([
                ['fa-utensils', 'Fine Dining', 'Premium quality food crafted with passion and the finest seasonal ingredients sourced daily.'],
                ['fa-champagne-glasses', 'Special Events', 'Private dining rooms and bespoke event hosting for any special occasion or celebration.'],
                ['fa-motorcycle', 'Fast Delivery', 'Hot and fresh meals delivered directly to your doorstep — fast, reliable, every time.'],
            ] as $feat)
            <div class="col-md-4 mb-5 mb-md-0">
                <div style="padding:40px 30px; border:1px solid transparent;
                            transition: border-color 0.5s ease, background 0.5s ease;
                            cursor:default;"
                     onmouseover="this.style.borderColor='rgba(200,169,81,0.2)';
                                  this.style.background='rgba(200,169,81,0.03)'"
                     onmouseout="this.style.borderColor='transparent';
                                 this.style.background='transparent'">
                    <div class="feature-icon-ring"
                         style="width:80px; height:80px;
                                border:1px solid #2a2a2a; border-radius:50%;
                                display:flex; align-items:center; justify-content:center;
                                margin:0 auto 28px; transition: all 0.4s ease;
                                position:relative;"
                         onmouseover="this.style.borderColor='var(--gold)';
                                      this.style.background='rgba(200,169,81,0.1)';
                                      this.style.transform='scale(1.1) rotate(5deg)'"
                         onmouseout="this.style.borderColor='#2a2a2a';
                                     this.style.background='transparent';
                                     this.style.transform='scale(1) rotate(0deg)'">
                        <i class="fas {{ $feat[0] }}" style="color:var(--gold); font-size:26px;"></i>
                    </div>
                    <h5 style="font-family:'Playfair Display',serif;
                               color:#fff; margin-bottom:14px; font-size:22px;">
                        {{ $feat[1] }}
                    </h5>
                    <p style="color:#666; font-size:14px; line-height:1.9;
                               max-width:280px; margin:0 auto;">
                        {{ $feat[2] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ ABOUT SECTION ══════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:120px 0; background:#0d0d0d; overflow:hidden;">
    <div class="container">
        <div class="row align-items-center">

            {{-- Image column --}}
            <div class="col-lg-6 mb-5 mb-lg-0 reveal-left" id="about-img-col">
                <div style="position:relative;">
                    {{-- Main image --}}
                    <div class="img-overlay-wrap"
                         style="position:relative; overflow:hidden;">
                        <img src="{{ asset('vendor/thevenue/images/about.jpg') }}"
                             alt="About The Venue"
                             style="width:100%; height:540px; object-fit:cover;
                                    display:block; transition:transform 8s ease;"
                             id="about-img">
                    </div>

                    {{-- Decorative frame --}}
                    <div style="position:absolute; top:-15px; left:-15px;
                                width:100%; height:100%;
                                border:1px solid rgba(200,169,81,0.2);
                                pointer-events:none; z-index:0;
                                transition: all 0.5s ease;"
                         id="about-frame"></div>

                    {{-- Years badge --}}
                    <div style="position:absolute; bottom:-25px; right:-20px;
                                background:var(--gold); color:#000;
                                padding:28px; text-align:center; z-index:2;
                                transition: transform 0.4s var(--transition-bounce);"
                         onmouseover="this.style.transform='scale(1.08)'"
                         onmouseout="this.style.transform='scale(1)'">
                        <div class="counter-num" id="years-counter" data-target="15">0</div>
                        <div style="font-size:7px; letter-spacing:3px; text-transform:uppercase;
                                    font-weight:700; margin-top:4px; color:rgba(0,0,0,0.7);">
                            Years<br>of Excellence
                        </div>
                    </div>

                    {{-- Award badge --}}
                    <div style="position:absolute; top:20px; left:-20px;
                                background:#111; border:1px solid rgba(200,169,81,0.3);
                                padding:16px 20px; z-index:2; display:flex;
                                align-items:center; gap:12px;
                                transition: transform 0.4s var(--transition-bounce),
                                            box-shadow 0.4s ease;"
                         onmouseover="this.style.transform='scale(1.05)';
                                      this.style.boxShadow='0 10px 30px rgba(0,0,0,0.5)'"
                         onmouseout="this.style.transform='scale(1)';
                                     this.style.boxShadow='none'">
                        <i class="fas fa-award" style="color:var(--gold); font-size:20px;"></i>
                        <div>
                            <div style="font-family:'Playfair Display',serif;
                                        color:#fff; font-size:13px;">Best Restaurant</div>
                            <div style="font-size:10px; color:#555; letter-spacing:1px;">
                                City Award 2024
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Text column --}}
            <div class="col-lg-6 reveal-right" id="about-text-col"
                 style="padding-left:60px;">
                <p class="label-line"
                   style="color:var(--gold); letter-spacing:4px;
                          font-size:11px; font-family:'Raleway',sans-serif;
                          text-transform:uppercase; margin-bottom:22px;">
                    Our Story
                </p>
                <h2 style="font-family:'Playfair Display',serif;
                            color:#fff; font-size:46px; margin-bottom:28px;
                            line-height:1.15;">
                    A Passion for<br>
                    <span class="gold-shimmer">Great Food</span>
                </h2>
                <div style="width:50px; height:2px; background:var(--gold);
                            margin-bottom:28px; transition: width 0.8s ease;"
                     id="about-line"></div>
                <p style="color:#777; font-size:15px; line-height:2;
                           margin-bottom:22px;">
                    We believe that dining is not just about food — it's
                    about the entire experience. Our chefs craft every dish
                    with care using only the freshest seasonal ingredients.
                </p>
                <p style="color:#777; font-size:15px; line-height:2;
                           margin-bottom:40px;">
                    From intimate dinners to grand celebrations, The Venue
                    provides the perfect setting for every occasion.
                </p>

                {{-- Checklist --}}
                <div style="margin-bottom:40px;">
                    @foreach(['Locally sourced premium ingredients', 'Award-winning executive chef', 'Private dining & events'] as $pt)
                    <div style="display:flex; align-items:center; gap:12px;
                                margin-bottom:12px;">
                        <div style="width:20px; height:20px; background:rgba(200,169,81,0.12);
                                    border:1px solid rgba(200,169,81,0.3);
                                    display:flex; align-items:center; justify-content:center;
                                    flex-shrink:0;">
                            <i class="fas fa-check" style="color:var(--gold); font-size:10px;"></i>
                        </div>
                        <span style="color:#888; font-size:14px;">{{ $pt }}</span>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('menu') }}"
                   class="btn-magnetic"
                   style="display:inline-flex; align-items:center; gap:12px;
                          background:var(--gold); color:#fff; padding:16px 44px;
                          text-decoration:none; font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase;">
                    View Our Menu
                    <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ FEATURED MENU ═══════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
@if($featuredItems->count())
<section style="background:#111; padding:120px 0; overflow:hidden;">
    <div class="container">
        <div class="text-center reveal" id="menu-header" style="margin-bottom:70px;">
            <p class="label-line" style="color:var(--gold); letter-spacing:4px;
                                         font-size:11px; text-transform:uppercase;
                                         margin-bottom:18px; display:inline-flex;">
                Handpicked For You
            </p>
            <h2 style="font-family:'Playfair Display',serif; color:#fff;
                       font-size:46px; margin-bottom:0;">
                Signature <span class="gold-shimmer">Dishes</span>
            </h2>
        </div>

        <div class="row stagger-children" id="menu-cards">
            @foreach($featuredItems as $item)
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="menu-card" style="background:#1a1a1a; overflow:hidden;">

                    {{-- Image --}}
                    @if($item->image)
                    <div class="card-img-wrap" style="position:relative; overflow:hidden;">
                        <img src="{{ asset('storage/'.$item->image) }}"
                             style="width:100%; height:250px; object-fit:cover; display:block;">
                        <div style="position:absolute; inset:0;
                                    background:linear-gradient(180deg,transparent 50%,rgba(0,0,0,0.7));"></div>
                        <div style="position:absolute; top:15px; right:15px;
                                    background:var(--gold); color:#000;
                                    padding:5px 14px; font-family:'Raleway',sans-serif;
                                    font-size:10px; font-weight:700; letter-spacing:2px;
                                    text-transform:uppercase;">
                            {{ $item->category->name }}
                        </div>
                    </div>
                    @else
                    <div style="width:100%; height:250px; background:#181818;
                                display:flex; align-items:center; justify-content:center;
                                position:relative;">
                        <i class="fas fa-bowl-food" style="font-size:50px; color:#2a2a2a;"></i>
                    </div>
                    @endif

                    {{-- Content --}}
                    <div style="padding:28px;">
                        <div style="display:flex; justify-content:space-between;
                                    align-items:flex-start; margin-bottom:12px;">
                            <h5 style="color:#fff; font-family:'Playfair Display',serif;
                                       margin:0; font-size:21px; line-height:1.2;">
                                {{ $item->name }}
                            </h5>
                            <span style="color:var(--gold); font-family:'Raleway',sans-serif;
                                         font-weight:700; font-size:18px;
                                         white-space:nowrap; margin-left:12px;">
                                Rs.{{ number_format($item->price, 0) }}
                            </span>
                        </div>

                        {{-- Rating stars --}}
                        <div style="margin-bottom:12px;">
                            @for($i=0;$i<5;$i++)
                            <i class="fas fa-star" style="color:var(--gold); font-size:10px; margin-right:1px;"></i>
                            @endfor
                        </div>

                        <p style="color:#555; font-size:13px; line-height:1.8;
                                   margin-bottom:20px;">
                            {{ Str::limit($item->description, 90) }}
                        </p>

                        <div style="display:flex; justify-content:space-between;
                                    align-items:center; padding-top:16px;
                                    border-top:1px solid #252525;">
                            <a href="{{ route('menu.show', $item) }}"
                               class="hover-underline"
                               style="color:var(--gold); font-family:'Raleway',sans-serif;
                                      font-size:11px; font-weight:700; letter-spacing:2px;
                                      text-transform:uppercase; text-decoration:none;
                                      display:flex; align-items:center; gap:8px;">
                                View Details
                                <i class="fas fa-arrow-right" style="font-size:9px;
                                   transition:transform 0.3s ease;" id="arrow-{{ $item->id }}"></i>
                            </a>
                            @auth
                            <a href="{{ route('customer.order.create') }}"
                               style="width:36px; height:36px; background:rgba(200,169,81,0.1);
                                      border:1px solid rgba(200,169,81,0.3); color:var(--gold);
                                      display:flex; align-items:center; justify-content:center;
                                      text-decoration:none; transition:all 0.3s ease;"
                               onmouseover="this.style.background='var(--gold)'; this.style.color='#fff'"
                               onmouseout="this.style.background='rgba(200,169,81,0.1)'; this.style.color='var(--gold)'">
                                <i class="fas fa-plus" style="font-size:12px;"></i>
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center reveal" style="margin-top:20px;">
            <a href="{{ route('menu') }}"
               class="btn-magnetic"
               style="display:inline-flex; align-items:center; gap:12px;
                      border:1px solid var(--gold); color:var(--gold);
                      padding:16px 55px; text-decoration:none;
                      font-family:'Raleway',sans-serif; font-size:11px;
                      font-weight:700; letter-spacing:3px; text-transform:uppercase;
                      transition: background 0.3s ease, color 0.3s ease;"
               onmouseover="this.style.background='var(--gold)'; this.style.color='#fff'"
               onmouseout="this.style.background='transparent'; this.style.color='var(--gold)'">
                View Full Menu <i class="fas fa-arrow-right" style="font-size:10px;"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ RESERVATION CTA ════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<section id="reservation-cta"
         style="position:relative; padding:130px 0; text-align:center; overflow:hidden;">

    {{-- Parallax background --}}
    <div class="parallax-bg" id="cta-bg"
         style="position:absolute; inset:-10%;
                background: url('{{ asset('vendor/thevenue/images/reservations.jpg') }}')
                center/cover no-repeat;
                z-index:0;">
    </div>
    <div style="position:absolute; inset:0; z-index:1;
                background:linear-gradient(135deg,rgba(0,0,0,0.82) 0%,rgba(0,0,0,0.6) 100%);"></div>

    {{-- Content --}}
    <div style="position:relative; z-index:2; color:#fff;">
        <div class="reveal" id="cta-content">
            <div style="display:inline-flex; width:64px; height:64px;
                        border:1px solid rgba(200,169,81,0.4); border-radius:50%;
                        align-items:center; justify-content:center; margin-bottom:28px;">
                <i class="fas fa-calendar-check" style="font-size:24px; color:var(--gold);"></i>
            </div>
            <p class="label-line"
               style="color:var(--gold); letter-spacing:5px; font-size:11px;
                      text-transform:uppercase; margin-bottom:22px; display:inline-flex;">
                Plan Your Visit
            </p>
            <h2 style="font-family:'Playfair Display',serif; font-size:56px;
                       font-weight:400; margin-bottom:22px; line-height:1.1;">
                Reserve a <span class="gold-shimmer">Table</span>
            </h2>
            <p style="color:rgba(255,255,255,0.6); font-size:16px;
                      max-width:430px; margin:0 auto 45px; line-height:1.9;
                      font-weight:300;">
                Book your table and enjoy a seamless fine dining experience
            </p>
            <a href="{{ route('reservation.create') }}"
               class="btn-magnetic"
               style="display:inline-flex; align-items:center; gap:12px;
                      background:var(--gold); color:#fff; padding:18px 60px;
                      text-decoration:none; font-family:'Raleway',sans-serif;
                      font-size:11px; font-weight:700; letter-spacing:3px;
                      text-transform:uppercase;">
                <i class="fas fa-phone" style="font-size:12px;"></i> Book Now
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ TESTIMONIALS ═══════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<section style="background:#0d0d0d; padding:120px 0; overflow:hidden;">
    <div class="container">
        <div class="text-center reveal" style="margin-bottom:70px;">
            <p class="label-line"
               style="color:var(--gold); letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:18px; display:inline-flex;">
                What People Say
            </p>
            <h2 style="font-family:'Playfair Display',serif;
                       color:#fff; font-size:46px;">
                Guest <span class="gold-shimmer">Reviews</span>
            </h2>
        </div>
        <div class="row justify-content-center stagger-children" id="testimonials-row">
            @foreach([
                ['Sarah Ahmed', 'Food Critic', 'An extraordinary experience! The food was absolutely divine and the service impeccable. Every detail was attended to with the finest care.'],
                ['Ali Hassan', 'Regular Customer', 'Best restaurant in the city! Every dish was a masterpiece. The ambiance and presentation exceeded all expectations.'],
                ['Maria Khan', 'Event Planner', 'The ambiance is magical and the food is outstanding. Perfect for special occasions — my clients are always impressed.'],
            ] as $review)
            <div class="col-md-4 mb-4">
                <div class="testimonial-card"
                     style="background:#151515; padding:42px 32px;
                            border:1px solid #1e1e1e;">
                    {{-- Stars --}}
                    <div style="margin-bottom:22px;">
                        @for($i=0;$i<5;$i++)
                        <i class="fas fa-star" style="color:var(--gold); font-size:13px; margin-right:2px;"></i>
                        @endfor
                    </div>
                    {{-- Large quote mark --}}
                    <div style="font-family:'Playfair Display',serif;
                                font-size:80px; color:#1e1e1e; line-height:0.5;
                                margin-bottom:22px; user-select:none;">"</div>
                    <p style="color:#777; font-size:14px; line-height:2;
                               font-style:italic; margin-bottom:28px;">
                        {{ $review[2] }}
                    </p>
                    <div style="display:flex; align-items:center; gap:14px;
                                padding-top:20px; border-top:1px solid #1e1e1e;">
                        <div style="width:46px; height:46px; border-radius:50%;
                                    background:rgba(200,169,81,0.1);
                                    border:1px solid rgba(200,169,81,0.3);
                                    display:flex; align-items:center; justify-content:center;
                                    font-family:'Playfair Display',serif;
                                    color:var(--gold); font-size:16px; font-weight:700;">
                            {{ substr($review[0], 0, 1) }}
                        </div>
                        <div>
                            <strong style="color:#fff; display:block; font-size:14px;">{{ $review[0] }}</strong>
                            <small style="color:#444; font-size:11px; letter-spacing:1px;">{{ $review[1] }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- ══ JAVASCRIPT ══════════════════════════════════════════════════════ --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Page Loader ── */
    const loader = document.getElementById('page-loader');
    const loaderBar = document.getElementById('loader-bar');
    loaderBar.style.width = '100%';
    setTimeout(() => { loader.classList.add('hidden'); }, 1800);

    /* ── Custom Cursor ── */
    const cursorFollower = document.getElementById('cursor-follower');
    const cursorDot = document.getElementById('cursor-dot');
    let mouseX = 0, mouseY = 0;
    let followerX = 0, followerY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        cursorDot.style.left = mouseX + 'px';
        cursorDot.style.top = mouseY + 'px';
    });

    function animateCursor() {
        followerX += (mouseX - followerX) * 0.12;
        followerY += (mouseY - followerY) * 0.12;
        cursorFollower.style.left = followerX + 'px';
        cursorFollower.style.top = followerY + 'px';
        requestAnimationFrame(animateCursor);
    }
    animateCursor();

    // Scale cursor on hover over links/buttons
    document.querySelectorAll('a, button, .menu-card').forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursorFollower.style.transform = 'translate(-50%, -50%) scale(1.8)';
            cursorFollower.style.borderColor = 'rgba(200,169,81,0.9)';
        });
        el.addEventListener('mouseleave', () => {
            cursorFollower.style.transform = 'translate(-50%, -50%) scale(1)';
            cursorFollower.style.borderColor = 'rgba(200,169,81,0.6)';
        });
    });

    /* ── Scroll Progress Bar ── */
    const progressBar = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        progressBar.style.width = (scrollTop / docHeight * 100) + '%';
    }, { passive: true });

    /* ── Back to Top Button ── */
    const backBtn = document.getElementById('back-to-top');
    window.addEventListener('scroll', () => {
        backBtn.classList.toggle('show', window.scrollY > 500);
    }, { passive: true });
    backBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    /* ── Scroll Reveal (IntersectionObserver) ── */
    const revealEls = document.querySelectorAll(
        '.reveal, .reveal-left, .reveal-right, .reveal-scale, .stagger-children'
    );
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    revealEls.forEach(el => revealObserver.observe(el));

    /* ── Parallax on Scroll ── */
    const heroBg = document.getElementById('hero-bg');
    const ctaBg = document.getElementById('cta-bg');
    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        if (heroBg) heroBg.style.transform = `translateY(${scrollY * 0.3}px)`;
        if (ctaBg) {
            const ctaSection = document.getElementById('reservation-cta');
            if (ctaSection) {
                const rect = ctaSection.getBoundingClientRect();
                ctaBg.style.transform = `translateY(${-rect.top * 0.2}px)`;
            }
        }
    }, { passive: true });

    /* ── Counter Animation ── */
    function animateCounter(el, target, duration = 1500) {
        let start = 0;
        const step = target / (duration / 16);
        const timer = setInterval(() => {
            start += step;
            if (start >= target) {
                el.textContent = target + '+';
                clearInterval(timer);
            } else {
                el.textContent = Math.floor(start);
            }
        }, 16);
    }

    const counterEl = document.getElementById('years-counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(counterEl, 15);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    if (counterEl) counterObserver.observe(counterEl);

    /* ── Particle System ── */
    const canvas = document.getElementById('particle-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let particles = [];
        let W, H;

        function resizeCanvas() {
            W = canvas.width = canvas.parentElement.offsetWidth;
            H = canvas.height = canvas.parentElement.offsetHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        for (let i = 0; i < 60; i++) {
            particles.push({
                x: Math.random() * W,
                y: Math.random() * H,
                size: Math.random() * 2 + 0.5,
                speedX: (Math.random() - 0.5) * 0.4,
                speedY: (Math.random() - 0.5) * 0.4,
                opacity: Math.random() * 0.4 + 0.1,
                gold: Math.random() > 0.7
            });
        }

        function drawParticles() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fillStyle = p.gold
                    ? `rgba(200,169,81,${p.opacity})`
                    : `rgba(255,255,255,${p.opacity * 0.4})`;
                ctx.fill();
                p.x += p.speedX;
                p.y += p.speedY;
                if (p.x < 0 || p.x > W) p.speedX *= -1;
                if (p.y < 0 || p.y > H) p.speedY *= -1;
            });
            requestAnimationFrame(drawParticles);
        }
        drawParticles();
    }

    /* ── 3D Card Tilt ── */
    document.querySelectorAll('.menu-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / centerY * -6;
            const rotateY = (x - centerX) / centerX * 6;
            card.style.transform =
                `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });

    /* ── Smooth Anchor Scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /* ── About Image Hover Pan ── */
    const aboutImg = document.getElementById('about-img');
    const aboutFrame = document.getElementById('about-frame');
    if (aboutImg) {
        aboutImg.parentElement.addEventListener('mouseenter', () => {
            aboutImg.style.transform = 'scale(1.05)';
            if (aboutFrame) {
                aboutFrame.style.top = '-8px';
                aboutFrame.style.left = '-8px';
                aboutFrame.style.borderColor = 'rgba(200,169,81,0.5)';
            }
        });
        aboutImg.parentElement.addEventListener('mouseleave', () => {
            aboutImg.style.transform = 'scale(1)';
            if (aboutFrame) {
                aboutFrame.style.top = '-15px';
                aboutFrame.style.left = '-15px';
                aboutFrame.style.borderColor = 'rgba(200,169,81,0.2)';
            }
        });
    }

});
</script>

@endsection