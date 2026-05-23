@extends('layouts.admin')
@section('title', 'Reports')
@section('page-title', 'Analytics & Reports')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

  /* ========== LIGHT THEME ========== */
  .analytics-wrapper {
    --card-bg:            #ffffff;
    --card-shadow:        0 2px 12px rgba(0,0,0,0.06);
    --card-hover-shadow:  0 12px 40px rgba(0,0,0,0.13);
    --text-primary:       #1a2535;
    --text-secondary:     #4a5568;
    --text-muted:         #94a3b8;
    --section-bg:         #f4f6f9;
    --border-color:       rgba(0,0,0,0.08);
    --table-hover:        #f8fafc;
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
    --c-orange:           #ea580c;
    --c-orange-soft:      rgba(234,88,12,0.12);
    --header-grad:        linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    --chart-grid:         rgba(0,0,0,0.06);
    --chart-text:         #94a3b8;
  }

  /* ========== DARK THEME ========== */
  body.dark-mode .analytics-wrapper,
  body.sidebar-dark-primary .analytics-wrapper,
  [data-theme="dark"] .analytics-wrapper,
  [data-bs-theme="dark"] .analytics-wrapper {
    --card-bg:            #1e2733;
    --card-shadow:        0 2px 12px rgba(0,0,0,0.4);
    --card-hover-shadow:  0 12px 40px rgba(0,0,0,0.6);
    --text-primary:       #e4eef8;
    --text-secondary:     #7a9ab8;
    --text-muted:         #4a6278;
    --section-bg:         #141A21;
    --border-color:       rgba(255,255,255,0.07);
    --table-hover:        #243040;
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
    --c-orange:           #fb923c;
    --c-orange-soft:      rgba(251,146,60,0.13);
    --chart-grid:         rgba(255,255,255,0.06);
    --chart-text:         #4a6278;
  }

  /* ========== BASE ========== */
  .analytics-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
  .analytics-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
  @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

  /* ========== GRADIENT HEADER ========== */
  .analytics-header {
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
  .analytics-header::before {
    content:''; position:absolute; top:-110px; right:-70px;
    width:340px; height:340px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
    animation: float1 18s ease-in-out infinite;
  }
  .analytics-header::after {
    content:''; position:absolute; bottom:-110px; left:-50px;
    width:290px; height:290px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    animation: float2 14s ease-in-out infinite;
  }
  @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
  @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

  .analytics-header-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 1rem;
  }
  .analytics-header-left { display:flex; align-items:center; gap:1.2rem; }
  .analytics-header-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.22);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: white;
    border: 2px solid rgba(255,255,255,0.28);
  }
  .analytics-header h1 {
    color: white; font-size: 1.9rem; font-weight: 800;
    margin: 0; letter-spacing: -0.5px;
  }
  .analytics-header p {
    color: rgba(255,255,255,0.85); font-size: 0.92rem;
    margin: 3px 0 0; font-weight: 500;
  }
  .header-chip {
    background: rgba(255,255,255,0.18);
    color: white; padding: 7px 16px;
    border-radius: 12px; font-weight: 700;
    font-size: 0.84rem; font-family: var(--font-mono);
    border: 1px solid rgba(255,255,255,0.25);
    display: inline-flex; align-items: center; gap: 7px;
    white-space: nowrap;
  }

  /* ========== BODY ========== */
  .analytics-body { padding: 0 1.5rem 2rem; }

  /* ========== 6-COL STATS ========== */
  .stats-grid-6 {
    display: grid;
    grid-template-columns: repeat(6, minmax(0,1fr));
    gap: 13px;
    margin-bottom: 1.5rem;
  }
  @media(max-width:1100px){ .stats-grid-6 { grid-template-columns: repeat(3,1fr); } }
  @media(max-width:600px){  .stats-grid-6 { grid-template-columns: repeat(2,1fr); } }

  .stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 1.25rem 1.15rem;
    box-shadow: var(--card-shadow);
    position: relative; overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    animation: scaleIn 0.5s ease backwards;
  }
  .stat-card:nth-child(1){ animation-delay:0.04s; }
  .stat-card:nth-child(2){ animation-delay:0.08s; }
  .stat-card:nth-child(3){ animation-delay:0.12s; }
  .stat-card:nth-child(4){ animation-delay:0.16s; }
  .stat-card:nth-child(5){ animation-delay:0.20s; }
  .stat-card:nth-child(6){ animation-delay:0.24s; }
  @keyframes scaleIn {
    from { opacity:0; transform:scale(0.93) translateY(14px); }
    to   { opacity:1; transform:scale(1)    translateY(0); }
  }
  .stat-card::before {
    content:''; position:absolute;
    top:0; left:0; right:0; height:3px;
    border-radius:18px 18px 0 0;
    transform: scaleX(0); transform-origin: left;
    transition: transform 0.65s cubic-bezier(0.4,0,0.2,1);
  }
  .stat-card.loaded::before { transform: scaleX(1); }
  .stat-card:hover { transform: translateY(-5px); box-shadow: var(--card-hover-shadow); }

  .sc-today-rev::before  { background: var(--c-success); }
  .sc-month-rev::before  { background: var(--c-accent); }
  .sc-total-rev::before  { background: var(--c-warning); }
  .sc-orders::before     { background: var(--c-info); }
  .sc-customers::before  { background: var(--c-danger); }
  .sc-avg::before        { background: var(--c-purple); }

  .stat-head {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 0.85rem;
  }
  .stat-label {
    font-size: 0.68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-muted);
  }
  .stat-icon-pill {
    width: 30px; height: 30px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
  }
  .sc-today-rev .stat-icon-pill { background:var(--c-success-soft);  color:var(--c-success); }
  .sc-month-rev .stat-icon-pill { background:var(--c-accent-soft);   color:var(--c-accent); }
  .sc-total-rev .stat-icon-pill { background:var(--c-warning-soft);  color:var(--c-warning); }
  .sc-orders    .stat-icon-pill { background:var(--c-info-soft);     color:var(--c-info); }
  .sc-customers .stat-icon-pill { background:var(--c-danger-soft);   color:var(--c-danger); }
  .sc-avg       .stat-icon-pill { background:var(--c-purple-soft);   color:var(--c-purple); }

  .stat-value {
    font-size: 1.85rem; font-weight: 800;
    line-height: 1; margin-bottom: 0.3rem;
    font-family: var(--font-mono);
    word-break: break-all;
  }
  .sc-today-rev .stat-value { color:var(--c-success); }
  .sc-month-rev .stat-value { color:var(--c-accent); }
  .sc-total-rev .stat-value { color:var(--c-warning); }
  .sc-orders    .stat-value { color:var(--c-info); }
  .sc-customers .stat-value { color:var(--c-danger); }
  .sc-avg       .stat-value { color:var(--c-purple); }

  .stat-sub {
    font-size: 0.73rem; font-weight: 600;
    display: flex; align-items: center; gap: 5px;
  }
  .sc-today-rev .stat-sub { color:var(--c-success); }
  .sc-month-rev .stat-sub { color:var(--c-accent); }
  .sc-total-rev .stat-sub { color:var(--c-warning); }
  .sc-orders    .stat-sub { color:var(--c-info); }
  .sc-customers .stat-sub { color:var(--c-danger); }
  .sc-avg       .stat-sub { color:var(--c-purple); }

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
    font-size: 0.85rem; flex-shrink: 0;
  }
  .section-title {
    font-size: 0.9rem; font-weight: 700;
    color: var(--text-primary);
  }
  .chart-body { padding: 1.4rem; }

  /* ========== GRIDS ========== */
  .two-col-8-4 {
    display: grid;
    grid-template-columns: 8fr 4fr;
    gap: 16px; margin-bottom: 1.5rem;
  }
  .two-col-7-5 {
    display: grid;
    grid-template-columns: 7fr 5fr;
    gap: 16px; margin-bottom: 1.5rem;
  }
  @media(max-width:960px){
    .two-col-8-4,
    .two-col-7-5 { grid-template-columns: 1fr; }
  }

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
    font-family: var(--font-mono); flex-shrink: 0;
  }
  .rank-1 { background:rgba(251,191,36,0.18); color:#d97706; }
  .rank-2 { background:rgba(148,163,184,0.18); color:#64748b; }
  .rank-3 { background:rgba(180,113,50,0.15);  color:#b45309; }
  .rank-n { background:var(--section-bg);       color:var(--text-muted); }

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
    background: var(--c-success);
    transition: width 0.9s cubic-bezier(0.4,0,0.2,1);
  }
  .item-stats { text-align: right; flex-shrink: 0; }
  .item-revenue {
    font-family: var(--font-mono);
    font-size: 0.85rem; font-weight: 700;
    color: var(--c-success);
  }
  .item-qty {
    font-size: 0.73rem; color: var(--text-muted);
    margin-top: 2px; font-weight: 500;
  }

  .empty-state { padding: 3rem 2rem; text-align:center; }
  .empty-state i { font-size:2.5rem; color:var(--text-muted); margin-bottom:.8rem; display:block; }
  .empty-state p { color:var(--text-muted); font-size:.9rem; }

  /* Status legend below doughnut */
  .status-legend { padding: 0 1.4rem 1.4rem; display:flex; flex-direction:column; gap:8px; }
  .legend-row {
    display: flex; align-items: center;
    justify-content: space-between;
  }
  .legend-left { display:flex; align-items:center; gap:8px; }
  .legend-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
  .legend-label { font-size:0.82rem; font-weight:600; color:var(--text-secondary); }
  .legend-val {
    font-family: var(--font-mono);
    font-size: 0.82rem; font-weight:700;
    padding: 2px 10px; border-radius:8px;
  }

  @media(max-width:768px){
    .analytics-header { padding:1.5rem; }
    .analytics-header h1 { font-size:1.5rem; }
    .analytics-body { padding:0 1rem 1.5rem; }
  }
</style>
@endpush

@section('content')
<div class="analytics-wrapper">

  {{-- ── Gradient Header ── --}}
  <div class="analytics-header">
    <div class="analytics-header-inner">
      <div class="analytics-header-left">
        <div class="analytics-header-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <div>
          <h1>Analytics & Reports</h1>
          <p>Business performance overview and insights</p>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span class="header-chip">
          <i class="fas fa-users"></i> {{ number_format($stats['total_customers']) }} Customers
        </span>
        <span class="header-chip">
          <i class="fas fa-receipt"></i> {{ number_format($stats['total_orders']) }} Orders
        </span>
      </div>
    </div>
  </div>

  <div class="analytics-body">

    {{-- ── 6 Stat Cards ── --}}
    <div class="stats-grid-6" id="statsGrid">

      <div class="stat-card sc-today-rev">
        <div class="stat-head">
          <span class="stat-label">Today</span>
          <span class="stat-icon-pill"><i class="fas fa-sun"></i></span>
        </div>
        <div class="stat-value" data-prefix="Rs." data-target="{{ (int)$stats['today_revenue'] }}">Rs.0</div>
        <div class="stat-sub"><i class="fas fa-arrow-up"></i> Today's revenue</div>
      </div>

      <div class="stat-card sc-month-rev">
        <div class="stat-head">
          <span class="stat-label">This Month</span>
          <span class="stat-icon-pill"><i class="fas fa-calendar-alt"></i></span>
        </div>
        <div class="stat-value" data-prefix="Rs." data-target="{{ (int)$stats['month_revenue'] }}">Rs.0</div>
        <div class="stat-sub"><i class="fas fa-chart-line"></i> Monthly revenue</div>
      </div>

      <div class="stat-card sc-total-rev">
        <div class="stat-head">
          <span class="stat-label">Total Revenue</span>
          <span class="stat-icon-pill"><i class="fas fa-coins"></i></span>
        </div>
        <div class="stat-value" data-prefix="Rs." data-target="{{ (int)$stats['total_revenue'] }}">Rs.0</div>
        <div class="stat-sub"><i class="fas fa-database"></i> All time</div>
      </div>

      <div class="stat-card sc-orders">
        <div class="stat-head">
          <span class="stat-label">Total Orders</span>
          <span class="stat-icon-pill"><i class="fas fa-receipt"></i></span>
        </div>
        <div class="stat-value" data-target="{{ $stats['total_orders'] }}">0</div>
        <div class="stat-sub"><i class="fas fa-list"></i> All orders</div>
      </div>

      <div class="stat-card sc-customers">
        <div class="stat-head">
          <span class="stat-label">Customers</span>
          <span class="stat-icon-pill"><i class="fas fa-users"></i></span>
        </div>
        <div class="stat-value" data-target="{{ $stats['total_customers'] }}">0</div>
        <div class="stat-sub"><i class="fas fa-user-plus"></i> Registered</div>
      </div>

      <div class="stat-card sc-avg">
        <div class="stat-head">
          <span class="stat-label">Avg Order</span>
          <span class="stat-icon-pill"><i class="fas fa-balance-scale"></i></span>
        </div>
        <div class="stat-value" data-prefix="Rs." data-target="{{ (int)$stats['avg_order'] }}">Rs.0</div>
        <div class="stat-sub"><i class="fas fa-percentage"></i> Per order</div>
      </div>

    </div>

    {{-- ── Row 1: Line Chart + Doughnut ── --}}
    <div class="two-col-8-4">

      {{-- Daily Revenue Line Chart --}}
      <div class="section-card" style="animation-delay:0.1s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:var(--c-accent-soft);color:var(--c-accent);">
            <i class="fas fa-chart-line"></i>
          </div>
          <span class="section-title">Revenue — Last 7 Days</span>
        </div>
        <div class="chart-body">
          <canvas id="dailyChart" height="110"></canvas>
        </div>
      </div>

      {{-- Order Status Doughnut --}}
      <div class="section-card" style="animation-delay:0.15s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:var(--c-warning-soft);color:var(--c-warning);">
            <i class="fas fa-chart-pie"></i>
          </div>
          <span class="section-title">Order Status</span>
        </div>
        <div class="chart-body" style="padding-bottom:0.6rem;display:flex;justify-content:center;">
          <canvas id="statusChart" style="max-height:190px;max-width:190px;"></canvas>
        </div>
        <div class="status-legend">
          @php
            $statusItems = [
              ['label'=>'Pending',   'color'=>'#fbbf24', 'val'=>$statusBreakdown['pending']],
              ['label'=>'Cooking',   'color'=>'#fb923c', 'val'=>$statusBreakdown['cooking']],
              ['label'=>'Ready',     'color'=>'#10d97f', 'val'=>$statusBreakdown['ready']],
              ['label'=>'Served',    'color'=>'#22d3ee', 'val'=>$statusBreakdown['served']],
              ['label'=>'Cancelled', 'color'=>'#f87171', 'val'=>$statusBreakdown['cancelled']],
            ];
          @endphp
          @foreach($statusItems as $s)
          <div class="legend-row">
            <div class="legend-left">
              <span class="legend-dot" style="background:{{ $s['color'] }};"></span>
              <span class="legend-label">{{ $s['label'] }}</span>
            </div>
            <span class="legend-val" style="background:{{ $s['color'] }}22;color:{{ $s['color'] }};">
              {{ $s['val'] }}
            </span>
          </div>
          @endforeach
        </div>
      </div>

    </div>

    {{-- ── Row 2: Bar Chart + Top Items ── --}}
    <div class="two-col-7-5">

      {{-- Monthly Revenue Bar Chart --}}
      <div class="section-card" style="animation-delay:0.2s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:var(--c-success-soft);color:var(--c-success);">
            <i class="fas fa-chart-bar"></i>
          </div>
          <span class="section-title">Monthly Revenue — Last 6 Months</span>
        </div>
        <div class="chart-body">
          <canvas id="monthlyChart" height="130"></canvas>
        </div>
      </div>

      {{-- Top Selling Items --}}
      <div class="section-card" style="animation-delay:0.25s;">
        <div class="section-header">
          <div class="section-header-icon" style="background:rgba(251,191,36,0.15);color:#d97706;">
            <i class="fas fa-trophy"></i>
          </div>
          <span class="section-title">Top Selling Items</span>
        </div>
        @forelse($topItems as $i => $item)
        @php
          $rankClass = $i===0 ? 'rank-1' : ($i===1 ? 'rank-2' : ($i===2 ? 'rank-3' : 'rank-n'));
          $pct = $topItems->max('total_qty') > 0
               ? ($item->total_qty / $topItems->max('total_qty')) * 100 : 0;
        @endphp
        <div class="top-item">
          <div class="item-rank {{ $rankClass }}">{{ $i + 1 }}</div>
          <div class="item-info">
            <div class="item-name">{{ $item->menuItem->name ?? 'Unknown' }}</div>
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
          <p>No orders data yet</p>
        </div>
        @endforelse
      </div>

    </div>

  </div>{{-- /analytics-body --}}
</div>{{-- /analytics-wrapper --}}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // ── Dark mode detection ──
  function isDark() {
    return document.body.classList.contains('dark-mode')
        || document.body.classList.contains('sidebar-dark-primary')
        || document.documentElement.getAttribute('data-theme') === 'dark'
        || document.documentElement.getAttribute('data-bs-theme') === 'dark';
  }
  const dark       = isDark();
  const gridColor  = dark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
  const textColor  = dark ? '#4a6278' : '#94a3b8';
  Chart.defaults.font.family = "'DM Sans', sans-serif";
  Chart.defaults.color       = textColor;

  // ── Daily Revenue Line Chart ──
  new Chart(document.getElementById('dailyChart'), {
    type: 'line',
    data: {
      labels: @json($dailyLabels),
      datasets: [{
        label: 'Revenue (Rs.)',
        data: @json($dailyRevenue),
        borderColor:           dark ? '#4d84ff' : '#2563eb',
        backgroundColor:       dark ? 'rgba(77,132,255,0.10)' : 'rgba(37,99,235,0.08)',
        borderWidth: 2.5,
        fill: true,
        tension: 0.42,
        pointBackgroundColor:  dark ? '#4d84ff' : '#2563eb',
        pointRadius: 5,
        pointHoverRadius: 7,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display:false } },
      scales: {
        x: { grid:{ color:gridColor }, ticks:{ color:textColor, font:{size:11} } },
        y: {
          beginAtZero: true,
          grid: { color:gridColor },
          ticks: {
            color: textColor, font:{size:11},
            callback: val => 'Rs.' + val.toLocaleString()
          }
        }
      }
    }
  });

  // ── Monthly Revenue Bar Chart ──
  const barColors = dark
    ? ['rgba(77,132,255,0.75)','rgba(16,217,127,0.75)','rgba(251,191,36,0.75)',
       'rgba(248,113,113,0.75)','rgba(34,211,238,0.75)','rgba(167,139,250,0.75)']
    : ['rgba(37,99,235,0.72)', 'rgba(5,150,105,0.72)', 'rgba(217,119,6,0.72)',
       'rgba(220,38,38,0.72)', 'rgba(8,145,178,0.72)', 'rgba(124,58,237,0.72)'];

  new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
      labels: @json($monthlyLabels),
      datasets: [{
        label: 'Revenue (Rs.)',
        data: @json($monthlyRevenue),
        backgroundColor: barColors,
        hoverBackgroundColor: barColors.map(c => c.replace(/[\d.]+\)$/, '0.9)')),
        borderRadius: 7,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend:{ display:false } },
      scales: {
        x: { grid:{ color:gridColor }, ticks:{ color:textColor, font:{size:11} } },
        y: {
          beginAtZero: true,
          grid:{ color:gridColor },
          ticks:{
            color:textColor, font:{size:11},
            callback: val => 'Rs.' + val.toLocaleString()
          }
        }
      }
    }
  });

  // ── Status Doughnut ──
  new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
      labels: ['Pending','Cooking','Ready','Served','Cancelled'],
      datasets: [{
        data: [
          {{ $statusBreakdown['pending'] }},
          {{ $statusBreakdown['cooking'] }},
          {{ $statusBreakdown['ready'] }},
          {{ $statusBreakdown['served'] }},
          {{ $statusBreakdown['cancelled'] }},
        ],
        backgroundColor: ['#fbbf24','#fb923c','#10d97f','#22d3ee','#f87171'],
        borderWidth: 0,
        hoverOffset: 6,
      }]
    },
    options: {
      cutout: '68%',
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.raw }
        }
      }
    }
  });

  // ── Stat counter animation ──
  function animateCounter(el) {
    const target = parseInt(el.dataset.target) || 0;
    const prefix = el.dataset.prefix || '';
    const dur = 750; let start = null;
    (function step(ts) {
      if (!start) start = ts;
      const p    = Math.min((ts - start) / dur, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      el.textContent = prefix + Math.round(ease * target).toLocaleString();
      if (p < 1) requestAnimationFrame(step);
    })(performance.now());
  }
  document.querySelectorAll('.stat-value[data-target]').forEach(animateCounter);

  // ── Accent bar on load ──
  setTimeout(() => {
    document.querySelectorAll('.stat-card').forEach(c => c.classList.add('loaded'));
  }, 150);
</script>
@endpush