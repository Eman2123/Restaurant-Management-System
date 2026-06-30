@extends('layouts.customer')
@section('title', 'Our Menu')

@section('content')
<div style="padding-top:80px; background:#0d0d0d; min-height:100vh;">

    <!-- Page Header -->
    <div style="background:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),
                url('{{ asset('vendor/thevenue/images/menu.jpg') }}')
                center/cover; padding:80px 0; text-align:center; position:relative;">
        <div style="position:absolute; bottom:0; left:0; right:0; height:1px;
                    background:linear-gradient(90deg, transparent, #c8a951, transparent);"></div>
        <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                  text-transform:uppercase; margin-bottom:15px; opacity:0;
                  animation:fadeUp 0.6s ease forwards 0.1s;">
            Explore Our Kitchen
        </p>
        <h1 style="color:#fff; font-family:'Playfair Display',serif;
                   font-size:52px; font-weight:400; opacity:0;
                   animation:fadeUp 0.7s ease forwards 0.25s;">
            Our Menu
        </h1>
        <style>
            @keyframes fadeUp {
                from { opacity:0; transform:translateY(10px); }
                to { opacity:1; transform:translateY(0); }
            }
        </style>
    </div>

    <div class="container py-5">

        <!-- Search + Sort Row -->
        <form method="GET" action="{{ route('menu') }}" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <div style="position:relative;">
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="Search dishes..."
                               style="width:100%; background:#1a1a1a;
                                      border:1px solid #2a2a2a; color:#fff;
                                      padding:12px 12px 12px 42px;
                                      font-size:14px; outline:none;
                                      transition:border-color 0.3s, box-shadow 0.3s;
                                      font-family:'Raleway',sans-serif;"
                               onfocus="this.style.borderColor='#c8a951'; 
                                       this.style.boxShadow='0 0 10px rgba(200,169,81,0.2)'"
                               onblur="this.style.borderColor='#2a2a2a';
                                      this.style.boxShadow='none'">
                        <i class="fas fa-search"
                           style="position:absolute; left:14px;
                                  top:50%; transform:translateY(-50%);
                                  color:#555; font-size:13px;"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="sort"
                            style="width:100%; background:#1a1a1a;
                                   border:1px solid #2a2a2a; color:#fff;
                                   padding:12px; font-size:14px; outline:none;
                                   transition:border-color 0.3s, box-shadow 0.3s;
                                   font-family:'Raleway',sans-serif;"
                            onfocus="this.style.borderColor='#c8a951';
                                    this.style.boxShadow='0 0 10px rgba(200,169,81,0.2)'"
                            onblur="this.style.borderColor='#2a2a2a';
                                   this.style.boxShadow='none'">
                        <option value="" style="background:#1a1a1a; color:#fff;">Default Sort</option>
                        <option value="price_low" style="background:#1a1a1a; color:#fff;"
                            {{ request('sort') === 'price_low' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option value="price_high" style="background:#1a1a1a; color:#fff;"
                            {{ request('sort') === 'price_high' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                        <option value="name" style="background:#1a1a1a; color:#fff;"
                            {{ request('sort') === 'name' ? 'selected' : '' }}>
                            Name A-Z
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit"
                            style="width:100%; background:#c8a951;
                                   color:#fff; border:none; padding:12px;
                                   font-size:11px; font-weight:700;
                                   letter-spacing:2px;
                                   text-transform:uppercase;
                                   cursor:pointer; transition:all 0.3s;
                                   font-family:'Raleway',sans-serif;"
                            onmouseover="this.style.background='#b8943e'; 
                                        this.style.transform='translateY(-2px)';
                                        this.style.boxShadow='0 6px 20px rgba(200,169,81,0.3)'"
                            onmouseout="this.style.background='#c8a951';
                                       this.style.transform='translateY(0)';
                                       this.style.boxShadow='none'">
                        <i class="fas fa-search" style="margin-right:6px;"></i> Search
                    </button>
                </div>
            </div>
            @if(request('search') || request('sort'))
            <div style="margin-top:12px;">
                <a href="{{ route('menu') }}"
                   style="color:#666; font-size:12px;
                          text-decoration:none; transition:color 0.3s;
                          display:inline-flex; align-items:center; gap:6px;"
                   onmouseover="this.style.color='#c8a951'"
                   onmouseout="this.style.color='#666'">
                    <i class="fas fa-times"></i>
                    Clear Filters
                    <span style="color:#c8a951; font-weight:600;">
                        ({{ $menuItems->count() }} result{{ $menuItems->count() !== 1 ? 's' : '' }})
                    </span>
                </a>
            </div>
            @endif
        </form>

        <!-- Category Filter Pills -->
        <div style="text-align:center; margin-bottom:35px; display:flex; 
                    flex-wrap:wrap; gap:8px; justify-content:center;">
            <a href="{{ route('menu') }}"
               style="display:inline-block; border:1px solid #c8a951;
                      color:{{ !request('category') ? '#fff' : '#c8a951' }};
                      background:{{ !request('category') ? '#c8a951' : 'transparent' }};
                      padding:10px 24px; 
                      font-size:11px; font-weight:600;
                      letter-spacing:2px; text-transform:uppercase;
                      text-decoration:none; transition:all 0.3s;
                      border-radius:4px; font-family:'Raleway',sans-serif;"
               onmouseover="if(!{{ !request('category') ? 'true' : 'false' }}){
                           this.style.background='#c8a951';
                           this.style.color='#fff';
                           this.style.transform='translateY(-2px)';}"
               onmouseout="if(!{{ !request('category') ? 'true' : 'false' }}){
                          this.style.background='transparent';
                          this.style.color='#c8a951';
                          this.style.transform='translateY(0)'}">
                All Items
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('menu', ['category' => $cat->id]) }}"
               style="display:inline-block; border:1px solid #c8a951;
                      color:{{ request('category') == $cat->id ? '#fff' : '#c8a951' }};
                      background:{{ request('category') == $cat->id ? '#c8a951' : 'transparent' }};
                      padding:10px 24px;
                      font-size:11px; font-weight:600;
                      letter-spacing:2px; text-transform:uppercase;
                      text-decoration:none; transition:all 0.3s;
                      border-radius:4px; font-family:'Raleway',sans-serif;"
               onmouseover="if(!{{ request('category') == $cat->id ? 'true' : 'false' }}){
                           this.style.background='#c8a951';
                           this.style.color='#fff';
                           this.style.transform='translateY(-2px)';}"
               onmouseout="if(!{{ request('category') == $cat->id ? 'true' : 'false' }}){
                          this.style.background='transparent';
                          this.style.color='#c8a951';
                          this.style.transform='translateY(0)'}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <!-- Menu Items Grid -->
        <div class="row">
            @forelse($menuItems as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            overflow:hidden; height:100%;
                            transition:transform 0.3s, border-color 0.3s, box-shadow 0.3s;
                            border-radius:6px;"
                     onmouseover="this.style.transform='translateY(-8px)';
                                  this.style.borderColor='#c8a951';
                                  this.style.boxShadow='0 12px 24px rgba(200,169,81,0.2)'"
                     onmouseout="this.style.transform='translateY(0)';
                                 this.style.borderColor='#2a2a2a';
                                 this.style.boxShadow='none'">

                    @if($item->image)
                    <div style="overflow:hidden; position:relative; height:210px;">
                        <img src="{{ asset('storage/'.$item->image) }}"
                             alt="{{ $item->name }}"
                             style="width:100%; height:100%; object-fit:cover;
                                    transition:transform 0.5s ease;"
                             onmouseover="this.style.transform='scale(1.08)'"
                             onmouseout="this.style.transform='scale(1)'">
                        @if($item->is_featured)
                        <div style="position:absolute; top:12px; right:12px;
                                    background:#ffc107; color:#000;
                                    padding:6px 14px; font-size:10px;
                                    font-weight:700; letter-spacing:1px;
                                    text-transform:uppercase; border-radius:3px;">
                            Featured
                        </div>
                        @endif
                    </div>
                    @else
                    <div style="width:100%; height:210px; background:#222;
                                display:flex; align-items:center;
                                justify-content:center;">
                        <i class="fas fa-utensils" style="font-size:40px; color:#333;"></i>
                    </div>
                    @endif

                    <div style="padding:22px;">
                        <div style="display:flex; justify-content:space-between;
                                    align-items:flex-start; margin-bottom:8px; gap:10px;">
                            <h5 style="color:#fff;
                                       font-family:'Playfair Display',serif;
                                       margin:0; font-size:18px;
                                       line-height:1.3;">
                                {{ $item->name }}
                            </h5>
                            <span style="color:#c8a951; font-weight:700;
                                         font-size:17px; white-space:nowrap;
                                         flex-shrink:0;">
                                Rs.{{ number_format($item->price, 0) }}
                            </span>
                        </div>

                        <small style="color:#c8a951; letter-spacing:2px;
                                      font-size:10px; text-transform:uppercase;
                                      display:block; margin-bottom:10px;
                                      font-weight:600;">
                            {{ $item->category->name }}
                        </small>

                        @if($item->description)
                        <p style="color:#888; font-size:13px;
                                   line-height:1.6; margin-bottom:15px;
                                   height:39px; overflow:hidden;
                                   text-overflow:ellipsis; display:-webkit-box;
                                   -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                            {{ $item->description }}
                        </p>
                        @endif

                        <div style="display:flex; align-items:center; gap:8px;
                                    flex-wrap:wrap; margin-bottom:12px;">
                            @if(!$item->is_available)
                            <span style="background:rgba(220,53,69,0.1);
                                        border:1px solid rgba(220,53,69,0.3);
                                        color:#dc3545;
                                        padding:4px 12px; font-size:10px;
                                        font-weight:600; border-radius:3px;
                                        text-transform:uppercase;
                                        letter-spacing:1px;">
                                Unavailable
                            </span>
                            @endif
                        </div>

                        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                            @auth
                            <a href="{{ route('customer.order.create') }}"
                               style="display:inline-flex; align-items:center;
                                      background:#c8a951; color:#fff;
                                      padding:10px 18px; font-size:10px;
                                      font-weight:700; letter-spacing:2px;
                                      text-transform:uppercase;
                                      text-decoration:none;
                                      transition:all 0.3s; border-radius:4px;
                                      gap:6px; font-family:'Raleway',sans-serif;"
                               onmouseover="this.style.background='#b8943e';
                                           this.style.transform='translateY(-2px)';
                                           this.style.boxShadow='0 6px 15px rgba(200,169,81,0.3)'"
                               onmouseout="this.style.background='#c8a951';
                                          this.style.transform='translateY(0)';
                                          this.style.boxShadow='none'">
                                <i class="fas fa-shopping-cart"></i> Order
                            </a>
                            @else
                            <a href="{{ route('login') }}"
                               style="display:inline-flex; align-items:center;
                                      border:1px solid #c8a951;
                                      color:#c8a951; padding:10px 18px;
                                      font-size:10px; font-weight:700;
                                      letter-spacing:2px;
                                      text-transform:uppercase;
                                      text-decoration:none;
                                      transition:all 0.3s; border-radius:4px;
                                      gap:6px; font-family:'Raleway',sans-serif;"
                               onmouseover="this.style.background='#c8a951';
                                           this.style.color='#fff'"
                               onmouseout="this.style.background='transparent';
                                          this.style.color='#c8a951'">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                            @endauth
                            <a href="{{ route('menu.show', $item) }}"
                               style="display:inline-flex; align-items:center;
                                      color:#666; font-size:12px;
                                      text-decoration:none;
                                      transition:color 0.3s; gap:4px;
                                      font-family:'Raleway',sans-serif;"
                               onmouseover="this.style.color='#c8a951'"
                               onmouseout="this.style.color='#666'">
                                Details <i class="fas fa-arrow-right" style="font-size:9px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-utensils" style="font-size:48px; color:#2a2a2a;
                                                   margin-bottom:20px; display:block;
                                                   opacity:0.5;"></i>
                <h4 style="color:#888; font-family:'Playfair Display',serif;
                           margin-bottom:10px; font-size:24px;">
                    No Dishes Found
                </h4>
                <p style="color:#666; margin-bottom:25px; font-size:14px;">
                    Try a different search or category
                </p>
                <a href="{{ route('menu') }}"
                   style="display:inline-block; border:1px solid #c8a951;
                          color:#c8a951; padding:12px 35px;
                          text-decoration:none; font-size:11px;
                          font-weight:700; letter-spacing:2px;
                          text-transform:uppercase; transition:all 0.3s;
                          border-radius:4px; font-family:'Raleway',sans-serif;"
                   onmouseover="this.style.background='#c8a951';
                               this.style.color='#fff';
                               this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.background='transparent';
                              this.style.color='#c8a951';
                              this.style.transform='translateY(0)'">
                    <i class="fas fa-arrow-left" style="margin-right:8px;"></i>
                    View All Menu
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection