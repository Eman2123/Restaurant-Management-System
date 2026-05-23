@extends('layouts.customer')
@section('title', 'The Venue Restaurant')

@section('content')

<!-- ══ Hero Section ════════════════════════════════════════ -->
<section style="position:relative; height:100vh; min-height:700px;
                background: url('{{ asset('vendor/thevenue/images/main.jpg') }}')
                center center / cover no-repeat;">
    <div style="position:absolute; inset:0;
                background:linear-gradient(180deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.7) 100%);"></div>
    <div style="position:relative; z-index:2; height:100%;
                display:flex; align-items:center; justify-content:center;
                text-align:center; color:#fff; padding-top:80px;">
        <div style="animation: fadeUp 1s ease-out;">
            <div style="display:inline-block; border:1px solid rgba(200,169,81,0.4);
                        padding:8px 24px; margin-bottom:25px;">
                <p style="font-family:'Raleway',sans-serif; font-size:12px;
                          letter-spacing:5px; color:#c8a951; margin:0;
                          text-transform:uppercase;">
                    The Venue is
                </p>
            </div>
            <h1 style="font-family:'Playfair Display',serif;
                       font-size:72px; font-weight:400;
                       line-height:1.1; margin-bottom:30px;">
                An Extraordinary<br>Experience
            </h1>
            <p style="font-family:'Raleway',sans-serif; font-size:16px;
                      color:rgba(255,255,255,0.75); max-width:500px;
                      margin:0 auto 45px; line-height:1.8;">
                Fine dining with fresh ingredients, exquisite flavors
                and an elegant atmosphere
            </p>
            <div>
                <a href="{{ route('menu') }}"
                   style="display:inline-block; background:#c8a951;
                          color:#fff; padding:16px 45px; margin-right:15px;
                          text-decoration:none; font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase; transition:all 0.3s;"
                   onmouseover="this.style.background='#b8943e'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)'">
                    View Menu
                </a>
                @auth
                <a href="{{ route('customer.order.create') }}"
                   style="display:inline-block; border:1px solid #fff;
                          color:#fff; padding:15px 45px;
                          text-decoration:none; font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase; transition:all 0.3s;"
                   onmouseover="this.style.borderColor='#c8a951'; this.style.color='#c8a951'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.borderColor='#fff'; this.style.color='#fff'; this.style.transform='translateY(0)'">
                    Order Now
                </a>
                @else
                <a href="{{ route('reservation.create') }}"
                   style="display:inline-block; border:1px solid #fff;
                          color:#fff; padding:15px 45px;
                          text-decoration:none; font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase; transition:all 0.3s;"
                   onmouseover="this.style.borderColor='#c8a951'; this.style.color='#c8a951'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.borderColor='#fff'; this.style.color='#fff'; this.style.transform='translateY(0)'">
                    Book a Table
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Scroll Down -->
    <div style="position:absolute; bottom:30px; left:50%;
                transform:translateX(-50%); z-index:2; text-align:center;">
        <a href="#features"
           style="color:rgba(255,255,255,0.5); font-size:20px;
                  animation:bounce 2s infinite; display:block;
                  text-decoration:none;">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- ══ Features Bar ═════════════════════════════════════════ -->
<section id="features"
         style="background:#111; padding:80px 0;
                border-bottom:1px solid #1a1a1a;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4 mb-md-0" style="padding:20px;">
                <div style="width:70px; height:70px; border:1px solid #2a2a2a;
                            border-radius:50%; display:flex; align-items:center;
                            justify-content:center; margin:0 auto 25px;
                            transition:all 0.3s;"
                     onmouseover="this.style.borderColor='#c8a951'; this.style.background='rgba(200,169,81,0.08)'"
                     onmouseout="this.style.borderColor='#2a2a2a'; this.style.background='transparent'">
                    <i class="fas fa-utensils" style="color:#c8a951; font-size:24px;"></i>
                </div>
                <h5 style="font-family:'Playfair Display',serif;
                            color:#fff; margin-bottom:12px; font-size:20px;">
                    Fine Dining
                </h5>
                <p style="color:#777; font-size:14px; line-height:1.8; max-width:280px; margin:0 auto;">
                    Premium quality food crafted with passion and the
                    finest ingredients
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0"
                 style="border-left:1px solid #1a1a1a; border-right:1px solid #1a1a1a; padding:20px;">
                <div style="width:70px; height:70px; border:1px solid #2a2a2a;
                            border-radius:50%; display:flex; align-items:center;
                            justify-content:center; margin:0 auto 25px;
                            transition:all 0.3s;"
                     onmouseover="this.style.borderColor='#c8a951'; this.style.background='rgba(200,169,81,0.08)'"
                     onmouseout="this.style.borderColor='#2a2a2a'; this.style.background='transparent'">
                    <i class="fas fa-champagne-glasses" style="color:#c8a951; font-size:24px;"></i>
                </div>
                <h5 style="font-family:'Playfair Display',serif;
                            color:#fff; margin-bottom:12px; font-size:20px;">
                    Special Events
                </h5>
                <p style="color:#777; font-size:14px; line-height:1.8; max-width:280px; margin:0 auto;">
                    Private dining rooms and event hosting for any
                    special occasion
                </p>
            </div>
            <div class="col-md-4" style="padding:20px;">
                <div style="width:70px; height:70px; border:1px solid #2a2a2a;
                            border-radius:50%; display:flex; align-items:center;
                            justify-content:center; margin:0 auto 25px;
                            transition:all 0.3s;"
                     onmouseover="this.style.borderColor='#c8a951'; this.style.background='rgba(200,169,81,0.08)'"
                     onmouseout="this.style.borderColor='#2a2a2a'; this.style.background='transparent'">
                    <i class="fas fa-motorcycle" style="color:#c8a951; font-size:24px;"></i>
                </div>
                <h5 style="font-family:'Playfair Display',serif;
                            color:#fff; margin-bottom:12px; font-size:20px;">
                    Fast Delivery
                </h5>
                <p style="color:#777; font-size:14px; line-height:1.8; max-width:280px; margin:0 auto;">
                    Hot and fresh meals delivered directly to your
                    doorstep
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ══ About Section ════════════════════════════════════════ -->
<section style="padding:110px 0; background:#0d0d0d;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" style="position:relative;">
                <img src="{{ asset('vendor/thevenue/images/about.jpg') }}"
                     alt="About"
                     style="width:100%; height:520px; object-fit:cover;">
                <!-- Floating badge -->
                <div style="position:absolute; bottom:-20px; right:-20px;
                            background:#c8a951; color:#000; padding:25px;
                            text-align:center;">
                    <div style="font-family:'Playfair Display',serif;
                                font-size:36px; font-weight:700; line-height:1;">15+</div>
                    <div style="font-size:11px; letter-spacing:2px;
                                text-transform:uppercase; font-weight:600;">Years</div>
                </div>
            </div>
            <div class="col-lg-6" style="padding-left:50px;">
                <p style="color:#c8a951; letter-spacing:4px;
                           font-size:11px; font-family:'Raleway',sans-serif;
                           text-transform:uppercase; margin-bottom:20px;">
                    Our Story
                </p>
                <h2 style="font-family:'Playfair Display',serif;
                            color:#fff; font-size:42px; margin-bottom:25px;
                            line-height:1.2;">
                    A Passion for<br>Great Food
                </h2>
                <p style="color:#888; font-size:15px; line-height:2;
                           margin-bottom:20px;">
                    We believe that dining is not just about food — it's
                    about the entire experience. Our chefs craft every dish
                    with care using only the freshest seasonal ingredients.
                </p>
                <p style="color:#888; font-size:15px; line-height:2;
                           margin-bottom:35px;">
                    From intimate dinners to grand celebrations, The Venue
                    provides the perfect setting for every occasion.
                </p>
                <a href="{{ route('menu') }}"
                   style="display:inline-flex; align-items:center; gap:10px;
                          background:#c8a951; color:#fff; padding:15px 40px;
                          text-decoration:none; font-family:'Raleway',sans-serif;
                          font-size:11px; font-weight:700; letter-spacing:3px;
                          text-transform:uppercase; transition:all 0.3s;"
                   onmouseover="this.style.background='#b8943e'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)'">
                    View Our Menu <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ══ Featured Menu Items ══════════════════════════════════ -->
@if($featuredItems->count())
<section style="background:#111; padding:110px 0;">
    <div class="container">
        <div class="text-center" style="margin-bottom:60px;">
            <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:15px;">
                Handpicked For You
            </p>
            <h2 style="font-family:'Playfair Display',serif; color:#fff;
                       font-size:42px;">
                Signature Dishes
            </h2>
        </div>
        <div class="row">
            @foreach($featuredItems as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div style="background:#1a1a1a; overflow:hidden;
                            transition:transform 0.3s, box-shadow 0.3s;"
                     onmouseover="this.style.transform='translateY(-8px)';
                                  this.style.boxShadow='0 20px 40px rgba(0,0,0,0.5)'"
                     onmouseout="this.style.transform='translateY(0)';
                                 this.style.boxShadow='none'">

                    @if($item->image)
                        <div style="overflow:hidden;">
                            <img src="{{ asset('storage/'.$item->image) }}"
                                 style="width:100%; height:240px; object-fit:cover;
                                        transition:transform 0.5s;"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                    @else
                        <div style="width:100%; height:240px; background:#181818;
                                    display:flex; align-items:center;
                                    justify-content:center;">
                            <i class="fas fa-bowl-food" style="font-size:48px; color:#2a2a2a;"></i>
                        </div>
                    @endif

                    <div style="padding:25px;">
                        <div style="display:flex; justify-content:space-between;
                                    align-items:flex-start; margin-bottom:10px;">
                            <h5 style="color:#fff; font-family:'Playfair Display',serif;
                                       margin:0; font-size:20px;">
                                {{ $item->name }}
                            </h5>
                            <span style="color:#c8a951; font-family:'Raleway',sans-serif;
                                         font-weight:700; font-size:18px;
                                         white-space:nowrap; margin-left:10px;">
                                Rs.{{ number_format($item->price, 0) }}
                            </span>
                        </div>
                        <p style="color:#666; font-size:13px; line-height:1.7;
                                   margin-bottom:15px;">
                            {{ Str::limit($item->description, 90) }}
                        </p>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <small style="color:#c8a951; letter-spacing:2px;
                                          font-size:10px; text-transform:uppercase;">
                                {{ $item->category->name }}
                            </small>
                            <a href="{{ route('menu.show', $item) }}"
                               style="color:#666; font-size:13px; text-decoration:none;
                                      transition:color 0.3s;"
                               onmouseover="this.style.color='#c8a951'"
                               onmouseout="this.style.color='#666'">
                                View <i class="fas fa-arrow-right" style="font-size:10px; margin-left:4px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center" style="margin-top:55px;">
            <a href="{{ route('menu') }}"
               style="display:inline-flex; align-items:center; gap:10px;
                      border:1px solid #c8a951; color:#c8a951;
                      padding:15px 50px; text-decoration:none;
                      font-family:'Raleway',sans-serif; font-size:11px;
                      font-weight:700; letter-spacing:3px; text-transform:uppercase;
                      transition:all 0.3s;"
               onmouseover="this.style.background='#c8a951';this.style.color='#fff'; this.style.transform='translateY(-2px)'"
               onmouseout="this.style.background='transparent';this.style.color='#c8a951'; this.style.transform='translateY(0)'">
                View Full Menu <i class="fas fa-arrow-right" style="font-size:10px;"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ══ Reservation CTA ══════════════════════════════════════ -->
<section style="position:relative; padding:120px 0; text-align:center;
                background: url('{{ asset('vendor/thevenue/images/reservations.jpg') }}')
                center/cover no-repeat;">
    <div style="position:absolute; inset:0;
                background:linear-gradient(135deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.5) 100%);"></div>
    <div style="position:relative; z-index:2; color:#fff;">
        <div style="margin-bottom:25px;">
            <i class="fas fa-calendar-check" style="font-size:32px; color:#c8a951;"></i>
        </div>
        <p style="color:#c8a951; letter-spacing:5px; font-size:11px;
                  text-transform:uppercase; margin-bottom:20px;">
            Plan Your Visit
        </p>
        <h2 style="font-family:'Playfair Display',serif; font-size:52px;
                   font-weight:400; margin-bottom:20px;">
            Reserve a Table
        </h2>
        <p style="color:rgba(255,255,255,0.65); font-size:16px;
                  max-width:450px; margin:0 auto 40px; line-height:1.8;">
            Book your table and enjoy a seamless fine dining experience
        </p>
        <a href="{{ route('reservation.create') }}"
           style="display:inline-flex; align-items:center; gap:10px;
                  background:#c8a951; color:#fff; padding:18px 55px;
                  text-decoration:none; font-family:'Raleway',sans-serif;
                  font-size:11px; font-weight:700; letter-spacing:3px;
                  text-transform:uppercase; transition:all 0.3s;"
           onmouseover="this.style.background='#b8943e'; this.style.transform='translateY(-2px)'"
           onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)'">
            <i class="fas fa-phone" style="font-size:12px;"></i> Book Now
        </a>
    </div>
</section>

<!-- ══ Testimonials ═════════════════════════════════════════ -->
<section style="background:#0d0d0d; padding:110px 0;">
    <div class="container">
        <div class="text-center" style="margin-bottom:60px;">
            <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:15px;">
                What People Say
            </p>
            <h2 style="font-family:'Playfair Display',serif;
                       color:#fff; font-size:42px;">
                Guest Reviews
            </h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div style="background:#151515; padding:40px 30px; border:1px solid #1e1e1e;
                            transition:all 0.3s;"
                     onmouseover="this.style.borderColor='#2a2a2a'; this.style.transform='translateY(-5px)'"
                     onmouseout="this.style.borderColor='#1e1e1e'; this.style.transform='translateY(0)'">
                    <div style="margin-bottom:20px;">
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px;"></i>
                    </div>
                    <i class="fas fa-quote-left" style="color:#222; font-size:24px; margin-bottom:15px; display:block;"></i>
                    <p style="color:#888; font-size:14px; line-height:2;
                               font-style:italic; margin-bottom:25px;">
                        An extraordinary experience! The food was
                        absolutely divine and the service impeccable.
                    </p>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="width:42px; height:42px; border-radius:50%;
                                    background:#1a1a1a; display:flex; align-items:center;
                                    justify-content:center;">
                            <i class="fas fa-user" style="color:#444; font-size:14px;"></i>
                        </div>
                        <div>
                            <strong style="color:#fff; display:block; font-size:14px;">Sarah Ahmed</strong>
                            <small style="color:#555; font-size:12px;">Food Critic</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div style="background:#151515; padding:40px 30px; border:1px solid #1e1e1e;
                            transition:all 0.3s;"
                     onmouseover="this.style.borderColor='#2a2a2a'; this.style.transform='translateY(-5px)'"
                     onmouseout="this.style.borderColor='#1e1e1e'; this.style.transform='translateY(0)'">
                    <div style="margin-bottom:20px;">
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px;"></i>
                    </div>
                    <i class="fas fa-quote-left" style="color:#222; font-size:24px; margin-bottom:15px; display:block;"></i>
                    <p style="color:#888; font-size:14px; line-height:2;
                               font-style:italic; margin-bottom:25px;">
                        Best restaurant in the city! Every dish was a
                        masterpiece. Will definitely come back.
                    </p>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="width:42px; height:42px; border-radius:50%;
                                    background:#1a1a1a; display:flex; align-items:center;
                                    justify-content:center;">
                            <i class="fas fa-user" style="color:#444; font-size:14px;"></i>
                        </div>
                        <div>
                            <strong style="color:#fff; display:block; font-size:14px;">Ali Hassan</strong>
                            <small style="color:#555; font-size:12px;">Regular Customer</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div style="background:#151515; padding:40px 30px; border:1px solid #1e1e1e;
                            transition:all 0.3s;"
                     onmouseover="this.style.borderColor='#2a2a2a'; this.style.transform='translateY(-5px)'"
                     onmouseout="this.style.borderColor='#1e1e1e'; this.style.transform='translateY(0)'">
                    <div style="margin-bottom:20px;">
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px; margin-right:2px;"></i>
                        <i class="fas fa-star" style="color:#c8a951; font-size:14px;"></i>
                    </div>
                    <i class="fas fa-quote-left" style="color:#222; font-size:24px; margin-bottom:15px; display:block;"></i>
                    <p style="color:#888; font-size:14px; line-height:2;
                               font-style:italic; margin-bottom:25px;">
                        The ambiance is magical and the food is
                        outstanding. Perfect for special occasions.
                    </p>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="width:42px; height:42px; border-radius:50%;
                                    background:#1a1a1a; display:flex; align-items:center;
                                    justify-content:center;">
                            <i class="fas fa-user" style="color:#444; font-size:14px;"></i>
                        </div>
                        <div>
                            <strong style="color:#fff; display:block; font-size:14px;">Maria Khan</strong>
                            <small style="color:#555; font-size:12px;">Event Planner</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(-10px); }
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

@endsection