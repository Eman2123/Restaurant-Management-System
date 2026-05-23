@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Menu Categories')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    /* ========== LIGHT THEME ========== */
    .cat-wrapper {
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
        --header-grad:      linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* ========== DARK THEME ========== */
    body.dark-mode .cat-wrapper,
    body.sidebar-dark-primary .cat-wrapper,
    [data-theme="dark"] .cat-wrapper,
    [data-bs-theme="dark"] .cat-wrapper {
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

    /* ========== BASE ========== */
    .cat-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
    .cat-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    /* ========== HEADER ========== */
    .cat-header {
        background: var(--header-grad);
        padding: 2.2rem 2.5rem;
        position: relative; overflow: hidden;
        border-radius: 0 0 24px 24px;
        margin-bottom: 1.5rem;
        animation: slideDown 0.5s ease;
    }
    @keyframes slideDown {
        from { opacity:0; transform:translateY(-20px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .cat-header::before {
        content:''; position:absolute; top:-120px; right:-80px;
        width:360px; height:360px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 18s ease-in-out infinite;
    }
    .cat-header::after {
        content:''; position:absolute; bottom:-120px; left:-60px;
        width:300px; height:300px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.10) 0%, transparent 70%);
        animation: float2 14s ease-in-out infinite;
    }
    @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
    @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

    .cat-header-inner {
        position: relative; z-index: 2;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .cat-header-left { display:flex; align-items:center; gap:1.2rem; }
    .cat-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.25);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .cat-header h1 { color: white; font-size: 1.9rem; font-weight: 800; margin: 0; letter-spacing: -0.5px; }
    .cat-header p  { color: rgba(255,255,255,0.88); font-size: 0.92rem; margin: 3px 0 0; font-weight: 500; }

    .add-cat-btn {
        background: white; color: #1d4ed8;
        padding: 11px 24px; border-radius: 12px;
        font-weight: 700; font-size: 0.88rem;
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        transition: all 0.25s; text-transform: uppercase; letter-spacing: 0.5px;
        text-decoration: none;
    }
    .add-cat-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.25); color: #1d4ed8; }
    body.dark-mode .add-cat-btn  { background: rgba(255,255,255,0.18); color: white; }
    [data-bs-theme="dark"] .add-cat-btn { background: rgba(255,255,255,0.18); color: white; }

    /* ========== STATS ========== */
    .stats-section { padding: 0 1.5rem 1.5rem; }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 14px; margin-bottom: 1.5rem;
    }
    @media(max-width:700px){ .stats-grid { grid-template-columns: 1fr 1fr; } }

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
    @keyframes scaleIn {
        from { opacity:0; transform:scale(0.92) translateY(16px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }
    .stat-card::before {
        content:''; position:absolute;
        top:0; left:0; right:0; height:3px; border-radius:18px 18px 0 0;
    }
    .stat-card.accent::before  { background: var(--c-accent); }
    .stat-card.success::before { background: var(--c-success); }
    .stat-card.danger::before  { background: var(--c-danger); }
    .stat-card:hover { transform: translateY(-5px); box-shadow: var(--card-hover-shadow); }

    .stat-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .stat-label { font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); }
    .stat-icon-pill { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:0.85rem; }
    .stat-card.accent  .stat-icon-pill { background:var(--c-accent-soft);  color:var(--c-accent); }
    .stat-card.success .stat-icon-pill { background:var(--c-success-soft); color:var(--c-success); }
    .stat-card.danger  .stat-icon-pill { background:var(--c-danger-soft);  color:var(--c-danger); }

    .stat-value { font-size:2.6rem; font-weight:800; line-height:1; margin-bottom:0.35rem; font-family:var(--font-mono); }
    .stat-card.accent  .stat-value { color:var(--c-accent); }
    .stat-card.success .stat-value { color:var(--c-success); }
    .stat-card.danger  .stat-value { color:var(--c-danger); }

    .stat-sub { font-size:0.78rem; font-weight:600; display:flex; align-items:center; gap:5px; }
    .stat-card.accent  .stat-sub { color:var(--c-accent); }
    .stat-card.success .stat-sub { color:var(--c-success); }
    .stat-card.danger  .stat-sub { color:var(--c-danger); }

    /* ========== TABLE CARD ========== */
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

    /* Toolbar */
    .tbl-toolbar {
        padding: 1rem 1.4rem;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 10px;
        border-bottom: 1px solid var(--border-color);
    }
    .tbl-toolbar-left { display:flex; align-items:center; gap:10px; }
    .tbl-toolbar-title { font-size:0.88rem; font-weight:700; color:var(--text-primary); display:flex; align-items:center; gap:7px; }
    .tbl-toolbar-title i { color:var(--c-accent); }
    .rec-chip { background:var(--section-bg); border:1px solid var(--border-color); color:var(--text-muted); padding:3px 10px; border-radius:20px; font-size:0.70rem; font-weight:600; }

    .search-box { position:relative; width:210px; }
    .search-box i { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.72rem; pointer-events:none; }
    .search-input { width:100%; background:var(--section-bg); border:1.5px solid var(--border-color); border-radius:8px; padding:7px 10px 7px 28px; font-size:0.80rem; color:var(--text-primary); outline:none; transition:border-color 0.2s, box-shadow 0.2s; }
    .search-input::placeholder { color:var(--text-muted); }
    .search-input:focus { border-color:var(--c-accent); box-shadow:0 0 0 3px var(--c-accent-soft); }

    /* Table */
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
    .cat-name { font-weight:700; font-size:0.95rem; color:var(--text-primary); }

    .info-badge {
        display:inline-flex; align-items:center; gap:6px;
        padding:5px 12px; border-radius:10px;
        font-weight:600; font-size:0.82rem;
        border:1px solid; white-space:nowrap;
    }
    .badge-items { background:var(--c-accent-soft); color:var(--c-accent); border-color:var(--c-accent-soft); }
    .badge-date  { background:var(--c-success-soft); color:var(--c-success); border-color:var(--c-success-soft); }

    .status-badge {
        padding:5px 14px; border-radius:20px;
        font-weight:700; font-size:0.75rem;
        text-transform:uppercase; letter-spacing:0.06em;
        display:inline-flex; align-items:center; gap:6px;
    }
    .status-dot { width:6px; height:6px; border-radius:50%; }
    .status-badge.active   { background:var(--c-success-soft); color:var(--c-success); }
    .status-badge.active   .status-dot { background:var(--c-success); animation: dotPulse 1.4s infinite; }
    .status-badge.inactive { background:var(--c-danger-soft);  color:var(--c-danger); }
    .status-badge.inactive .status-dot { background:var(--c-danger); }
    @keyframes dotPulse { 0%,100%{transform:scale(1);opacity:1;} 50%{transform:scale(1.6);opacity:0.5;} }

    /* Action buttons */
    .action-buttons { display:flex; gap:6px; justify-content:center; }
    .action-btn {
        display:inline-flex; align-items:center; justify-content:center; gap:5px;
        height:34px; padding:0 13px; border-radius:9px;
        border:1px solid var(--border-color);
        background:transparent; cursor:pointer;
        color:var(--text-secondary); font-size:0.78rem; font-weight:600;
        transition:all 0.15s; text-decoration:none; white-space:nowrap;
    }
    .action-btn i { font-size:0.74rem; }
    .action-btn.edit:hover   { background:var(--c-warning-soft); color:var(--c-warning); border-color:var(--c-warning); }
    .action-btn.delete:hover { background:var(--c-danger-soft);  color:var(--c-danger);  border-color:var(--c-danger); }
    .action-btn:hover { transform:translateY(-2px); }

    /* Table footer */
    .tbl-foot {
        padding:12px 20px;
        border-top:1px solid var(--border-color);
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:8px;
        background:var(--section-bg);
    }
    .tbl-foot-info { font-size:0.76rem; color:var(--text-muted); display:flex; align-items:center; gap:5px; }
    .tbl-foot-info i { color:var(--c-accent); }

    /* Empty state */
    .empty-state { padding:4rem 2rem; text-align:center; }
    .empty-state i { font-size:3.5rem; color:var(--text-muted); margin-bottom:1rem; display:block; }
    .empty-state h3 { color:var(--text-secondary); font-size:1.1rem; font-weight:600; }
    .empty-state p  { color:var(--text-muted); font-size:0.9rem; margin-top:5px; }
    .empty-link {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 20px; background:var(--header-grad); color:#fff;
        border-radius:9px; font-size:0.84rem; font-weight:600;
        text-decoration:none; transition:all 0.25s;
        box-shadow:0 3px 10px rgba(37,99,235,0.28); margin-top:12px;
    }
    .empty-link:hover { color:#fff; transform:translateY(-2px); box-shadow:0 6px 18px rgba(37,99,235,0.40); }

    /* ========== DELETE MODAL ========== */
    .cat-overlay {
        display:none; position:fixed; inset:0;
        background:rgba(0,0,0,0.52); z-index:9999;
        align-items:center; justify-content:center;
        backdrop-filter:blur(3px);
    }
    .cat-overlay.show { display:flex; }
    .cat-modal {
        background:var(--card-bg); border:1px solid var(--border-color);
        border-radius:20px; width:100%; max-width:400px;
        margin:16px; overflow:hidden;
        box-shadow:0 24px 60px rgba(0,0,0,0.25);
        animation:modalPop 0.28s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes modalPop {
        from { opacity:0; transform:scale(0.88) translateY(16px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }
    .modal-hd { background:linear-gradient(110deg,#b91c1c,#ef4444); padding:18px 22px; display:flex; align-items:center; gap:12px; }
    .modal-hd-ico { width:38px; height:38px; background:rgba(255,255,255,0.18); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.92rem; flex-shrink:0; }
    .modal-hd h6 { margin:0; color:#fff; font-weight:700; font-size:0.92rem; }
    .modal-hd p  { margin:2px 0 0; color:rgba(255,255,255,0.66); font-size:0.72rem; }
    .modal-bd { padding:20px 22px 0; }
    .modal-bd > p { font-size:0.855rem; color:var(--text-secondary); margin:0 0 6px; line-height:1.6; }
    .modal-cat { font-weight:700; color:var(--text-primary); background:var(--section-bg); border:1px solid var(--border-color); border-radius:8px; padding:6px 13px; font-size:0.875rem; display:inline-block; margin:6px 0 14px; }
    .modal-warn { background:rgba(245,158,11,0.08); border:1px solid rgba(245,158,11,0.20); border-radius:8px; padding:10px 13px; font-size:0.78rem; color:#92400e; display:flex; align-items:flex-start; gap:8px; line-height:1.55; }
    [data-bs-theme="dark"] .modal-warn, body.dark-mode .modal-warn { color:#fbbf24; }
    .modal-warn i { color:#f59e0b; flex-shrink:0; margin-top:2px; }
    .modal-ft { padding:16px 22px 20px; display:flex; gap:10px; }
    .mbt { flex:1; display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:10px 14px; border-radius:9px; font-size:0.845rem; font-weight:600; border:1.5px solid transparent; cursor:pointer; transition:all 0.22s ease; }
    .mbt:hover { transform:translateY(-1px); }
    .mbt-cancel  { background:var(--section-bg); color:var(--text-secondary); border-color:var(--border-color); }
    .mbt-cancel:hover { box-shadow:0 3px 10px rgba(0,0,0,0.08); }
    .mbt-confirm { background:linear-gradient(135deg,#b91c1c,#ef4444); color:#fff; border-color:transparent; box-shadow:0 3px 12px rgba(239,68,68,0.28); }
    .mbt-confirm:hover { box-shadow:0 6px 18px rgba(239,68,68,0.42); }

    /* ========== RESPONSIVE ========== */
    @media(max-width:768px){
        .cat-header { padding:1.5rem; }
        .cat-header h1 { font-size:1.5rem; }
        .stats-section { padding:0 1rem 1rem; }
        .modern-table thead th,
        .modern-table tbody td { padding:0.75rem 0.8rem; }
        .search-box { width:100%; }
        .tbl-toolbar { flex-direction:column; align-items:flex-start; }
    }
    @media(max-width:576px){
        .modern-table th:nth-child(5),
        .modern-table td:nth-child(5) { display:none; }
        .action-btn span { display:none; }
        .action-btn { width:32px; padding:0; }
    }
</style>
@endpush

@section('content')
<div class="cat-wrapper">

    {{-- ── Header ── --}}
    <div class="cat-header">
        <div class="cat-header-inner">
            <div class="cat-header-left">
                <div class="cat-header-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h1>Menu Categories</h1>
                    <p>Organize and manage your food categories</p>
                </div>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="add-cat-btn">
                <i class="fas fa-plus"></i>
                <span>Add Category</span>
            </a>
        </div>
    </div>

    {{-- ── Stats + Table ── --}}
    <div class="stats-section">

        {{-- Stats Grid --}}
        <div class="stats-grid">

            <div class="stat-card accent">
                <div class="stat-head">
                    <span class="stat-label">Total</span>
                    <span class="stat-icon-pill"><i class="fas fa-layer-group"></i></span>
                </div>
                <div class="stat-value">{{ $categories->count() }}</div>
                <div class="stat-sub"><i class="fas fa-th-large"></i> Categories</div>
            </div>

            <div class="stat-card success">
                <div class="stat-head">
                    <span class="stat-label">Active</span>
                    <span class="stat-icon-pill"><i class="fas fa-toggle-on"></i></span>
                </div>
                <div class="stat-value">{{ $categories->where('is_active', true)->count() }}</div>
                <div class="stat-sub"><i class="fas fa-check-circle"></i> Enabled</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-head">
                    <span class="stat-label">Inactive</span>
                    <span class="stat-icon-pill"><i class="fas fa-toggle-off"></i></span>
                </div>
                <div class="stat-value">{{ $categories->where('is_active', false)->count() }}</div>
                <div class="stat-sub"><i class="fas fa-times-circle"></i> Disabled</div>
            </div>

        </div>

        {{-- Table Card --}}
        <div class="table-card">

            {{-- Toolbar --}}
            <div class="tbl-toolbar">
                <div class="tbl-toolbar-left">
                    <div class="tbl-toolbar-title">
                        <i class="fas fa-list"></i>
                        All Categories
                    </div>
                    <span class="rec-chip">
                        {{ $categories->count() }} {{ Str::plural('record', $categories->count()) }}
                    </span>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text"
                           class="search-input"
                           id="catSearch"
                           placeholder="Search by name...">
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="modern-table" id="catTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Menu Items</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="catBody">
                        @forelse($categories as $category)
                        <tr data-name="{{ strtolower($category->name) }}">
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <span class="cat-name">{{ $category->name }}</span>
                            </td>
                            <td>
                                <span class="info-badge badge-items">
                                    <i class="fas fa-utensils" style="font-size:0.65rem;"></i>
                                    {{ $category->menu_items_count }}
                                    {{ Str::plural('Item', $category->menu_items_count) }}
                                </span>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="status-badge active">
                                        <span class="status-dot"></span> Active
                                    </span>
                                @else
                                    <span class="status-badge inactive">
                                        <span class="status-dot"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="info-badge badge-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $category->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="action-btn edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button"
                                            class="action-btn delete"
                                            onclick="openModal('{{ addslashes($category->name) }}', '{{ route('admin.categories.destroy', $category) }}')"
                                            title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-layer-group"></i>
                                    <h3>No Categories Found</h3>
                                    <p>Create your first category to start organizing your menu items</p>
                                    <a href="{{ route('admin.categories.create') }}" class="empty-link">
                                        <i class="fas fa-plus"></i> Add First Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            @if($categories->count() > 0)
            <div class="tbl-foot">
                <span class="tbl-foot-info">
                    <i class="fas fa-info-circle"></i>
                    Showing {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}
                </span>
                @if(method_exists($categories, 'links'))
                    <div>{{ $categories->links() }}</div>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>

{{-- ── Delete Modal ── --}}
<div class="cat-overlay" id="catModal">
    <div class="cat-modal">
        <div class="modal-hd">
            <div class="modal-hd-ico"><i class="fas fa-trash-alt"></i></div>
            <div>
                <h6>Delete Category</h6>
                <p>This action is permanent and cannot be undone</p>
            </div>
        </div>
        <div class="modal-bd">
            <p>You are about to permanently delete:</p>
            <div class="modal-cat" id="modalCatName">—</div>
            <div class="modal-warn">
                <i class="fas fa-exclamation-triangle"></i>
                <span>All menu items linked to this category may be affected. Please reassign them before deleting.</span>
            </div>
        </div>
        <div class="modal-ft">
            <button type="button" class="mbt mbt-cancel" onclick="closeModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <form id="delForm" method="POST" style="flex:1;display:contents;">
                @csrf
                @method('DELETE')
                <button type="submit" class="mbt mbt-confirm">
                    <i class="fas fa-trash-alt"></i> Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Live Search ──
const searchInput = document.getElementById('catSearch');
const rows = document.querySelectorAll('#catBody tr[data-name]');

if (searchInput) {
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach(r => {
            const show = r.dataset.name.includes(q);
            r.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        let noRes = document.getElementById('noResult');
        if (!visible && q) {
            if (!noRes) {
                noRes = document.createElement('tr');
                noRes.id = 'noResult';
                noRes.innerHTML = `<td colspan="6">
                    <div class="empty-state" style="padding:2rem;">
                        <i class="fas fa-search" style="font-size:2rem;"></i>
                        <h3>No match found</h3>
                        <p>No category matches "<strong id="searchQ"></strong>"</p>
                    </div></td>`;
                document.getElementById('catBody').appendChild(noRes);
            }
            document.getElementById('searchQ').textContent = q;
            noRes.style.display = '';
        } else if (noRes) {
            noRes.style.display = 'none';
        }
    });
}

// ── Delete Modal ──
function openModal(name, action) {
    document.getElementById('modalCatName').textContent = name;
    document.getElementById('delForm').action = action;
    document.getElementById('catModal').classList.add('show');
}

function closeModal() {
    document.getElementById('catModal').classList.remove('show');
}

document.getElementById('catModal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});
</script>
@endpush