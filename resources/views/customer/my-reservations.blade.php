@extends('layouts.customer')
@section('title', 'My Reservations')

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">
    <div class="container py-5">

        <div class="text-center mb-5">
            <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:15px;">
                Your Bookings
            </p>
            <h2 style="font-family:'Playfair Display',serif;
                       color:#fff; font-size:42px;">
                My Reservations
            </h2>
        </div>

        @forelse($reservations as $res)
        <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                    margin-bottom:20px; padding:25px;">
            <div class="row align-items-center">

                <div class="col-md-3">
                    <div style="color:#c8a951; font-size:28px;
                                font-weight:700; font-family:'Playfair Display',serif;">
                        {{ \Carbon\Carbon::parse($res->reservation_date)
                            ->format('d') }}
                    </div>
                    <div style="color:#888; font-size:14px;">
                        {{ \Carbon\Carbon::parse($res->reservation_date)
                            ->format('M Y') }}
                    </div>
                    <div style="color:#ccc; font-size:13px;">
                        {{ $res->reservation_time }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="color:#888; font-size:12px;
                                margin-bottom:5px;">Booking Details</div>
                    <div style="color:#fff; font-size:14px;">
                        Table #{{ $res->table->table_number }}
                    </div>
                    <div style="color:#888; font-size:13px;">
                        {{ $res->guests_count }} guests
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="color:#888; font-size:12px;
                                margin-bottom:5px;">Guest</div>
                    <div style="color:#fff; font-size:14px;">
                        {{ $res->guest_name }}
                    </div>
                    <div style="color:#888; font-size:13px;">
                        {{ $res->guest_phone }}
                    </div>
                </div>

                <div class="col-md-3 text-center">
                    <span style="display:inline-block; padding:8px 20px; font-size:11px;
                                 font-weight:700; letter-spacing:1px;
                                 text-transform:uppercase;
                                 background:{{
                                     $res->status === 'confirmed'  ? '#198754' :
                                     ($res->status === 'cancelled' ? '#dc3545' :
                                     ($res->status === 'completed' ? '#6c757d' :
                                      '#ffc107')) }};
                                 color:{{
                                     $res->status === 'pending' ? '#000' : '#fff'
                                 }};">
                        {{ ucfirst($res->status) }}
                    </span>
                    @if($res->notes)
                    <div style="color:#888; font-size:12px; margin-top:8px;">
                        {{ Str::limit($res->notes, 40) }}
                    </div>
                    @endif
                    @if($res->status === 'pending')
                    <form method="POST"
                          action="{{ route('customer.reservations.cancel', $res) }}"
                          onsubmit="return confirm('Are you sure you want to cancel this reservation?')"
                          style="margin-top:12px;">
                        @csrf
                        <button type="submit"
                                style="background:transparent;
                                       border:1px solid #dc3545;
                                       color:#dc3545; padding:6px 16px;
                                       font-size:11px; letter-spacing:1px;
                                       text-transform:uppercase;
                                       cursor:pointer; transition:all 0.3s;"
                                onmouseover="this.style.background='#dc3545'; this.style.color='#fff'"
                                onmouseout="this.style.background='transparent'; this.style.color='#dc3545'">
                            Cancel
                        </button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <h4 style="color:#fff; font-family:'Playfair Display',serif;">
                No Reservations Yet
            </h4>
            <p style="color:#888;">
                You haven't made any reservations yet.
            </p>
            <a href="{{ route('reservation.create') }}"
               style="display:inline-block; background:#c8a951;
                      color:#fff; padding:14px 40px; margin-top:20px;
                      text-decoration:none; font-size:11px;
                      font-weight:700; letter-spacing:3px;
                      text-transform:uppercase;">
                Book a Table
            </a>
        </div>
        @endforelse

        <div class="text-center mt-4">
            <a href="{{ route('reservation.create') }}"
               style="display:inline-block; border:1px solid #c8a951;
                      color:#c8a951; padding:12px 40px;
                      text-decoration:none; font-size:11px;
                      font-weight:700; letter-spacing:3px;
                      text-transform:uppercase; transition:all 0.3s;"
               onmouseover="this.style.background='#c8a951';
                             this.style.color='#fff'"
               onmouseout="this.style.background='transparent';
                            this.style.color='#c8a951'">
                Make New Reservation
            </a>
        </div>

    </div>
</div>
@endsection