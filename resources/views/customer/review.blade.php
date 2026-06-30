@extends('layouts.customer')
@section('title', 'Rate Your Order')

@push('styles')
<style>
    .review-page {
        padding-top: 100px;
        background: #0d0d0d;
        min-height: 100vh;
        font-family: 'Raleway', sans-serif;
    }

    /* Header animations */
    .review-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .review-header-label {
        color: #c8a951;
        letter-spacing: 4px;
        font-size: 11px;
        text-transform: uppercase;
        margin-bottom: 15px;
        display: block;
        opacity: 0;
        animation: fadeUp 0.6s ease forwards 0.1s;
        font-weight: 600;
    }
    .review-header-title {
        font-family: 'Playfair Display', serif;
        font-weight: 400;
        color: #fff;
        font-size: 42px;
        margin-bottom: 15px;
        opacity: 0;
        animation: fadeUp 0.7s ease forwards 0.25s;
    }
    .review-header-meta {
        color: #888;
        font-size: 14px;
        opacity: 0;
        animation: fadeUp 0.6s ease forwards 0.4s;
    }
    .review-header-meta span {
        display: inline-block;
        margin: 0 8px;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Card */
    .review-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        padding: 50px;
        position: relative;
        border-radius: 8px;
        opacity: 0;
        animation: fadeUp 0.7s ease forwards 0.5s;
        transition: border-color 0.3s;
    }
    .review-card:hover {
        border-color: #3a3a3a;
    }
    .review-card::before {
        content: '';
        position: absolute;
        top: 0; left: 8%; right: 8%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #c8a951 50%, transparent);
        border-radius: 8px 8px 0 0;
        transform: scaleX(0);
        transform-origin: center;
        transition: transform 0.5s ease;
    }
    .review-card:hover::before {
        transform: scaleX(1);
    }

    /* Labels */
    .flabel {
        display: block;
        color: #c8a951;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 18px;
        font-weight: 600;
    }

    /* Stars */
    .stars {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 18px;
    }
    .star {
        font-size: 52px;
        color: #2a2a2a;
        cursor: pointer;
        transition: color 0.15s, transform 0.15s, text-shadow 0.2s;
        line-height: 1;
        user-select: none;
        display: inline-block;
        font-weight: 400;
    }
    .star:hover {
        transform: scale(1.15);
    }
    .star.lit {
        color: #c8a951;
        text-shadow: 0 0 8px rgba(200, 169, 81, 0.4);
    }
    .star.pop {
        transform: scale(1.25);
        color: #d4b86a;
    }

    #ratingLabel {
        font-size: 14px;
        color: #666;
        margin-top: 15px;
        min-height: 20px;
        transition: color 0.2s;
        font-weight: 500;
    }
    #ratingLabel.active {
        color: #c8a951;
    }
    #ratingLabel.error {
        color: #dc3545;
        font-weight: 600;
    }

    /* Category Grid */
    .cat-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 35px;
    }
    .cat-label {
        cursor: pointer;
    }
    .cat-pill {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 16px;
        border: 1.5px solid #2a2a2a;
        color: #888;
        font-size: 13px;
        border-radius: 6px;
        transition: all 0.3s ease;
        user-select: none;
        background: transparent;
        font-weight: 500;
    }
    .cat-pill:hover {
        border-color: #444;
        color: #aaa;
        background: rgba(255, 255, 255, 0.02);
    }
    .cat-pill.active {
        border-color: #c8a951;
        color: #fff;
        background: rgba(200, 169, 81, 0.08);
        box-shadow: inset 0 0 12px rgba(200, 169, 81, 0.1);
    }
    .cat-pill svg {
        flex-shrink: 0;
        width: 18px;
        height: 18px;
    }
    .cat-pill.active svg {
        stroke: #c8a951;
    }

    /* Textarea */
    .review-ta {
        width: 100%;
        background: #111;
        border: 1px solid #2a2a2a;
        color: #fff;
        padding: 14px 16px;
        font-size: 14px;
        line-height: 1.7;
        resize: none;
        outline: none;
        font-family: 'Raleway', sans-serif;
        transition: border-color 0.3s, box-shadow 0.3s;
        box-sizing: border-box;
        border-radius: 6px;
    }
    .review-ta:focus {
        border-color: #c8a951;
        box-shadow: 0 0 10px rgba(200, 169, 81, 0.2);
    }
    .review-ta::placeholder {
        color: #555;
    }

    /* Character counter */
    .char-counter {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
        font-size: 12px;
    }
    #charWarn {
        color: transparent;
        transition: color 0.2s;
        font-weight: 600;
    }
    #charWarn.active {
        color: #ffc107;
    }
    .char-count {
        color: #666;
    }

    /* Submit Button */
    .submit-btn {
        width: 100%;
        background: #c8a951;
        color: #fff;
        border: none;
        padding: 16px;
        font-family: 'Raleway', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .submit-btn:hover {
        background: #b8943e;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(200, 169, 81, 0.3);
    }
    .submit-btn:active {
        transform: translateY(0);
        opacity: 0.9;
    }

    /* Error box */
    .error-box {
        border-left: 4px solid #dc3545;
        background: rgba(220, 53, 69, 0.08);
        padding: 16px 18px;
        margin-bottom: 30px;
        border-radius: 4px;
    }
    .error-box p {
        color: #dc3545;
        font-size: 13px;
        margin: 0 0 6px;
        line-height: 1.6;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .error-box p:last-child {
        margin-bottom: 0;
    }
    .error-box i {
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* Skip */
    .skip-link {
        display: block;
        text-align: center;
        color: #666;
        font-size: 13px;
        margin-top: 18px;
        text-decoration: none;
        transition: color 0.2s;
    }
    .skip-link:hover {
        color: #c8a951;
    }

    /* Form section */
    .form-section {
        margin-bottom: 32px;
    }
</style>
@endpush

@section('content')
<div class="review-page">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                {{-- Header --}}
                <div class="review-header">
                    <span class="review-header-label">
                        <i class="fas fa-star" style="margin-right:6px;"></i>Your Feedback
                    </span>
                    <h2 class="review-header-title">
                        Rate Order #{{ $order->id }}
                    </h2>
                    <div class="review-header-meta">
                        <span>
                            <i class="fas fa-shopping-bag" style="margin-right:6px; color:#c8a951;"></i>
                            {{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }}
                        </span>
                        <span style="color:#c8a951;">•</span>
                        <span>
                            <i class="fas fa-tag" style="margin-right:6px; color:#c8a951;"></i>
                            Rs.{{ number_format($order->total_amount, 0) }}
                        </span>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST"
                      action="{{ route('customer.review.store', $order) }}"
                      id="reviewForm"
                      class="review-card">
                    @csrf

                    @if ($errors->any())
                        <div class="error-box">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                @foreach ($errors->all() as $err)
                                    <p style="margin:0 0 4px; display:block;">{{ $err }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Star Rating Section --}}
                    <div class="form-section">
                        <div style="text-align:center;">
                            <span class="flabel" style="margin-bottom:25px;">Your Rating</span>
                            <div class="stars" id="starWrap" role="group" aria-label="Star rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ old('rating', 0) >= $i ? 'lit' : '' }}"
                                          data-val="{{ $i }}"
                                          role="button"
                                          tabindex="0"
                                          aria-label="{{ $i }} {{ $i === 1 ? 'star' : 'stars' }}">★</span>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput"
                                   value="{{ old('rating', 0) }}" required>
                            <div id="ratingLabel" class="{{ old('rating') ? 'active' : '' }}">
                                {{ old('rating') ? ['','Poor','Fair','Good','Great','Excellent'][old('rating')] : 'Click a star to rate' }}
                            </div>
                        </div>
                    </div>

                    {{-- Category Section --}}
                    <div class="form-section">
                        <span class="flabel">What are you rating?</span>
                        <div class="cat-grid">

                            {{-- Food Quality --}}
                            <label class="cat-label">
                                <input type="radio" name="category" value="food"
                                       style="position:absolute;opacity:0;pointer-events:none;"
                                       {{ old('category','food') === 'food' ? 'checked' : '' }}>
                                <div class="cat-pill {{ old('category','food') === 'food' ? 'active' : '' }}" data-val="food">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                                        <path d="M7 2v20"/>
                                        <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3"/>
                                    </svg>
                                    <span>Food Quality</span>
                                </div>
                            </label>

                            {{-- Service --}}
                            <label class="cat-label">
                                <input type="radio" name="category" value="service"
                                       style="position:absolute;opacity:0;pointer-events:none;"
                                       {{ old('category','food') === 'service' ? 'checked' : '' }}>
                                <div class="cat-pill {{ old('category','food') === 'service' ? 'active' : '' }}" data-val="service">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                    <span>Service</span>
                                </div>
                            </label>

                            {{-- Ambiance --}}
                            <label class="cat-label">
                                <input type="radio" name="category" value="ambiance"
                                       style="position:absolute;opacity:0;pointer-events:none;"
                                       {{ old('category','food') === 'ambiance' ? 'checked' : '' }}>
                                <div class="cat-pill {{ old('category','food') === 'ambiance' ? 'active' : '' }}" data-val="ambiance">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2v1M12 21v1M4.22 4.22l.7.7M18.36 18.36l.71.71M2 12h1M21 12h1M4.22 19.78l.7-.7M18.36 5.64l.71-.71"/>
                                        <circle cx="12" cy="12" r="5"/>
                                    </svg>
                                    <span>Ambiance</span>
                                </div>
                            </label>

                            {{-- Value for Money --}}
                            <label class="cat-label">
                                <input type="radio" name="category" value="value"
                                       style="position:absolute;opacity:0;pointer-events:none;"
                                       {{ old('category','food') === 'value' ? 'checked' : '' }}>
                                <div class="cat-pill {{ old('category','food') === 'value' ? 'active' : '' }}" data-val="value">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="1" x2="12" y2="23"/>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                    </svg>
                                    <span>Value</span>
                                </div>
                            </label>

                        </div>
                    </div>

                    {{-- Comment Section --}}
                    <div class="form-section">
                        <label class="flabel" for="reviewComment">
                            <i class="fas fa-comment" style="margin-right:6px;"></i>Your Comment (Optional)
                        </label>
                        <textarea name="comment" id="reviewComment"
                                  class="review-ta" rows="4" maxlength="500"
                                  placeholder="Share your experience with us… (max 500 characters)">{{ old('comment') }}</textarea>
                        <div class="char-counter">
                            <span id="charWarn">
                                <i class="fas fa-exclamation-circle" style="margin-right:4px;"></i>
                                Almost at limit
                            </span>
                            <span class="char-count">
                                <span id="charCount">{{ strlen(old('comment','')) }}</span> / 500
                            </span>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-check"></i>
                        <span>Submit Review</span>
                    </button>

                    <a href="{{ route('customer.orders') }}" class="skip-link">
                        <i class="fas fa-arrow-left" style="margin-right:6px;"></i>
                        Skip for now and view orders
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const LABELS   = ['', 'Poor', 'Fair', 'Good', 'Great', 'Excellent'];
    const stars    = document.querySelectorAll('.star');
    const input    = document.getElementById('ratingInput');
    const label    = document.getElementById('ratingLabel');
    const textarea = document.getElementById('reviewComment');
    const counter  = document.getElementById('charCount');
    const warn     = document.getElementById('charWarn');
    const form     = document.getElementById('reviewForm');

    let selected = parseInt(input.value) || 0;

    function paint(upTo, popIdx) {
        stars.forEach((s, i) => {
            s.classList.toggle('lit',  i < upTo);
            s.classList.toggle('pop',  i === popIdx);
        });
    }

    function choose(val) {
        selected = val;
        input.value = val;
        paint(val);
        label.textContent = LABELS[val] || 'Click a star to rate';
        label.className = val > 0 ? 'active' : '';
    }

    stars.forEach((s, i) => {
        s.addEventListener('mouseenter', () => paint(i + 1, i));
        s.addEventListener('mouseleave', () => paint(selected));
        s.addEventListener('click',      () => choose(i + 1));
        s.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); choose(i + 1); }
        });
    });

    if (selected) paint(selected);

    /* Category pills - click handler */
    document.querySelectorAll('.cat-pill').forEach(pill => {
        pill.addEventListener('click', function () {
            document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            const val = this.dataset.val;
            document.querySelector(`input[value="${val}"]`).checked = true;
            syncIcons();
        });
    });

    /* Sync SVG stroke on active */
    function syncIcons() {
        document.querySelectorAll('.cat-pill').forEach(p => {
            const svg = p.querySelector('svg');
            if (!svg) return;
            svg.style.stroke = p.classList.contains('active') ? '#c8a951' : 'currentColor';
        });
    }
    syncIcons();

    /* Character counter */
    function syncCounter() {
        const n = textarea.value.length;
        counter.textContent = n;
        warn.classList.toggle('active', n > 450);
    }
    textarea.addEventListener('input', syncCounter);
    syncCounter();

    /* Submit guard */
    form.addEventListener('submit', function (e) {
        if (parseInt(input.value) < 1) {
            e.preventDefault();
            label.textContent = 'Please select a rating first';
            label.className = 'error';
            document.getElementById('starWrap').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>
@endpush