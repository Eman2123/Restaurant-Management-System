@extends('layouts.admin')
@section('title', 'Daily Report')
@section('page-title', 'Daily Summary Report')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

  /* ========== LIGHT THEME ========== */
  .report-wrapper {
    --card-bg:            #ffffff;
    --card-shadow:        0 2px 12px rgba(0,0,0,0.06);
    --card-hover-shadow:  0 12px 40px rgba(0,0,0,0.13);
    --text-primary:       #1a2535;
    --text-secondary:     #4a5568;
    --text-muted:         #94a3b8;
    --section-bg:         #f4f6f9;
    --border-color:       rgba(0,0,0,0.08);
    --table-hover:        #f8fafc;
    --input-bg:           #f1f5f9;
    --font-main:          'DM Sans', sans-serif;
    --font-mono:          'DM Mono', monospace;
    --c-success:          #059669;
    --c-success-soft:     rgba(5,150,105,0.12);
    --c-warning:          #d97706;
    --c-warning-soft:     rgba(217,119,6,0.12);
    --c-info:             #0891b2;
    --c-info-soft:        rgba(8,145,178,0.12);
    --c-danger:           #dc2626;
    --c-danger-soft:      rgba(220,38,38,0.12);
    --c-purple:           #7c3aed;
    --c-purple-soft:      rgba(124,58,237,0.12);
    --c-pink:             #db2777;
    --c-pink-soft:        rgba(219,39,119,0.12);
    --c-accent:           #2563eb;
    --c-accent-soft:      rgba(37,99,235,0.12);
    --c-teal:             #0891b2;
    --c-teal-soft:        rgba(8,145,178,0.12);
    --header-grad:        linear-gradient(135deg, #059669 0%, #047857 100%);
    --chart-grid:         rgba(0,0,0,0.06);
    --chart-text:         #64748b;
  }

  /* ========== DARK THEME ========== */
  body.dark-mode .report-wrapper,
  body.sidebar-dark-primary .report-wrapper,
  [data-theme="dark"] .report-wrapper,
  [data-bs-theme="dark"] .report-wrapper {
    --card-bg:            #1e2733;
    --card-shadow:        0 2px 12px rgba(0,0,0,0.4);
    --card-hover-shadow:  0 12px 40px rgba(0,0,0,0.6);
    --text-primary:       #e4eef8;
    --text-secondary:     #7a9ab8;
    --text-muted:         #4a6278;
    --section-bg:         #141A21;
    --border-color:       rgba(255,255,255,0.07);
    --table-hover:        #243040;
    --input-bg:           #141a21;
    --c-success:          #10d97f;
    --c-success-soft:     rgba(16,217,127,0.13);
    --c-warning:          #fbbf24;
    --c-warning-soft:     rgba(251,191,36,0.13);
    --c-info:             #22d3ee;
    --c-info-soft:        rgba(34,211,238,0.13);
    --c-danger:           #f87171;
    --c-danger-soft:      rgba(248,113,113,0.13);
    --c-purple:           #a78bfa;
    --c-purple-soft:      rgba(167,139,250,0.13);
    --c-pink:             #f472b6;
    --c-pink-soft:        rgba(244,114,182,0.13);
    --c-accent:           #4d84ff;
    --c-accent-soft:      rgba(77,132,255,0.14);
    --c-teal:             #22d3ee;
    --c-teal-soft:        rgba(34,211,238,0.13);
    --chart-grid:         rgba(255,255,255,0.06);
    --chart-text:         #4a6278;
  }

  /* ========== BASE ========== */
  .report-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
  .report-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
  @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

  /* ========== GRADIENT HEADER ========== */
  .report-header {
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
  .report-header::before {
    content:''; position:absolute; top:-100px; right:-60px;
    width:320px; height:320px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
    animation: float1 18s ease-in-out infinite;
  }
  .report-header::after {
    content:''; position:absolute; bottom:-100px; left:-60px;
    width:280px; height:280px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    animation: float2 14s ease-in-out infinite;
  }
  @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
  @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

  .report-header-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 1rem;
  }
  .report-header-left { display:flex; align-items:center; gap:1.2rem; }
  .report-header-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.22);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: white;
    border: 2px solid rgba(255,255,255,0.28);
  }
  .report-header h1 {
    color: white; font-size: 1.9rem; font-weight: 800;
    margin: 0; letter-spacing: -0.5px;
  }
  .report-header p {
    color: rgba(255,255,255,0.85); font-size: 0.92rem;
    margin: 3px 0 0; font-weight: 500;
  }
  .date-badge {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 8px 18px; border-radius: 12px;
    font-weight: 700; font-size: 0.88rem;
    border: 1px solid rgba(255,255,255,0.3);
    letter-spacing: 0.3px;
    display: flex; align-items: center; gap: 8px;
  }
  .orders-count-badge {
    background: rgba(255,255,255,0.18);
    color: white; padding: 7px 16px;
    border-radius: 20px; font-weight: 700;
    font-size: 0.85rem; font-family: var(--font-mono);
    border: 1px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; gap: 7px;
  }
  .orders-count-badge span {
    background: rgba(255,255,255,0.3);
    padding: 2px 8px; border-radius: 8px;
    font-size: 0.9rem;
  }

  /* ========== CONTENT SECTION ========== */
  .report-body { padding: 0 1.5rem 1.5rem; }

  /* ========== DATE PICKER CARD ========== */
  .picker-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 1.1rem 1.4rem;
    box-shadow: var(--card-shadow);
    margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 12px;
    flex-wrap: wrap;
    animation: scaleIn 0.4s ease;
  }
  @keyframes scaleIn {
    from { opacity:0; transform:scale(0.97) translateY(8px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
  }
  .picker-label {
    font-weight: 700; font-size: 0.85rem;
    color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: 0.06em;
    white-space: nowrap;
  }
  .date-input {
    background: var(--input-bg);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 8px 13px;
    font-size: 13px; font-weight: 500;
    color: var(--text-primary);
    outline: none;
    font-family: var(--font-mono);
    transition: all 0.2s;
    max-width: 180px;
  }
  .date-input:focus {
    border-color: var(--c-success);
    box-shadow: 0 0 0 3px var(--c-success-soft);
  }
  .btn-view {
    background: var(--c-accent);
    color: #fff; border: none;
    padding: 9px 20px; border-radius: 10px;
    font-size: 13px; font-weight: 700;
    cursor: pointer; display: inline-flex;
    align-items: center; gap: 7px;
    transition: all 0.2s;
    text-transform: uppercase; letter-spacing: 0.04em;
    font-family: var(--font-main);
  }
  .btn-view:hover {
    background: #1a57d6;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
  }
  .btn-today {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
    padding: 9px 18px; border-radius: 10px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex;
    align-items: center; gap: 7px;
    transition: all 0.2s;
    text-decoration: none;
    font-family: var(--font-main);
    white-space: nowrap;
  }
  .btn-today:hover {
    border-color: var(--c-success);
    color: var(--c-success);
    background: var(--c-success-soft);
    text-decoration: none;
  }
  .picker-divider {
    width: 1px; height: 28px;
    background: var(--border-color);
    flex-shrink: 0;
  }

  /* ========== STATS GRID ========== */
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
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    animation: scaleIn 0.5s ease backwards;
  }
  .stat-card:nth-child(1){ animation-delay:0.05s; }
  .stat-card:nth-child(2){ animation-delay:0.10s; }
  .stat-card:nth-child(3){ animation-delay:0.15s; }
  .stat-card:nth-child(4){ animation-delay:0.20s; }
  .stat-card::before {
    content:''; position:absolute;
    top:0; left:0; right:0; height:3px;
    border-radius:18px 18px 0 0;
    transform: scaleX(0); transform-origin: left;
    transition: transform 0.6s cubic-bezier(0.4,0,0.2,1);
  }
  .stat-card.loaded::before { transform: scaleX(1); }
  .stat-card:hover { transform: translateY(-5px); box-shadow: var(--card-hover-shadow); }

  .sc-revenue::before  { background: var(--c-success); }
  .sc-orders::before   { background: var(--c-accent); }
  .sc-paid::before     { background: var(--c-teal); }
  .sc-unpaid::before   { background: var(--c-warning); }

  .stat-head {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 1rem;
  }
  .stat-label {
    font-size: 0.70rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-muted);
  }
  .stat-icon-pill {
    width: 34px; height: 34px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
  }
  .sc-revenue .stat-icon-pill { background: var(--c-success-soft); color: var(--c-success); }
  .sc-orders  .stat-icon-pill { background: var(--c-accent-soft);  color: var(--c-accent); }
  .sc-paid    .stat-icon-pill { background: var(--c-teal-soft);    color: var(--c-teal); }
  .sc-unpaid  .stat-icon-pill { background: var(--c-warning-soft); color: var(--c-warning); }

  .stat-value {
    font-size: 2.2rem; font-weight: 800;
    line-height: 1; margin-bottom: 0.35rem;
    font-family: var(--font-mono);
  }
  .sc-revenue .stat-value { color: var(--c-success); }
  .sc-orders  .stat-value { color: var(--c-accent); }
  .sc-paid    .stat-value { color: var(--c-teal); }
  .sc-unpaid  .stat-value { color: var(--c-warning); }

  .stat-sub {
    font-size: 0.75rem; font-weight: 600;
    display: flex; align-items: center; gap: 5px;
  }
  .sc-revenue .stat-sub { color: var(--c-success); }
  .sc-orders  .stat-sub { color: var(--c-accent); }
  .sc-paid    .stat-sub { color: var(--c-teal); }
  .sc-unpaid  .stat-sub { color: var(--c-warning); }

  /* ========== SECTION CARD ========== */
  .section-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    animation: fadeInUp 0.5s ease both;
  }
  @keyframes fadeInUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }

  .section-header {
    padding: 1rem 1.4rem;
    border-bottom: 1px solid var(--border-color);
    display: flex; align-items: center; gap: 10px;
  }
  .section-header-icon {
    width: 32px; height: 32px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; flex-shrink:0;
  }
  .section-title {
    font-size: 0.9rem; font-weight: 700;
    color: var(--text-primary);
  }

  /* Chart containers */
  .chart-body { padding: 1.4rem; }

  /* ========== ORDER TYPES BREAKDOWN ========== */
  .type-list { padding: 1.4rem; }
  .type-item {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--border-color);
  }
  .type-item:last-child { border-bottom: none; padding-bottom: 0; }
  .type-item-left { display: flex; align-items: center; gap: 10px; }
  .type-dot {
    width: 10px; height: 10px; border-radius: 50%;
  }
  .type-name {
    font-size: 0.88rem; font-weight: 600;
    color: var(--text-primary);
  }
  .type-count {
    font-family: var(--font-mono);
    font-weight: 700; font-size: 1rem;
    padding: 3px 12px; border-radius: 9px;
  }
  .type-bar-track {
    height: 4px; background: var(--border-color);
    border-radius: 4px; margin-top: 5px; flex:1;
    margin-left: 20px;
  }
  .type-bar-fill { height: 100%; border-radius: 4px; }

  /* ========== TOP ITEMS ========== */
  .top-item {
    display: flex; align-items: center; gap: 14px;
    padding: 0.9rem 1.4rem;
    border-bottom: 1px solid var(--border-color);
    transition: background 0.15s;
  }
  .top-item:last-child { border-bottom: none; }
  .top-item:hover { background: var(--table-hover); }

  .item-rank {
    width: 28px; height: 28px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 0.8rem;
    font-family: var(--font-mono); flex-shrink:0;
  }
  .rank-1 { background: rgba(251,191,36,0.18); color: #d97706; }
  .rank-2 { background: rgba(148,163,184,0.18); color: #64748b; }
  .rank-3 { background: rgba(217,119,6,0.12); color: #b45309; }
  .rank-n { background: var(--section-bg); color: var(--text-muted); }

  .item-info { flex:1; min-width:0; }
  .item-name {
    font-size: 0.9rem; font-weight: 700;
    color: var(--text-primary);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .item-bar-track {
    height: 4px; background: var(--border-color);
    border-radius: 4px; margin-top: 6px;
  }
  .item-bar-fill {
    height: 100%; border-radius: 4px;
    background: var(--c-warning);
    transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
  }
  .item-stats { text-align: right; flex-shrink:0; }
  .item-revenue {
    font-family: var(--font-mono);
    font-size: 0.85rem; font-weight: 700;
    color: var(--c-success);
  }
  .item-qty {
    font-size: 0.75rem; color: var(--text-muted);
    margin-top: 2px; font-weight: 500;
  }

  /* ========== ORDERS TABLE ========== */
  .orders-table-wrap {
    max-height: 380px;
    overflow-y: auto;
  }
  .orders-table-wrap::-webkit-scrollbar { width: 5px; }
  .orders-table-wrap::-webkit-scrollbar-track { background: transparent; }
  .orders-table-wrap::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 4px;
  }

  .modern-table { width:100%; border-collapse:collapse; }
  .modern-table thead {
    background: var(--header-grad);
    position: sticky; top:0; z-index:1;
  }
  .modern-table thead th {
    padding: 0.85rem 1.1rem;
    font-size: 0.70rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: white; border: none; text-align: left;
    white-space: nowrap;
  }
  .modern-table tbody tr {
    border-bottom: 1px solid var(--border-color);
    transition: background 0.15s;
  }
  .modern-table tbody tr:last-child { border-bottom: none; }
  .modern-table tbody tr:hover { background: var(--table-hover); }
  .modern-table tbody td {
    padding: 0.85rem 1.1rem;
    font-size: 0.88rem; color: var(--text-primary);
    vertical-align: middle;
  }

  .order-id-mono {
    font-family: var(--font-mono);
    font-size: 0.82rem; font-weight: 600;
    color: var(--c-accent);
    background: var(--c-accent-soft);
    padding: 3px 9px; border-radius: 7px;
    display: inline-block;
  }

  .badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 11px; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.04em;
    white-space: nowrap;
  }
  .badge-paid     { background:var(--c-success-soft); color:var(--c-success); }
  .badge-unpaid   { background:var(--c-warning-soft); color:var(--c-warning); }
  .badge-pending  { background:var(--c-warning-soft); color:var(--c-warning); }
  .badge-cooking  { background:var(--c-danger-soft);  color:var(--c-danger); }
  .badge-ready    { background:var(--c-success-soft); color:var(--c-success); }
  .badge-served   { background:var(--c-teal-soft);    color:var(--c-teal); }
  .badge-cancelled{ background:rgba(100,116,139,0.12); color:#64748b; }

  .amount-cell {
    font-family: var(--font-mono);
    font-weight: 700; font-size: 0.88rem;
    color: var(--c-success);
  }
  .time-cell {
    font-size: 0.78rem; color: var(--text-muted);
    font-family: var(--font-mono);
  }

  .empty-state { padding: 3rem 2rem; text-align: center; }
  .empty-state i { font-size: 2.5rem; color: var(--text-muted); margin-bottom: 0.8rem; display:block; }
  .empty-state p { color: var(--text-muted); font-size: 0.9rem; }

  /* Grid layouts */
  .two-col-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px; margin-bottom: 1.5rem;
  }
  .five-seven-grid {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 16px; margin-bottom: 1.5rem;
  }
  @media(max-width:900px) {
    .two-col-grid,
    .five-seven-grid { grid-template-columns: 1fr; }
  }

  /* Responsive */
  @media(max-width:768px){
    .report-header { padding: 1.5rem; }
    .report-header h1 { font-size: 1.5rem; }
    .report-body { padding: 0 1rem 1rem; }
  }
</style>
@endpush

@section('content')
<div class="report-wrapper">

  {{-- ── Gradient Header ── --}}
  <div class="report-header">
    <div class="report-header-inner">
      <div class="report-header-left">
        <div class="report-header-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <div>
          <h1>Daily Report</h1>
          <p>{{ \Carbon\Carbon::parse($summary['date'])->format('l, d F Y') }}</p>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <div class="date-badge">
          <i class="fas fa-calendar-day"></i>
          {{ \Carbon\Carbon::parse($summary['date'])->format('d M Y') }}
        </div>
        <div class="orders-count-badge">
          <i class="fas fa-receipt"></i>
          <span>{{ $summary['total_orders'] }}</span> Orders
        </div>
      </div>
    </div>
  </div>

  <div class="report-body">

    {{-- ── Date Picker ── --}}
    <div class="picker-card">
      <span class="picker-label">
        <i class="fas fa-filter" style="margin-right:5px;opacity:.7;"></i>
        Select Date
      </span>
      <div class="picker-divider"></div>
      <form method="GET" action="{{ route('admin.reports.daily') }}"
            style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <input type="date" name="date"
               class="date-input"
               value="{{ $summary['date'] }}"
               max="{{ today()->toDateString() }}">
        <button type="submit" class="btn-view">
          <i class="fas fa-search"></i> View Report
        </button>
        <a href="{{ route('admin.reports.daily') }}" class="btn-today">
          <i class="fas fa-calendar-check"></i> Today
        </a>
      </form>
    </div>

    {{-- ── Stats ── --}}
    <div class="stats-grid" id="statsGrid">

      <div class="stat-card sc-revenue">
        <div class="stat-head">
          <span class="stat-label">Revenue</span>
          <span class="stat-icon-pill">
            <i class="fas fa-coins"></i>
          </span>
        </div>
        <div class="stat-value" data-prefix="Rs." data-target="{{ (int)$summary['total_revenue'] }}">Rs.0</div>
        <div class="stat-sub">
          <i class="fas fa-arrow-up"></i> Today's earnings
        </div>
      </div>

      <div class="stat-card sc-orders">
        <div class="stat-head">
          <span class="stat-label">Total Orders</span>
          <span class="stat-icon-pill">
            <i class="fas fa-receipt"></i>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $summary['total_orders'] }}">0</div>
        <div class="stat-sub">
          <i class="fas fa-clock"></i> All orders today
        </div>
      </div>

      <div class="stat-card sc-paid">
        <div class="stat-head">
          <span class="stat-label">Paid Orders</span>
          <span class="stat-icon-pill">
            <i class="fas fa-check-circle"></i>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $summary['paid_orders'] }}">0</div>
        <div class="stat-sub">
          <i class="fas fa-check"></i> Cleared
        </div>
      </div>

      <div class="stat-card sc-unpaid">
        <div class="stat-head">
          <span class="stat-label">Unpaid Orders</span>
          <span class="stat-icon-pill">
            <i class="fas fa-exclamation-circle"></i>
          </span>
        </div>
        <div class="stat-value" data-target="{{ $summary['unpaid_orders'] }}">0</div>
        <div class="stat-sub">
          <i class="fas fa-hourglass-half"></i> Pending
        </div>
      </div>

    </div>

    {{-- ── Charts Row ── --}}
    <div class="two-col-grid" style="grid-template-columns: 3fr 2fr;">

      {{-- Hourly Chart --}}
      <div class="section-card" style="animation-delay:0.1s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:var(--c-accent-soft);color:var(--c-accent);">
            <i class="fas fa-chart-bar"></i>
          </div>
          <span class="section-title">Orders by Hour</span>
        </div>
        <div class="chart-body">
          <canvas id="hourlyChart" height="120"></canvas>
        </div>
      </div>

      {{-- Order Types --}}
      <div class="section-card" style="animation-delay:0.15s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:var(--c-warning-soft);color:var(--c-warning);">
            <i class="fas fa-chart-pie"></i>
          </div>
          <span class="section-title">Order Types</span>
        </div>
        <div class="chart-body" style="padding-bottom:0.5rem;">
          <canvas id="typeChart" height="160"></canvas>
        </div>
        <div class="type-list">
          @php
            $types = [
              ['label'=>'Dine In',  'key'=>'dine_in',  'color'=>'var(--c-accent)',  'dot'=>'#2563eb'],
              ['label'=>'Takeaway', 'key'=>'takeaway', 'color'=>'var(--c-success)', 'dot'=>'#059669'],
              ['label'=>'Delivery', 'key'=>'delivery', 'color'=>'var(--c-warning)', 'dot'=>'#d97706'],
            ];
            $maxType = max($summary['dine_in'], $summary['takeaway'], $summary['delivery'], 1);
          @endphp
          @foreach($types as $type)
          <div class="type-item">
            <div class="type-item-left" style="flex:1;min-width:0;">
              <span class="type-dot" style="background:{{ $type['dot'] }};flex-shrink:0;"></span>
              <div style="flex:1;">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                  <span class="type-name">{{ $type['label'] }}</span>
                  <span class="type-count" style="background:transparent;color:{{ $type['color'] }};">
                    {{ $summary[$type['key']] }}
                  </span>
                </div>
                <div class="type-bar-track">
                  <div class="type-bar-fill"
                       style="width:{{ $maxType > 0 ? ($summary[$type['key']] / $maxType) * 100 : 0 }}%;background:{{ $type['dot'] }};"></div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

    </div>

    {{-- ── Bottom Row: Top Items + Orders Table ── --}}
    <div class="five-seven-grid">

      {{-- Top Items --}}
      <div class="section-card" style="animation-delay:0.2s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:rgba(251,191,36,0.15);color:#d97706;">
            <i class="fas fa-trophy"></i>
          </div>
          <span class="section-title">Top Items Today</span>
        </div>
        @forelse($topItems as $i => $item)
        @php
          $rankClass = $i===0 ? 'rank-1' : ($i===1 ? 'rank-2' : ($i===2 ? 'rank-3' : 'rank-n'));
          $pct = $topItems->max('total_qty') > 0
                 ? ($item->total_qty / $topItems->max('total_qty')) * 100
                 : 0;
        @endphp
        <div class="top-item">
          <div class="item-rank {{ $rankClass }}">{{ $i+1 }}</div>
          <div class="item-info">
            <div class="item-name">{{ $item->menuItem->name ?? '—' }}</div>
            <div class="item-bar-track">
              <div class="item-bar-fill" style="width:{{ $pct }}%"></div>
            </div>
          </div>
          <div class="item-stats">
            <div class="item-revenue">Rs.{{ number_format($item->total_revenue, 0) }}</div>
            <div class="item-qty">{{ $item->total_qty }} sold</div>
          </div>
        </div>
        @empty
        <div class="empty-state">
          <i class="fas fa-box-open"></i>
          <p>No orders today</p>
        </div>
        @endforelse
      </div>

      {{-- Today's Orders --}}
      <div class="section-card" style="animation-delay:0.25s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:var(--c-info-soft);color:var(--c-info);">
            <i class="fas fa-list-alt"></i>
          </div>
          <span class="section-title">Today's Orders</span>
        </div>
        <div class="orders-table-wrap">
          <table class="modern-table">
            <thead>
              <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
              <tr>
                <td><span class="order-id-mono">#{{ $order->id }}</span></td>
                <td style="font-weight:600;font-size:0.88rem;">{{ $order->user->name ?? 'Guest' }}</td>
                <td><span class="amount-cell">Rs.{{ number_format($order->total_amount, 0) }}</span></td>
                <td>
                  @if($order->payment_status === 'paid')
                    <span class="badge badge-paid">
                      <i class="fas fa-check" style="font-size:9px;"></i> Paid
                    </span>
                  @else
                    <span class="badge badge-unpaid">
                      <i class="fas fa-clock" style="font-size:9px;"></i> Unpaid
                    </span>
                  @endif
                </td>
                <td>
                  <span class="badge badge-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
                <td><span class="time-cell">{{ $order->created_at->format('h:i A') }}</span></td>
              </tr>
              @empty
              <tr>
                <td colspan="6">
                  <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No orders for this date</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>{{-- /report-body --}}
</div>{{-- /report-wrapper --}}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // ─── Dark mode detection ───
  function isDark() {
    return document.body.classList.contains('dark-mode')
        || document.body.classList.contains('sidebar-dark-primary')
        || document.documentElement.getAttribute('data-theme') === 'dark'
        || document.documentElement.getAttribute('data-bs-theme') === 'dark';
  }

  const dark      = isDark();
  const gridColor = dark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
  const textColor = dark ? '#4a6278' : '#64748b';
  const fontFam   = "'DM Sans', sans-serif";

  Chart.defaults.font.family = fontFam;
  Chart.defaults.color       = textColor;

  // ─── Hourly Chart ───
  new Chart(document.getElementById('hourlyChart'), {
    type: 'bar',
    data: {
      labels: Array.from({length:24}, (_,i) =>
        i === 0 ? '12am' : i < 12 ? i+'am' : i === 12 ? '12pm' : (i-12)+'pm'),
      datasets: [{
        label: 'Orders',
        data: @json(array_values($hourly)),
        backgroundColor: dark
          ? 'rgba(77,132,255,0.65)'
          : 'rgba(37,99,235,0.65)',
        hoverBackgroundColor: dark
          ? 'rgba(77,132,255,0.9)'
          : 'rgba(37,99,235,0.9)',
        borderRadius: 5,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display:false } },
      scales: {
        x: {
          grid: { color: gridColor },
          ticks: { font: { size:10 }, color: textColor }
        },
        y: {
          beginAtZero: true,
          ticks: { stepSize:1, font:{size:11}, color: textColor },
          grid: { color: gridColor }
        }
      }
    }
  });

  // ─── Type Doughnut Chart ───
  new Chart(document.getElementById('typeChart'), {
    type: 'doughnut',
    data: {
      labels: ['Dine In', 'Takeaway', 'Delivery'],
      datasets: [{
        data: [
          {{ $summary['dine_in'] }},
          {{ $summary['takeaway'] }},
          {{ $summary['delivery'] }},
        ],
        backgroundColor: dark
          ? ['#4d84ff','#10d97f','#fbbf24']
          : ['#2563eb','#059669','#d97706'],
        borderWidth: 0,
        hoverOffset: 6,
      }]
    },
    options: {
      cutout: '68%',
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => ' ' + ctx.label + ': ' + ctx.raw
          }
        }
      }
    }
  });

  // ─── Stat counter animation ───
  function animateCounter(el) {
    const target = parseInt(el.dataset.target) || 0;
    const prefix = el.dataset.prefix || '';
    const dur = 700; let start = null;
    function step(ts) {
      if (!start) start = ts;
      const p = Math.min((ts - start) / dur, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      el.textContent = prefix + Math.round(ease * target).toLocaleString();
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  document.querySelectorAll('.stat-value[data-target]').forEach(animateCounter);

  // ─── Accent bar animation ───
  setTimeout(() => {
    document.querySelectorAll('.stat-card').forEach(c => c.classList.add('loaded'));
  }, 150);
</script>
@endpush