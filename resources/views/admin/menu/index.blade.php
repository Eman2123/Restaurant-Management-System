@extends('layouts.admin')
@section('title', 'Menu Items')
@section('page-title', 'Menu Items')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    .menu-wrapper {
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
        --c-accent:         #2563eb;
        --c-accent-soft:    rgba(37,99,235,0.12);
        --header-grad:      linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    body.dark-mode .menu-wrapper,
    body.sidebar-dark-primary .menu-wrapper,
    [data-theme="dark"] .menu-wrapper,
    [data-bs-theme="dark"] .menu-wrapper {
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
        --c-accent:         #4d84ff;
        --c-accent-soft:    rgba(77,132,255,0.14);
    }

    .menu-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
    .menu-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    /* ── Header ── */
    .menu-header {
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
    .menu-header::before {
        content:''; position:absolute; top:-120px; right:-80px;
        width:360px; height:360px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 18s ease-in-out infinite;
    }
    .menu-header::after {
        content:''; position:absolute; bottom:-120px; left:-60px;
        width:300px; height:300px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.10) 0%, transparent 70%);
        animation: float2 14s ease-in-out infinite;
    }
    @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
    @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

    .menu-header-inner {
        position: relative; z-index: 2;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .menu-header-left { display:flex; align-items:center; gap:1.2rem; }
    .menu-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.25);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .menu-header h1 {
        color: white; font-size: 1.9rem; font-weight: 800;
        margin: 0; letter-spacing: -0.5px;
    }
    .menu-header p {
        color: rgba(255,255,255,0.88); font-size: 0.92rem;
        margin: 3px 0 0; font-weight: 500;
    }
    .add-item-btn {
        background: white; color: #16a34a;
        padding: 11px 24px; border-radius: 12px;
        font-weight: 700; font-size: 0.88rem;
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        transition: all 0.25s; text-transform: uppercase; letter-spacing: 0.5px;
        text-decoration: none;
    }
    .add-item-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.25); color: #16a34a; }
    body.dark-mode .add-item-btn { background: rgba(255,255,255,0.18); color: white; }
    [data-bs-theme="dark"] .add-item-btn { background: rgba(255,255,255,0.18); color: white; }

    /* ── Stats ── */
    .stats-section { padding: 0 1.5rem 1.5rem; }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0,1fr));
        gap: 14px; margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .stats-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:500px){ .stats-grid { grid-template-columns: 1fr 1fr; } }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 1.4rem 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative; overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        animation: scaleIn 0.5s ease backwards;
    }
    .stat-card:nth-child(1){ animation-delay:0.05s; }
    .stat-card:nth-child(2){ animation-delay:0.10s; }
    .stat-card:nth-child(3){ animation-delay:0.15s; }
    .stat-card:nth-child(4){ animation-delay:0.20s; }
    @keyframes scaleIn {
        from { opacity:0; transform:scale(0.92) translateY(16px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }
    .stat-card::before {
        content:''; position:absolute;
        top:0; left:0; right:0; height:3px; border-radius:18px 18px 0 0;
    }
    .stat-card.success::before { background: var(--c-success); }
    .stat-card.warning::before { background: var(--c-warning); }
    .stat-card.info::before    { background: var(--c-info); }
    .stat-card.danger::before  { background: var(--c-danger); }
    .stat-card:hover { transform: translateY(-5px); box-shadow: var(--card-hover-shadow); }

    .stat-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .stat-label { font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); }
    .stat-icon-pill { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:0.85rem; }
    .stat-card.success .stat-icon-pill { background:var(--c-success-soft); color:var(--c-success); }
    .stat-card.warning .stat-icon-pill { background:var(--c-warning-soft); color:var(--c-warning); }
    .stat-card.info    .stat-icon-pill { background:var(--c-info-soft);    color:var(--c-info); }
    .stat-card.danger  .stat-icon-pill { background:var(--c-danger-soft);  color:var(--c-danger); }

    .stat-value { font-size:2.6rem; font-weight:800; line-height:1; margin-bottom:0.35rem; font-family:var(--font-mono); }
    .stat-card.success .stat-value { color:var(--c-success); }
    .stat-card.warning .stat-value { color:var(--c-warning); }
    .stat-card.info    .stat-value { color:var(--c-info); }
    .stat-card.danger  .stat-value { color:var(--c-danger); }

    .stat-sub { font-size:0.78rem; font-weight:600; display:flex; align-items:center; gap:5px; }
    .stat-card.success .stat-sub { color:var(--c-success); }
    .stat-card.warning .stat-sub { color:var(--c-warning); }
    .stat-card.info    .stat-sub { color:var(--c-info); }
    .stat-card.danger  .stat-sub { color:var(--c-danger); }

    /* ── Table ── */
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

    .modern-table { width:100%; border-collapse:collapse; }
    .modern-table thead { background: var(--header-grad); }
    .modern-table thead th {
        padding: 1rem 1.2rem;
        font-size: 0.72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.08em;
        color: white; border: none; white-space: nowrap;
    }
    .modern-table tbody tr {
        border-bottom: 1px solid var(--border-color);
        transition: background 0.15s;
        animation: rowSlide 0.35s ease backwards;
    }
    .modern-table tbody tr:nth-child(1){ animation-delay:0.05s; }
    .modern-table tbody tr:nth-child(2){ animation-delay:0.10s; }
    .modern-table tbody tr:nth-child(3){ animation-delay:0.15s; }
    .modern-table tbody tr:nth-child(4){ animation-delay:0.20s; }
    .modern-table tbody tr:nth-child(5){ animation-delay:0.25s; }
    @keyframes rowSlide {
        from { opacity:0; transform:translateX(-12px); }
        to   { opacity:1; transform:translateX(0); }
    }
    .modern-table tbody tr:last-child { border-bottom: none; }
    .modern-table tbody tr:hover { background: var(--table-hover); }
    .modern-table tbody td { padding:1rem 1.2rem; color:var(--text-primary); vertical-align:middle; font-size:0.9rem; }

    .row-number {
        width:32px; height:32px; border-radius:10px;
        background:var(--c-purple-soft); color:var(--c-purple);
        display:inline-flex; align-items:center; justify-content:center;
        font-weight:700; font-size:0.85rem; font-family:var(--font-mono);
    }

    .img-thumb { width:50px; height:50px; border-radius:10px; object-fit:cover; border:2px solid var(--border-color); }
    .img-placeholder {
        width:50px; height:50px; border-radius:10px;
        background:var(--section-bg); display:flex;
        align-items:center; justify-content:center; color:var(--text-muted); font-size:1.2rem;
    }

    .item-name { font-weight:700; font-size:0.95rem; color:var(--text-primary); }

    .info-badge {
        display:inline-flex; align-items:center; gap:6px;
        padding:6px 12px; border-radius:10px;
        font-weight:600; font-size:0.82rem;
        border:1px solid; white-space:nowrap;
    }
    .badge-category { background:var(--c-accent-soft); color:var(--c-accent); border-color:var(--c-accent-soft); }
    .badge-price    { background:var(--c-success-soft); color:var(--c-success); border-color:var(--c-success-soft); font-family:var(--font-mono); }

    .status-badge {
        padding:5px 14px; border-radius:20px;
        font-weight:700; font-size:0.75rem;
        text-transform:uppercase; letter-spacing:0.06em;
        display:inline-flex; align-items:center; gap:6px;
    }
    .status-dot { width:6px; height:6px; border-radius:50%; }
    .status-badge.yes  { background:var(--c-success-soft); color:var(--c-success); }
    .status-badge.yes  .status-dot { background:var(--c-success); }
    .status-badge.no   { background:var(--c-danger-soft);  color:var(--c-danger); }
    .status-badge.no   .status-dot { background:var(--c-danger); }
    .status-badge.feat { background:rgba(234,179,8,0.15); color:#ca8a04; }
    .status-badge.feat .status-dot { background:#ca8a04; }

    .action-buttons { display:flex; gap:6px; }
    .action-btn {
        display:inline-flex; align-items:center; justify-content:center;
        width:32px; height:32px; border-radius:9px;
        border:1px solid var(--border-color);
        background:transparent; cursor:pointer;
        color:var(--text-secondary); font-size:0.8rem;
        transition:all 0.15s; text-decoration:none;
    }
    .action-btn.edit:hover   { background:var(--c-warning-soft); color:var(--c-warning); border-color:var(--c-warning); }
    .action-btn.delete:hover { background:var(--c-danger-soft);  color:var(--c-danger);  border-color:var(--c-danger); }
    .action-btn:hover { transform:translateY(-2px); }

    .empty-state { padding:4rem 2rem; text-align:center; }
    .empty-state i { font-size:3.5rem; color:var(--text-muted); margin-bottom:1rem; display:block; }
    .empty-state h3 { color:var(--text-secondary); font-size:1.1rem; font-weight:600; }
    .empty-state p  { color:var(--text-muted); font-size:0.9rem; margin-top:5px; }

    @media(max-width:768px){
        .menu-header { padding:1.5rem; }
        .menu-header h1 { font-size:1.5rem; }
        .stats-section { padding:0 1rem 1rem; }
        .modern-table thead th,
        .modern-table tbody td { padding:0.75rem 0.8rem; }
    }
</style>
@endpush

@section('content')
<div class="menu-wrapper">

    {{-- ── Header ── --}}
    <div class="menu-header">
        <div class="menu-header-inner">
            <div class="menu-header-left">
                <div class="menu-header-icon">
                    <i class="fas fa-hamburger"></i>
                </div>
                <div>
                    <h1>Menu Items</h1>
                    <p>Manage all food &amp; beverage items</p>
                </div>
            </div>
            <a href="{{ route('admin.menu.create') }}" class="add-item-btn">
                <i class="fas fa-plus"></i>
                <span>Add Menu Item</span>
            </a>
        </div>
    </div>

    {{-- ── Stats + Table ── --}}
    <div class="stats-section">

        {{-- Stats Grid --}}
        <div class="stats-grid">

            <div class="stat-card success">
                <div class="stat-head">
                    <span class="stat-label">Available</span>
                    <span class="stat-icon-pill"><i class="fas fa-check-circle"></i></span>
                </div>
                <div class="stat-value">{{ $menuItems->where('is_available', true)->count() }}</div>
                <div class="stat-sub"><i class="fas fa-arrow-up"></i> Active Items</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-head">
                    <span class="stat-label">Featured</span>
                    <span class="stat-icon-pill"><i class="fas fa-star"></i></span>
                </div>
                <div class="stat-value">{{ $menuItems->where('is_featured', true)->count() }}</div>
                <div class="stat-sub"><i class="fas fa-star"></i> Highlighted</div>
            </div>

            <div class="stat-card info">
                <div class="stat-head">
                    <span class="stat-label">Categories</span>
                    <span class="stat-icon-pill"><i class="fas fa-layer-group"></i></span>
                </div>
                <div class="stat-value">{{ $menuItems->pluck('category_id')->unique()->count() }}</div>
                <div class="stat-sub"><i class="fas fa-th-large"></i> Groups</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-head">
                    <span class="stat-label">Unavailable</span>
                    <span class="stat-icon-pill"><i class="fas fa-ban"></i></span>
                </div>
                <div class="stat-value">{{ $menuItems->where('is_available', false)->count() }}</div>
                <div class="stat-sub"><i class="fas fa-times"></i> Out of Stock</div>
            </div>

        </div>

        {{-- Table --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Available</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menuItems as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}"
                                         class="img-thumb" alt="{{ $item->name }}">
                                @else
                                    <div class="img-placeholder">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="item-name">{{ $item->name }}</span>
                            </td>
                            <td>
                                <span class="info-badge badge-category">
                                    <i class="fas fa-tag"></i>
                                    {{ $item->category->name }}
                                </span>
                            </td>
                            <td>
                                <span class="info-badge badge-price">
                                    Rs.{{ number_format($item->price, 0) }}
                                </span>
                            </td>
                            <td>
                                @if($item->is_available)
                                    <span class="status-badge yes">
                                        <span class="status-dot"></span> Yes
                                    </span>
                                @else
                                    <span class="status-badge no">
                                        <span class="status-dot"></span> No
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($item->is_featured)
                                    <span class="status-badge feat">
                                        <span class="status-dot"></span> ★ Yes
                                    </span>
                                @else
                                    <span class="status-badge no">
                                        <span class="status-dot"></span> No
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.menu.edit', $item) }}"
                                       class="action-btn edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('admin.menu.destroy', $item) }}"
                                          style="display:inline"
                                          onsubmit="return confirm('Delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-hamburger"></i>
                                    <h3>No menu items yet</h3>
                                    <p>Start by adding your first item. <a href="{{ route('admin.menu.create') }}">Add one now</a></p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection