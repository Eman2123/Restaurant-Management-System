@extends('layouts.customer')
@section('title', 'Rate Your Order')

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="text-center mb-5">
                    <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                              text-transform:uppercase; margin-bottom:15px;">
                        Your Feedback
                    </p>
                    <h2 style="font-family:'Playfair Display',serif;
                               color:#fff; font-size:36px;">
                        Rate Order #{{ $order->id }}
                    </h2>
                    <p style="color:#888; margin-top:10px;">
                        {{ $order->orderItems->count() }} items •
                        Rs.{{ number_format($order->total_amount, 0) }}
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('customer.review.store', $order) }}"
                      style="background:#1a1a1a; border:1px solid #2a2a2a;
                             padding:40px;">
                    @csrf

                    <!-- Star Rating -->
                    <div style="text-align:center; margin-bottom:35px;">
                        <p style="color:#888; font-size:11px;
                                   letter-spacing:2px; text-transform:uppercase;
                                   margin-bottom:15px;">
                            Your Rating
                        </p>
                        <div class="star-rating" style="font-size:50px;
                                                         cursor:pointer;">
                            @for($i = 1; $i <= 5; $i++)
                            <span class="star"
                                  data-val="{{ $i }}"
                                  style="color:#2a2a2a; transition:all 0.2s;
                                         display:inline-block;"
                                  onmouseover="hoverStar({{ $i }})"
                                  onmouseout="unhoverStar()"
                                  onclick="selectStar({{ $i }})">
                                ★
                            </span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating"
                               id="ratingInput" value="0" required>
                        <div id="ratingText"
                             style="color:#888; font-size:13px; margin-top:8px;">
                            Click a star to rate
                        </div>
                    </div>

                    <!-- Category -->
                    <div style="margin-bottom:25px;">
                        <p style="color:#888; font-size:11px;
                                   letter-spacing:2px; text-transform:uppercase;
                                   margin-bottom:15px;">
                            What are you rating?
                        </p>
                        <div style="display:grid; grid-template-columns:1fr 1fr;
                                    gap:10px;">
                            @foreach(['food' => '🍽 Food Quality',
                                      'service' => '⭐ Service',
                                      'ambiance' => '🌟 Ambiance',
                                      'value' => '💰 Value'] as $val => $label)
                            <label style="cursor:pointer;">
                                <input type="radio" name="category"
                                       value="{{ $val }}"
                                       class="cat-radio"
                                       style="display:none;"
                                       {{ $val === 'food' ? 'checked' : '' }}>
                                <div class="cat-btn"
                                     data-val="{{ $val }}"
                                     style="padding:12px; text-align:center;
                                            border:2px solid #2a2a2a;
                                            border-radius:8px; font-size:13px;
                                            color:#888; transition:all 0.2s;
                                            {{ $val === 'food'
                                                ? 'border-color:#c8a951; color:#fff;'
                                                : '' }}">
                                    {{ $label }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Comment -->
                    <div style="margin-bottom:30px;">
                        <label style="color:#888; font-size:11px;
                                      letter-spacing:2px;
                                      text-transform:uppercase;
                                      display:block; margin-bottom:10px;">
                            Your Comment (optional)
                        </label>
                        <textarea name="comment" rows="4"
                                  placeholder="Tell us about your experience..."
                                  style="width:100%; background:#111;
                                         border:1px solid #333; color:#fff;
                                         padding:14px; font-size:14px;
                                         resize:none; outline:none;
                                         font-family:'Raleway',sans-serif;"
                                  maxlength="500"></textarea>
                        <div style="text-align:right; color:#555;
                                    font-size:11px; margin-top:4px;">
                            Max 500 characters
                        </div>
                    </div>

                    <button type="submit"
                            id="submitBtn"
                            style="width:100%; background:#c8a951;
                                   color:#fff; border:none; padding:15px;
                                   font-size:12px; font-weight:700;
                                   letter-spacing:3px;
                                   text-transform:uppercase; cursor:pointer;">
                        Submit Review
                    </button>

                    <a href="{{ route('customer.orders') }}"
                       style="display:block; text-align:center;
                              color:#555; font-size:13px;
                              margin-top:15px; text-decoration:none;">
                        Skip for now
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let selected = 0;
const labels = ['','Poor','Fair','Good','Great','Excellent'];

function hoverStar(val) {
    document.querySelectorAll('.star').forEach((s,i) => {
        s.style.color = i < val ? '#c8a951' : '#2a2a2a';
        s.style.transform = i < val ? 'scale(1.1)' : 'scale(1)';
    });
}

function unhoverStar() {
    document.querySelectorAll('.star').forEach((s,i) => {
        s.style.color = i < selected ? '#c8a951' : '#2a2a2a';
        s.style.transform = 'scale(1)';
    });
}

function selectStar(val) {
    selected = val;
    document.getElementById('ratingInput').value = val;
    document.getElementById('ratingText').textContent = labels[val];
    document.getElementById('ratingText').style.color = '#c8a951';
}

// Category selection
document.querySelectorAll('.cat-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.cat-btn').forEach(btn => {
            btn.style.borderColor = '#2a2a2a';
            btn.style.color = '#888';
        });
        const btn = document.querySelector(
            `.cat-btn[data-val="${this.value}"]`);
        if (btn) {
            btn.style.borderColor = '#c8a951';
            btn.style.color = '#fff';
        }
    });
});

document.querySelectorAll('.cat-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const val = this.dataset.val;
        document.querySelector(
            `input[value="${val}"]`).checked = true;
        document.querySelectorAll('.cat-btn').forEach(b => {
            b.style.borderColor = '#2a2a2a';
            b.style.color = '#888';
        });
        this.style.borderColor = '#c8a951';
        this.style.color = '#fff';
    });
});
</script>
@endpush

@endsection