@extends('layouts.admin')
@section('title', 'Reviews')
@section('page-title', 'Customer Reviews')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    /* ========== LIGHT THEME (Base from Reservations) ========== */
    .reviews-wrapper {
        --card-bg:          #ffffff;
        --card-shadow:      0 2px 12px rgba(0,0,0,0.06);
        --card-hover-shadow:0 12px 40px rgba(0,0,0,0.13);
        --text-primary:     #1a2535;
        --text-secondary:   #4a5568;
        --text-muted:       #94a3b8;
        --section-bg:       #f4f6f9;
        --border-color:     rgba(0,0,0,0.08);
        --table-hover:      #f8fafc;
        --font-main:        'DM Sans', sans-serif;
        --font-mono:        'DM Mono', monospace;
        
        /* Colors */
        --c-success:        #059669;
        --c-success-soft:   rgba(5,150,105,0.12);
        --c-warning:        #d97706;
        --c-warning-soft:   rgba(217,119,6,0.12);
        --c-info:           #0891b2;
        --c-info-soft:      rgba(8,145,178,0.12);
        --c-danger:         #dc2626;
        --c-danger-soft:    rgba(220,38,38,0.12);
        --c-purple:         #7c3aed;
        --c-purple-soft:    rgba(124,58,237,0.12);
        --c-pink:           #db2777;
        --c-pink-soft:      rgba(219,39,119,0.12);
        --c-accent:         #2563eb;
        --c-accent-soft:    rgba(37,99,235,0.12);
        --c-star:           #fbbf24; /* Star Color */
        
        /* Header Gradient: Purple for Reviews (matching theme style) */
        --header-grad:      linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
    }

    /* ========== DARK THEME ========== */
    body.dark-mode .reviews-wrapper,
    body.sidebar-dark-primary .reviews-wrapper,
    [data-theme="dark"] .reviews-wrapper,
    [data-bs-theme="dark"] .reviews-wrapper {
        --card-bg:          #1e2733;
        --card-shadow:      0 2px 12px rgba(0,0,0,0.4);
        --card-hover-shadow:0 12px 40px rgba(0,0,0,0.6);
        --text-primary:     #e4eef8;
        --text-secondary:   #7a9ab8;
        --text-muted:       #4a6278;
        --section-bg:       #141A21;
        --border-color:     rgba(255,255,255,0.07);
        --table-hover:      #243040;
        --c-success:        #10d97f;
        --c-success-soft:   rgba(16,217,127,0.13);
        --c-warning:        #fbbf24;
        --c-warning-soft:   rgba(251,191,36,0.13);
        --c-info:           #22d3ee;
        --c-info-soft:      rgba(34,211,238,0.13);
        --c-danger:         #f87171;
        --c-danger-soft:    rgba(248,113,113,0.13);
        --c-purple:         #a78bfa;
        --c-purple-soft:    rgba(167,139,250,0.13);
        --c-pink:           #f472b6;
        --c-pink-soft:      rgba(244,114,182,0.13);
        --c-accent:         #4d84ff;
        --c-accent-soft:    rgba(77,132,255,0.14);
        --c-star:           #fbbf24;
    }

    /* ========== BASE ========== */
    .reviews-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
    .reviews-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    /* ========== PAGE HEADER ========== */
    .res-header {
        background: var(--header-grad);
        padding: 2.2rem 2.5rem;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 24px 24px;
        margin-bottom: 1.5rem;
        animation: slideDown 0.5s ease;
    }
    @keyframes slideDown {
        from { opacity:0; transform:translateY(-20px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .res-header::before, .res-header::after {
        content:''; position:absolute;
        width:300px; height:300px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        opacity: 0.6;
    }
    .res-header::before { top:-120px; right:-80px; animation: float1 18s ease-in-out infinite; }
    .res-header::after  { bottom:-120px; left:-60px; animation: float2 14s ease-in-out infinite; }
    @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
    @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

    .res-header-inner {
        position: relative; z-index: 2;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .res-header-left { display:flex; align-items:center; gap:1.2rem; }
    .res-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.25);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .res-header h1 {
        color: white; font-size: 1.9rem; font-weight: 800;
        margin: 0; letter-spacing: -0.5px;
    }
    .res-header p {
        color: rgba(255,255,255,0.88); font-size: 0.92rem;
        margin: 3px 0 0; font-weight: 500;
    }

    /* ========== STATS ========== */
    .stats-section { padding: 0 1.5rem 1.5rem; }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0,1fr));
        gap: 14px; margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .stats-grid { grid-template-columns: repeat(2,1fr); } }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 1.4rem 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        animation: scaleIn 0.5s ease backwards;
        cursor: default;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .stat-card.rating-hero { text-align: center; align-items: center; }

    .stat-card:nth-child(1){ animation-delay:0.05s; }
    .stat-card:nth-child(2){ animation-delay:0.10s; }
    .stat-card:nth-child(3){ animation-delay:0.15s; }
    .stat-card:nth-child(4){ animation-delay:0.20s; }
    @keyframes scaleIn {
        from { opacity:0; transform:scale(0.92) translateY(16px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }

    /* Top accent line */
    .stat-card::before {
        content:''; position:absolute; top:0; left:0; right:0; height:3px;
        border-radius:18px 18px 0 0;
    }
    .stat-card.purple::before  { background: var(--c-purple); }
    .stat-card.primary::before { background: var(--c-accent); }
    .stat-card.success::before { background: var(--c-success); }
    .stat-card.warning::before { background: var(--c-warning); }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    /* ── Stat card inner layout ── */
    .stat-head {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem; width: 100%;
    }
    .stat-label {
        font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.08em;
        color: var(--text-muted);
    }
    .stat-icon-pill {
        width: 28px; height: 28px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
    }
    .stat-card.purple  .stat-icon-pill { background: var(--c-purple-soft);  color: var(--c-purple); }
    .stat-card.primary .stat-icon-pill { background: var(--c-accent-soft);  color: var(--c-accent); }
    .stat-card.success .stat-icon-pill { background: var(--c-success-soft); color: var(--c-success); }

    .stat-value {
        font-size: 2.4rem; font-weight: 800;
        line-height: 1; margin-bottom: 0.2rem;
        font-family: var(--font-mono);
    }
    .stat-card.purple  .stat-value { color: var(--c-purple); }
    .stat-card.primary .stat-value { color: var(--c-accent); }
    .stat-card.success .stat-value { color: var(--c-success); }

    .stat-sub {
        font-size: 0.78rem; font-weight: 600;
        display: flex; align-items: center; gap: 5px; justify-content: center;
        color: var(--c-star); /* For stars */
    }

    /* Rating Breakdown Specifics */
    .breakdown-list { display: flex; flex-direction: column; gap: 8px; width: 100%; }
    .rating-bar-row { display: flex; align-items: center; gap: 10px; }
    .bar-label { font-size: 0.75rem; font-weight: 700; color: var(--c-star); width: 25px; }
    .bar-track { flex: 1; height: 8px; background: var(--section-bg); border-radius: 4px; overflow: hidden; }
    .bar-fill { height: 100%; background: var(--c-star); border-radius: 4px; }
    .bar-count { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); width: 25px; text-align: right; }

    /* ========== REVIEWS LIST (Like Table) ========== */
    .table-card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        animation: fadeInUp 0.5s ease 0.2s both;
    }
    @keyframes fadeInUp {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .review-row {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        transition: background 0.15s;
        animation: rowSlide 0.35s ease backwards;
    }
    .review-row:last-child { border-bottom: none; }
    .review-row:hover { background: var(--table-hover); }
    
    .review-row:nth-child(1){ animation-delay:0.05s; }
    .review-row:nth-child(2){ animation-delay:0.10s; }
    .review-row:nth-child(3){ animation-delay:0.15s; }
    .review-row:nth-child(4){ animation-delay:0.20s; }
    @keyframes rowSlide {
        from { opacity:0; transform:translateX(-12px); }
        to   { opacity:1; transform:translateX(0); }
    }

    /* Review Components */
    .review-avatar {
        width: 50px; height: 50px; border-radius: 50%;
        background: var(--c-purple-soft); color: var(--c-purple);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1.2rem; flex-shrink: 0;
    }

    .review-content { flex: 1; }
    .review-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .reviewer-name { font-weight: 700; font-size: 1rem; color: var(--text-primary); }
    .review-date { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }
    
    .review-stars { color: var(--c-star); font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 0.5rem; }
    .review-comment { color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; font-style: italic; }

    .review-actions { display: flex; align-items: center; }
    .btn-delete {
        color: var(--c-danger); background: transparent;
        border: 1px solid var(--c-danger-soft);
        padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700;
        transition: all 0.2s; cursor: pointer;
    }
    .btn-delete:hover { background: var(--c-danger-soft); }

    /* Empty State */
    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-state i { font-size: 3.5rem; color: var(--text-muted); margin-bottom: 1rem; display:block; }
    .empty-state h3 { color: var(--text-secondary); font-size: 1.1rem; font-weight: 600; margin: 0; }
    
    /* Responsive */
    @media(max-width:768px){
        .res-header { padding:1.5rem; }
        .res-header h1 { font-size:1.5rem; }
        .stats-section { padding: 0 1rem 1rem; }
        .review-row { flex-direction: column; gap: 1rem; padding: 1.5rem; }
        .review-header { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        .review-actions { width: 100%; justify-content: flex-end; }
    }
</style>
@endpush

@section('content')
<div class="reviews-wrapper">

    {{-- ── Header (Purple Theme) ── --}}
    <div class="res-header">
        <div class="res-header-inner">
            <div class="res-header-left">
                <div class="res-header-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <h1>Customer Reviews</h1>
                    <p>Manage feedback &amp; customer ratings</p>
                </div>
            </div>
            {{-- Optional Export button or other actions can go here --}}
        </div>
    </div>

    {{-- ── Stats + List ── --}}
    <div class="stats-section">

        {{-- Stats Grid --}}
        <div class="stats-grid">

            {{-- 1. Average Rating (Hero) --}}
            <div class="stat-card purple rating-hero">
                <div class="stat-value">{{ number_format($stats['avg'], 1) ?: '0.0' }}</div>
                <div class="stat-label" style="margin: 0.5rem 0;">Average Rating</div>
                <div class="stat-sub">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= round($stats['avg']) ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>
            </div>

            {{-- 2. Total Reviews --}}
            <div class="stat-card primary">
                <div class="stat-head">
                    <span class="stat-label">Total Reviews</span>
                    <span class="stat-icon-pill"><i class="fas fa-comments"></i></span>
                </div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-sub" style="color: var(--c-accent);"><i class="fas fa-list"></i> All time</div>
            </div>

            {{-- 3. Five Star Reviews --}}
            <div class="stat-card success">
                <div class="stat-head">
                    <span class="stat-label">5 Stars</span>
                    <span class="stat-icon-pill"><i class="fas fa-thumbs-up"></i></span>
                </div>
                <div class="stat-value">{{ $stats['five'] }}</div>
                <div class="stat-sub" style="color: var(--c-success);"><i class="fas fa-check"></i> Excellent</div>
            </div>

            {{-- 4. Rating Breakdown --}}
            <div class="stat-card warning">
                <div class="stat-head">
                    <span class="stat-label">Breakdown</span>
                    <span class="stat-icon-pill"><i class="fas fa-chart-bar"></i></span>
                </div>
                <div class="breakdown-list">
                    @foreach([5 => $stats['five'], 4 => $stats['four'], 3 => $stats['three'], 2 => 0, 1 => 0] as $rating => $count)
                    <div class="rating-bar-row">
                        <div class="bar-label">{{ $rating }} <i class="fas fa-star" style="font-size: 0.6rem;"></i></div>
                        <div class="bar-track">
                            <div class="bar-fill" 
                                 style="width: {{ $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0 }}%">
                            </div>
                        </div>
                        <div class="bar-count">{{ $count }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Reviews List (Table Style) --}}
        <div class="table-card">
            @forelse($reviews as $review)
            <div class="review-row">
                <!-- Avatar -->
                <div class="review-avatar">
                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                </div>

                <!-- Content -->
                <div class="review-content">
                    <div class="review-header">
                        <div>
                            <div class="reviewer-name">{{ $review->user->name }}</div>
                            <div class="review-stars">
                                @for($i=1; $i<=5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="review-date">
                            {{ $review->created_at->diffForHumans() }}
                        </div>
                    </div>
                    
                    @if($review->comment)
                    <div class="review-comment">
                        "{{ $review->comment }}"
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="review-actions">
                    <form method="POST"
                          action="{{ route('admin.reviews.destroy', $review) }}"
                          onsubmit="return confirm('Delete this review?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="far fa-star"></i>
                <h3>No reviews found</h3>
                <p style="color:var(--text-muted);">Customers haven't left any feedback yet.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection