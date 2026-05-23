@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'All Orders')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

  /* ========== LIGHT THEME ========== */
  .orders-wrapper {
    --card-bg:           #ffffff;
    --card-shadow:       0 2px 12px rgba(0,0,0,0.06);
    --card-hover-shadow: 0 12px 40px rgba(0,0,0,0.13);
    --text-primary:      #1a2535;
    --text-secondary:    #4a5568;
    --text-muted:        #94a3b8;
    --section-bg:        #f4f6f9;
    --border-color:      rgba(0,0,0,0.08);
    --table-hover:       #f8fafc;
    --font-main:         'DM Sans', sans-serif;
    --font-mono:         'DM Mono', monospace;
    --c-success:         #059669;
    --c-success-soft:    rgba(5,150,105,0.12);
    --c-warning:         #d97706;
    --c-warning-soft:    rgba(217,119,6,0.12);
    --c-info:            #0891b2;
    --c-info-soft:       rgba(8,145,178,0.12);
    --c-danger:          #dc2626;
    --c-danger-soft:     rgba(220,38,38,0.12);
    --c-purple:          #7c3aed;
    --c-purple-soft:     rgba(124,58,237,0.12);
    --c-pink:            #db2777;
    --c-pink-soft:       rgba(219,39,119,0.12);
    --c-accent:          #2563eb;
    --c-accent-soft:     rgba(37,99,235,0.12);
    --c-teal:            #0891b2;
    --c-teal-soft:       rgba(8,145,178,0.12);
    --c-orange:          #d97706;
    --c-orange-soft:     rgba(217,119,6,0.12);
    --header-grad:       linear-gradient(135deg, #2d6ef5 0%, #1a57d6 100%);
  }

  /* ========== DARK THEME ========== */
  body.dark-mode .orders-wrapper,
  body.sidebar-dark-primary .orders-wrapper,
  [data-theme="dark"] .orders-wrapper,
  [data-bs-theme="dark"] .orders-wrapper {
    --card-bg:           #1e2733;
    --card-shadow:       0 2px 12px rgba(0,0,0,0.4);
    --card-hover-shadow: 0 12px 40px rgba(0,0,0,0.6);
    --text-primary:      #e4eef8;
    --text-secondary:    #7a9ab8;
    --text-muted:        #4a6278;
    --section-bg:        #141A21;
    --border-color:      rgba(255,255,255,0.07);
    --table-hover:       #243040;
    --c-success:         #10d97f;
    --c-success-soft:    rgba(16,217,127,0.13);
    --c-warning:         #fbbf24;
    --c-warning-soft:    rgba(251,191,36,0.13);
    --c-info:            #22d3ee;
    --c-info-soft:       rgba(34,211,238,0.13);
    --c-danger:          #f87171;
    --c-danger-soft:     rgba(248,113,113,0.13);
    --c-purple:          #a78bfa;
    --c-purple-soft:     rgba(167,139,250,0.13);
    --c-pink:            #f472b6;
    --c-pink-soft:       rgba(244,114,182,0.13);
    --c-accent:          #4d84ff;
    --c-accent-soft:     rgba(77,132,255,0.14);
    --c-teal:            #22d3ee;
    --c-teal-soft:       rgba(34,211,238,0.13);
    --c-orange:          #fbbf24;
    --c-orange-soft:     rgba(251,191,36,0.13);
  }

  /* ========== BASE ========== */
  .orders-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
  .orders-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
  @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

  /* ========== PAGE HEADER (gradient, like reservations) ========== */
  .orders-header {
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
  .orders-header::before {
    content:'';
    position:absolute; top:-120px; right:-80px;
    width:360px; height:360px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
    animation: float1 18s ease-in-out infinite;
  }
  .orders-header::after {
    content:'';
    position:absolute; bottom:-120px; left:-60px;
    width:300px; height:300px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    animation: float2 14s ease-in-out infinite;
  }
  @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
  @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

  .orders-header-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 1rem;
  }
  .orders-header-left { display:flex; align-items:center; gap:1.2rem; }
  .orders-header-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.22);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: white;
    border: 2px solid rgba(255,255,255,0.28);
  }
  .orders-header h1 {
    color: white; font-size: 1.9rem; font-weight: 800;
    margin: 0; letter-spacing: -0.5px;
  }
  .orders-header p {
    color: rgba(255,255,255,0.85); font-size: 0.92rem;
    margin: 3px 0 0; font-weight: 500;
  }

  /* Live badge */
  .live-indicator {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.18);
    color: white;
    font-size: 11px; font-weight: 700;
    padding: 5px 12px; border-radius: 20px;
    letter-spacing: 0.06em;
    border: 1px solid rgba(255,255,255,0.3);
  }
  .live-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #ff4d4d;
    animation: livePulse 1.4s infinite;
    box-shadow: 0 0 0 2px rgba(255,77,77,0.3);
  }
  @keyframes livePulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:0.4; transform:scale(1.5); }
  }

  .header-actions { display:flex; align-items:center; gap:10px; }

  .btn-new-order {
    background: white;
    color: #2d6ef5;
    padding: 11px 22px; border-radius: 12px;
    font-weight: 700; font-size: 0.88rem;
    border: none; cursor: pointer;
    display: inline-flex; align-items: center; gap: 8px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.18);
    transition: all 0.25s; text-transform: uppercase; letter-spacing: 0.5px;
    text-decoration: none;
  }
  .btn-new-order:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.22);
    color: #1a57d6;
    text-decoration: none;
  }
  body.dark-mode .btn-new-order,
  [data-bs-theme="dark"] .btn-new-order {
    background: rgba(255,255,255,0.18); color: white;
  }

  /* ========== STATS SECTION ========== */
  .stats-section { padding: 0 1.5rem 1.5rem; }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0,1fr));
    gap: 14px;
    margin-bottom: 1.5rem;
  }
  @media(max-width:1100px){ .stats-grid { grid-template-columns: repeat(3,1fr); } }
  @media(max-width:600px){  .stats-grid { grid-template-columns: repeat(2,1fr); } }

  .stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 1.3rem 1.2rem;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    animation: scaleIn 0.5s ease backwards;
    cursor: pointer;
    text-decoration: none;
    display: block;
  }
  .stat-card:nth-child(1){ animation-delay:0.05s; }
  .stat-card:nth-child(2){ animation-delay:0.10s; }
  .stat-card:nth-child(3){ animation-delay:0.15s; }
  .stat-card:nth-child(4){ animation-delay:0.20s; }
  .stat-card:nth-child(5){ animation-delay:0.25s; }
  .stat-card:nth-child(6){ animation-delay:0.30s; }
  @keyframes scaleIn {
    from { opacity:0; transform:scale(0.92) translateY(16px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
  }

  /* Top accent stripe */
  .stat-card::before {
    content:''; position:absolute;
    top:0; left:0; right:0; height:3px;
    border-radius:18px 18px 0 0;
    transform: scaleX(0); transform-origin: left;
    transition: transform 0.6s cubic-bezier(0.4,0,0.2,1);
  }
  .stat-card.loaded::before { transform: scaleX(1); }
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--card-hover-shadow);
  }
  .stat-card.active {
    box-shadow: var(--card-hover-shadow);
  }

  /* Color variants */
  .sc-total::before   { background: var(--c-accent); }
  .sc-total.active    { border-color: var(--c-accent); box-shadow: 0 0 0 3px var(--c-accent-soft), var(--card-hover-shadow); }
  .sc-pending::before { background: var(--c-orange); }
  .sc-pending.active  { border-color: var(--c-orange); box-shadow: 0 0 0 3px var(--c-orange-soft), var(--card-hover-shadow); }
  .sc-cooking::before { background: var(--c-danger); }
  .sc-cooking.active  { border-color: var(--c-danger); box-shadow: 0 0 0 3px var(--c-danger-soft), var(--card-hover-shadow); }
  .sc-ready::before   { background: var(--c-success); }
  .sc-ready.active    { border-color: var(--c-success); box-shadow: 0 0 0 3px var(--c-success-soft), var(--card-hover-shadow); }
  .sc-served::before  { background: var(--c-teal); }
  .sc-served.active   { border-color: var(--c-teal); box-shadow: 0 0 0 3px var(--c-teal-soft), var(--card-hover-shadow); }
  .sc-unpaid::before  { background: var(--c-pink); }
  .sc-unpaid.active   { border-color: var(--c-pink); box-shadow: 0 0 0 3px var(--c-pink-soft), var(--card-hover-shadow); }

  .stat-head {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 0.9rem;
  }
  .stat-label {
    font-size: 0.70rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-muted);
  }
  .stat-icon-pill {
    width: 32px; height: 32px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
  }
  .sc-total  .stat-icon-pill { background: var(--c-accent-soft);  color: var(--c-accent); }
  .sc-pending .stat-icon-pill { background: var(--c-orange-soft); color: var(--c-orange); }
  .sc-cooking .stat-icon-pill { background: var(--c-danger-soft); color: var(--c-danger); }
  .sc-ready   .stat-icon-pill { background: var(--c-success-soft);color: var(--c-success); }
  .sc-served  .stat-icon-pill { background: var(--c-teal-soft);   color: var(--c-teal); }
  .sc-unpaid  .stat-icon-pill { background: var(--c-pink-soft);   color: var(--c-pink); }

  .stat-value {
    font-size: 2.5rem; font-weight: 800;
    line-height: 1; margin-bottom: 0.3rem;
    font-family: var(--font-mono);
  }
  .sc-total  .stat-value { color: var(--c-accent); }
  .sc-pending .stat-value { color: var(--c-orange); }
  .sc-cooking .stat-value { color: var(--c-danger); }
  .sc-ready   .stat-value { color: var(--c-success); }
  .sc-served  .stat-value { color: var(--c-teal); }
  .sc-unpaid  .stat-value { color: var(--c-pink); }

  .stat-sub {
    font-size: 0.75rem; font-weight: 600;
    display: flex; align-items: center; gap: 5px;
  }
  .sc-total  .stat-sub { color: var(--c-accent); }
  .sc-pending .stat-sub { color: var(--c-orange); }
  .sc-cooking .stat-sub { color: var(--c-danger); }
  .sc-ready   .stat-sub { color: var(--c-success); }
  .sc-served  .stat-sub { color: var(--c-teal); }
  .sc-unpaid  .stat-sub { color: var(--c-pink); }

  /* ========== TOOLBAR ========== */
  .toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 1rem;
    flex-wrap: wrap;
  }
  .filter-pills { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }

  .pill {
    padding: 7px 16px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
    cursor: pointer;
    border: 1px solid var(--border-color);
    background: var(--card-bg);
    color: var(--text-secondary);
    transition: all 0.2s; white-space: nowrap;
    text-decoration: none; display: inline-block;
  }
  .pill:hover {
    border-color: rgba(0,0,0,0.18);
    color: var(--text-primary);
    background: var(--table-hover);
    transform: translateY(-1px);
    text-decoration: none;
  }
  .pill.active {
    background: var(--c-accent);
    border-color: var(--c-accent);
    color: #fff;
    box-shadow: 0 3px 10px rgba(37,99,235,0.3);
  }
  .pill.pill-unpaid.active {
    background: var(--c-pink);
    border-color: var(--c-pink);
    box-shadow: 0 3px 10px rgba(219,39,119,0.3);
  }

  .toolbar-right { display: flex; gap: 8px; align-items: center; }

  .search-wrap { position: relative; display: flex; align-items: center; }
  .search-wrap svg {
    position: absolute; left: 11px;
    color: var(--text-muted); pointer-events: none;
  }
  .search-input {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 8px 12px 8px 34px;
    font-size: 13px; color: var(--text-primary);
    outline: none; width: 200px;
    transition: all 0.2s;
    font-family: var(--font-main);
    box-shadow: var(--card-shadow);
  }
  .search-input::placeholder { color: var(--text-muted); }
  .search-input:focus {
    border-color: var(--c-accent);
    box-shadow: 0 0 0 3px var(--c-accent-soft);
    width: 240px;
  }

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

  /* ========== TABLE ========== */
  .orders-table { width:100%; border-collapse:collapse; }
  .orders-table thead {
    background: var(--header-grad);
  }
  .orders-table thead th {
    padding: 1rem 1.2rem;
    font-size: 0.72rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: white; border: none; white-space: nowrap;
    text-align: left;
  }
  .orders-table tbody tr {
    border-bottom: 1px solid var(--border-color);
    transition: background 0.15s;
    animation: rowSlide 0.35s ease backwards;
  }
  .orders-table tbody tr:nth-child(1){ animation-delay:0.05s; }
  .orders-table tbody tr:nth-child(2){ animation-delay:0.10s; }
  .orders-table tbody tr:nth-child(3){ animation-delay:0.15s; }
  .orders-table tbody tr:nth-child(4){ animation-delay:0.20s; }
  .orders-table tbody tr:nth-child(5){ animation-delay:0.25s; }
  @keyframes rowSlide {
    from { opacity:0; transform:translateX(-12px); }
    to   { opacity:1; transform:translateX(0); }
  }
  .orders-table tbody tr:last-child { border-bottom: none; }
  .orders-table tbody tr:hover { background: var(--table-hover); }
  .orders-table tbody td {
    padding: 1rem 1.2rem;
    color: var(--text-primary); vertical-align: middle;
    font-size: 0.9rem;
  }

  /* ─── Order ID ─── */
  .order-id {
    font-family: var(--font-mono);
    font-size: 0.85rem; font-weight: 600;
    color: var(--c-accent);
    background: var(--c-accent-soft);
    padding: 4px 10px; border-radius: 9px;
    letter-spacing: 0.03em;
    display: inline-block;
  }

  /* ─── Customer ─── */
  .customer-cell { display:flex; align-items:center; gap:12px; }
  .avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--c-pink-soft); color: var(--c-pink);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1rem; flex-shrink:0;
    border: 2px solid var(--c-pink-soft);
  }
  .customer-name { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); }

  /* ─── Info badges ─── */
  .info-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px; border-radius: 10px;
    font-weight: 600; font-size: 0.80rem;
    border: 1px solid; white-space: nowrap;
  }
  .badge-table  { background:var(--c-accent-soft);  color:var(--c-accent);  border-color:var(--c-accent-soft);  font-family:var(--font-mono); }
  .badge-amount { background:var(--c-success-soft); color:var(--c-success); border-color:var(--c-success-soft); font-family:var(--font-mono); }

  /* ─── Badges ─── */
  .badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 20px;
    font-size: 0.74rem; font-weight: 700;
    white-space: nowrap; letter-spacing: 0.03em;
    text-transform: uppercase;
  }
  .bdot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }

  .badge-pending   { background:var(--c-warning-soft); color:var(--c-warning); }
  .bdot-pending    { background:var(--c-warning); }
  .badge-cooking   { background:var(--c-danger-soft);  color:var(--c-danger); }
  .bdot-cooking    { background:var(--c-danger); animation:livePulse 1.2s infinite; }
  .badge-ready     { background:var(--c-success-soft); color:var(--c-success); }
  .bdot-ready      { background:var(--c-success); }
  .badge-served    { background:var(--c-teal-soft);    color:var(--c-teal); }
  .bdot-served     { background:var(--c-teal); }
  .badge-cancelled { background:rgba(100,116,139,0.12); color:#64748b; }

  .badge-paid   { background:var(--c-success-soft); color:var(--c-success); }
  .badge-unpaid { background:var(--c-warning-soft); color:var(--c-warning); }

  .badge-dine     { background:var(--c-purple-soft); color:var(--c-purple); }
  .badge-takeaway { background:var(--c-accent-soft); color:var(--c-accent); }
  .badge-delivery { background:var(--c-teal-soft);   color:var(--c-teal); }

  /* ─── Action buttons ─── */
  .action-buttons { display:flex; gap:6px; }
  .action-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 32px; height: 32px; border-radius: 9px;
    border: 1px solid var(--border-color);
    background: transparent; cursor: pointer;
    color: var(--text-secondary); font-size: 0.8rem;
    transition: all 0.15s; text-decoration: none;
  }
  .action-btn:hover { transform: translateY(-2px); }
  .action-btn.view:hover   { background:var(--c-info-soft);   color:var(--c-info);   border-color:var(--c-info); }
  .action-btn.del:hover    { background:var(--c-danger-soft); color:var(--c-danger); border-color:var(--c-danger); }

  /* ─── Row number ─── */
  .row-number {
    width: 32px; height: 32px; border-radius: 10px;
    background: var(--c-purple-soft); color: var(--c-purple);
    display: inline-flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.85rem;
    font-family: var(--font-mono);
  }

  /* ─── Empty state ─── */
  .empty-state { padding: 4rem 2rem; text-align:center; }
  .empty-state i { font-size: 3.5rem; color: var(--text-muted); margin-bottom: 1rem; display:block; }
  .empty-state h3 { color: var(--text-secondary); font-size: 1.1rem; font-weight: 600; }
  .empty-state p  { color: var(--text-muted); font-size: 0.9rem; margin-top: 5px; }

  /* ─── Table footer ─── */
  .table-footer {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid var(--border-color);
    background: rgba(255,255,255,0.02);
    font-size: 12px; color: var(--text-muted);
    flex-wrap: wrap; gap: 8px;
  }

  /* ─── Responsive ─── */
  @media(max-width:768px){
    .orders-header { padding:1.5rem; }
    .orders-header h1 { font-size:1.5rem; }
    .stats-section { padding: 0 1rem 1rem; }
    .orders-table thead th,
    .orders-table tbody td { padding: 0.75rem 0.8rem; }
  }
</style>
@endpush

@section('content')
<div class="orders-wrapper" id="ordersPage">

  {{-- ── Gradient Header ── --}}
  <div class="orders-header">
    <div class="orders-header-inner">
      <div class="orders-header-left">
        <div class="orders-header-icon">
          <i class="fas fa-receipt"></i>
        </div>
        <div>
          <h1>All Orders</h1>
          <p>Manage and track all restaurant orders in real-time</p>
        </div>
      </div>
      <div class="header-actions">
        <span class="live-indicator">
          <span class="live-dot"></span>LIVE
        </span>
        <a href="{{ route('admin.orders.create') }}" class="btn-new-order">
          <i class="fas fa-plus"></i>
          New Order
        </a>
      </div>
    </div>
  </div>

  {{-- ── Stats + Table ── --}}
  <div class="stats-section">

    {{-- Stats Grid --}}
    <div class="stats-grid" id="statsGrid">

      <a href="{{ route('admin.orders.index') }}" style="text-decoration:none"
         class="stat-card sc-total {{ !request('status') && !request('payment') ? 'active' : '' }}">
        <div class="stat-head">
          <span class="stat-label">Total Orders</span>
          <span class="stat-icon-pill">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $stats['total'] ?? 0 }}">0</div>
        <div class="stat-sub">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          All time
        </div>
      </a>

      <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" style="text-decoration:none"
         class="stat-card sc-pending {{ request('status') === 'pending' ? 'active' : '' }}">
        <div class="stat-head">
          <span class="stat-label">Pending</span>
          <span class="stat-icon-pill">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $stats['pending'] ?? 0 }}">0</div>
        <div class="stat-sub">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          Waiting
        </div>
      </a>

      <a href="{{ route('admin.orders.index', ['status' => 'cooking']) }}" style="text-decoration:none"
         class="stat-card sc-cooking {{ request('status') === 'cooking' ? 'active' : '' }}">
        <div class="stat-head">
          <span class="stat-label">Cooking</span>
          <span class="stat-icon-pill">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $stats['cooking'] ?? 0 }}">0</div>
        <div class="stat-sub">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          In kitchen
        </div>
      </a>

      <a href="{{ route('admin.orders.index', ['status' => 'ready']) }}" style="text-decoration:none"
         class="stat-card sc-ready {{ request('status') === 'ready' ? 'active' : '' }}">
        <div class="stat-head">
          <span class="stat-label">Ready</span>
          <span class="stat-icon-pill">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $stats['ready'] ?? 0 }}">0</div>
        <div class="stat-sub">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
          To serve
        </div>
      </a>

      <a href="{{ route('admin.orders.index', ['status' => 'served']) }}" style="text-decoration:none"
         class="stat-card sc-served {{ request('status') === 'served' ? 'active' : '' }}">
        <div class="stat-head">
          <span class="stat-label">Served</span>
          <span class="stat-icon-pill">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $stats['served'] ?? 0 }}">0</div>
        <div class="stat-sub">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
          Done
        </div>
      </a>

      <a href="{{ route('admin.orders.index', ['payment' => 'unpaid']) }}" style="text-decoration:none"
         class="stat-card sc-unpaid {{ request('payment') === 'unpaid' ? 'active' : '' }}">
        <div class="stat-head">
          <span class="stat-label">Unpaid</span>
          <span class="stat-icon-pill">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/></svg>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $stats['unpaid'] ?? 0 }}">0</div>
        <div class="stat-sub">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
          Pending
        </div>
      </a>

    </div>

    {{-- ── Toolbar ── --}}
    <div class="toolbar" style="margin-bottom:1rem;">
      <div class="filter-pills">
        <a href="{{ route('admin.orders.index') }}"
           class="pill {{ !request('status') && !request('payment') ? 'active' : '' }}">All</a>
        @foreach(['pending','cooking','ready','served','cancelled'] as $s)
        <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
           class="pill {{ request('status') === $s ? 'active' : '' }}">{{ ucfirst($s) }}</a>
        @endforeach
        <a href="{{ route('admin.orders.index', ['payment' => 'unpaid']) }}"
           class="pill pill-unpaid {{ request('payment') === 'unpaid' ? 'active' : '' }}">Unpaid</a>
      </div>
      <div class="toolbar-right">
        <div class="search-wrap">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input
            type="text"
            class="search-input"
            placeholder="Search by ID or customer…"
            id="liveSearch"
            value="{{ request('search') }}"
            oninput="liveSearch(this.value)"
          >
        </div>
      </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="table-card">
      <div class="table-responsive">
        <table class="orders-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Order</th>
              <th>Customer</th>
              <th>Table</th>
              <th>Type</th>
              <th>Items</th>
              <th>Total</th>
              <th>Payment</th>
              <th>Status</th>
              <th>Time</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="ordersTableBody">
            @forelse($orders as $i => $order)
            @php
              $initials = $order->user
                ? collect(explode(' ', $order->user->name))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('')
                : 'GU';

              $typeMap = [
                'dine_in'  => ['label'=>'Dine In',   'class'=>'badge-dine'],
                'takeaway' => ['label'=>'Takeaway',  'class'=>'badge-takeaway'],
                'delivery' => ['label'=>'Delivery',  'class'=>'badge-delivery'],
              ];
              $typeInfo = $typeMap[$order->order_type ?? 'dine_in'] ?? $typeMap['dine_in'];

              $statusMap = [
                'pending'   => ['label'=>'Pending',   'class'=>'badge-pending',  'dot'=>'bdot-pending'],
                'cooking'   => ['label'=>'Cooking',   'class'=>'badge-cooking',  'dot'=>'bdot-cooking'],
                'ready'     => ['label'=>'Ready',     'class'=>'badge-ready',    'dot'=>'bdot-ready'],
                'served'    => ['label'=>'Served',    'class'=>'badge-served',   'dot'=>'bdot-served'],
                'cancelled' => ['label'=>'Cancelled', 'class'=>'badge-cancelled','dot'=>''],
              ];
              $statusInfo = $statusMap[$order->status] ?? $statusMap['served'];
            @endphp
            <tr data-search="{{ strtolower($order->user->name ?? 'guest') }} {{ $order->id }}">
              <td>
                <span class="row-number">{{ $i + 1 }}</span>
              </td>
              <td>
                <span class="order-id">#{{ $order->id }}</span>
              </td>
              <td>
                <div class="customer-cell">
                  <div class="avatar">{{ $initials }}</div>
                  <span class="customer-name">{{ $order->user->name ?? 'Guest' }}</span>
                </div>
              </td>
              <td>
                @if($order->table)
                  <span class="info-badge badge-table">
                    <i class="fas fa-chair" style="font-size:11px"></i>
                    #{{ $order->table->table_number }}
                  </span>
                @else
                  <span style="color:var(--text-muted);font-family:var(--font-mono);font-size:13px">—</span>
                @endif
              </td>
              <td>
                <span class="badge {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
              </td>
              <td>
                <span style="background:var(--c-purple-soft);color:var(--c-purple);padding:4px 10px;border-radius:9px;font-family:var(--font-mono);font-size:13px;font-weight:600;">
                  {{ $order->orderItems->count() }}
                </span>
              </td>
              <td>
                <span class="info-badge badge-amount">
                  <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                  Rs.{{ number_format($order->total_amount, 0) }}
                </span>
              </td>
              <td>
                @if($order->payment_status === 'paid')
                  <span class="badge badge-paid">
                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                    Paid
                  </span>
                @else
                  <span class="badge badge-unpaid">
                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    Unpaid
                  </span>
                @endif
              </td>
              <td>
                <span class="badge {{ $statusInfo['class'] }}">
                  @if($statusInfo['dot'])
                    <span class="bdot {{ $statusInfo['dot'] }}"></span>
                  @endif
                  {{ $statusInfo['label'] }}
                </span>
              </td>
              <td>
                <span style="font-size:12px;color:var(--text-muted);">
                  {{ $order->created_at->format('d M, h:i A') }}
                </span>
              </td>
              <td>
                <div class="action-buttons">
                  <a href="{{ route('admin.orders.show', $order) }}"
                     class="action-btn view" title="View Order">
                    <i class="fas fa-eye"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                        style="display:inline"
                        onsubmit="return confirm('Delete Order #{{ $order->id }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-btn del" title="Delete Order">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="11">
                <div class="empty-state">
                  <i class="fas fa-shopping-cart"></i>
                  <h3>No orders found</h3>
                  <p>Try changing the filter or create a new order</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="table-footer">
        <span>Showing <strong>{{ $orders->count() }}</strong> orders</span>
        @if(method_exists($orders, 'links'))
          {{ $orders->links() }}
        @endif
      </div>
    </div>

  </div>{{-- /stats-section --}}
</div>{{-- /orders-wrapper --}}

@push('scripts')
<script>
  // ─── Stat Counter Animation ───
  function animateCounter(el) {
    const target = parseInt(el.dataset.target) || 0;
    const dur = 700; let start = null;
    function step(ts) {
      if (!start) start = ts;
      const p = Math.min((ts - start) / dur, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(ease * target);
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  document.querySelectorAll('.stat-value[data-target]').forEach(el => animateCounter(el));

  // ─── Accent bar animation ───
  setTimeout(() => {
    document.querySelectorAll('.stat-card').forEach(c => c.classList.add('loaded'));
  }, 150);

  // ─── Live Search ───
  function liveSearch(val) {
    const q = val.toLowerCase().trim();
    document.querySelectorAll('#ordersTableBody tr').forEach(row => {
      if (!row.dataset.search) return;
      row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
  }
</script>
@endpush

@endsection