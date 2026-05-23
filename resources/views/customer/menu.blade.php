@extends('layouts.customer')
@section('title', 'Our Menu')

@section('content')
<div style="padding-top:80px; background:#0d0d0d; min-height:100vh;">

    <!-- Page Header -->
    <div style="background:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),
                url('{{ asset('vendor/thevenue/images/menu.jpg') }}')
                center/cover; padding:80px 0; text-align:center;">
        <p style="color:#c8a951; letter-spacing:5px; font-size:11px;
                  text-transform:uppercase; margin-bottom:15px;">
            Explore
        </p>
        <h1 style="color:#fff; font-family:'Playfair Display',serif;
                   font-size:52px; font-weight:400;">
            Our Menu
        </h1>
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
                                      transition:border-color 0.3s;"
                               onfocus="this.style.borderColor='#c8a951'"
                               onblur="this.style.borderColor='#2a2a2a'">
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
                                   transition:border-color 0.3s;"
                            onfocus="this.style.borderColor='#c8a951'"
                            onblur="this.style.borderColor='#2a2a2a'">
                        <option value="">Default Sort</option>
                        <option value="price_low"
                            {{ request('sort') === 'price_low' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option value="price_high"
                            {{ request('sort') === 'price_high' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                        <option value="name"
                            {{ request('sort') === 'name' ? 'selected' : '' }}>
                            Name A-Z
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit"
                            style="width:100%; background:#c8a951;
                                   color:#000; border:none; padding:12px;
                                   font-size:11px; font-weight:700;
                                   letter-spacing:2px;
                                   text-transform:uppercase;
                                   cursor:pointer; transition:all 0.3s;"
                            onmouseover="this.style.background='#b8943e'"
                            onmouseout="this.style.background='#c8a951'">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                </div>
            </div>
            @if(request('search') || request('sort'))
            <div style="margin-top:12px;">
                <a href="{{ route('menu') }}"
                   style="color:#666; font-size:12px;
                          text-decoration:none; transition:color 0.3s;"
                   onmouseover="this.style.color='#c8a951'"
                   onmouseout="this.style.color='#666'">
                    <i class="fas fa-times mr-1"></i>
                    Clear Filters
                    ({{ $menuItems->count() }} result{{ $menuItems->count() !== 1 ? 's' : '' }})
                </a>
            </div>
            @endif
        </form>

        <!-- Category Filter Pills -->
        <div class="text-center mb-5">
            <a href="{{ route('menu') }}"
               style="display:inline-block; border:1px solid #c8a951;
                      color:{{ !request('category') ? '#000' : '#c8a951' }};
                      background:{{ !request('category') ? '#c8a951' : 'transparent' }};
                      padding:8px 22px; margin:3px;
                      font-size:11px; font-weight:600;
                      letter-spacing:2px; text-transform:uppercase;
                      text-decoration:none; transition:all 0.3s;"
               onmouseover="if(!{{ !request('category') ? 'true' : 'false' }}){this.style.background='#c8a951';this.style.color='#000'}"
               onmouseout="if(!{{ !request('category') ? 'true' : 'false' }}){this.style.background='transparent';this.style.color='#c8a951'}">
                All
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('menu', ['category' => $cat->id]) }}"
               style="display:inline-block; border:1px solid #c8a951;
                      color:{{ request('category') == $cat->id ? '#000' : '#c8a951' }};
                      background:{{ request('category') == $cat->id ? '#c8a951' : 'transparent' }};
                      padding:8px 22px; margin:3px;
                      font-size:11px; font-weight:600;
                      letter-spacing:2px; text-transform:uppercase;
                      text-decoration:none; transition:all 0.3s;"
               onmouseover="if(!{{ request('category') == $cat->id ? 'true' : 'false' }}){this.style.background='#c8a951';this.style.color='#000'}"
               onmouseout="if(!{{ request('category') == $cat->id ? 'true' : 'false' }}){this.style.background='transparent';this.style.color='#c8a951'}">
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
                            transition:transform 0.3s, border-color 0.3s;"
                     onmouseover="this.style.transform='translateY(-6px)';
                                  this.style.borderColor='#c8a951'"
                     onmouseout="this.style.transform='translateY(0)';
                                 this.style.borderColor='#2a2a2a'">

                    @if($item->image)
                    <div style="overflow:hidden;">
                        <img src="{{ asset('storage/'.$item->image) }}"
                             alt="{{ $item->name }}"
                             style="width:100%; height:210px; object-fit:cover;
                                    transition:transform 0.5s;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">
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
                                    align-items:flex-start; margin-bottom:8px;">
                            <h5 style="color:#fff;
                                       font-family:'Playfair Display',serif;
                                       margin:0; font-size:18px;
                                       flex:1; margin-right:10px;">
                                {{ $item->name }}
                            </h5>
                            <span style="color:#c8a951; font-weight:700;
                                         font-size:17px; white-space:nowrap;">
                                Rs.{{ number_format($item->price, 0) }}
                            </span>
                        </div>

                        <small style="color:#c8a951; letter-spacing:2px;
                                      font-size:10px; text-transform:uppercase;
                                      display:block; margin-bottom:10px;">
                            {{ $item->category->name }}
                        </small>

                        @if($item->description)
                        <p style="color:#777; font-size:13px;
                                   line-height:1.7; margin-bottom:15px;">
                            {{ Str::limit($item->description, 80) }}
                        </p>
                        @endif

                        <div style="display:flex; align-items:center; gap:10px;">
                            @auth
                            <a href="{{ route('customer.order.create') }}"
                               style="display:inline-block;
                                      background:#c8a951; color:#000;
                                      padding:8px 20px; font-size:10px;
                                      font-weight:700; letter-spacing:2px;
                                      text-transform:uppercase;
                                      text-decoration:none;
                                      transition:all 0.3s;"
                               onmouseover="this.style.background='#b8943e'"
                               onmouseout="this.style.background='#c8a951'">
                                Order Now
                            </a>
                            @else
                            <a href="{{ route('login') }}"
                               style="display:inline-block;
                                      border:1px solid #c8a951;
                                      color:#c8a951; padding:8px 20px;
                                      font-size:10px; font-weight:700;
                                      letter-spacing:2px;
                                      text-transform:uppercase;
                                      text-decoration:none;
                                      transition:all 0.3s;"
                               onmouseover="this.style.background='#c8a951';this.style.color='#000'"
                               onmouseout="this.style.background='transparent';this.style.color='#c8a951'">
                                Login to Order
                            </a>
                            @endauth
                            <a href="{{ route('menu.show', $item) }}"
                               style="display:inline-block; color:#555;
                                      font-size:12px; text-decoration:none;
                                      transition:color 0.3s;"
                               onmouseover="this.style.color='#c8a951'"
                               onmouseout="this.style.color='#555'">
                                Details <i class="fas fa-arrow-right" style="font-size:9px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-utensils" style="font-size:48px; color:#2a2a2a;
                                                   margin-bottom:20px; display:block;"></i>
                <h4 style="color:#555; font-family:'Playfair Display',serif;
                           margin-bottom:10px;">
                    No dishes found
                </h4>
                <p style="color:#444; margin-bottom:20px;">
                    Try a different search or category
                </p>
                <a href="{{ route('menu') }}"
                   style="display:inline-block; border:1px solid #c8a951;
                          color:#c8a951; padding:10px 30px;
                          text-decoration:none; font-size:11px;
                          font-weight:700; letter-spacing:2px;
                          text-transform:uppercase; transition:all 0.3s;"
                   onmouseover="this.style.background='#c8a951';this.style.color='#000'"
                   onmouseout="this.style.background='transparent';this.style.color='#c8a951'">
                    View All Menu
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection