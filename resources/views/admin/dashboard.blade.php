@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

/* ═══════════════════════════════════════
   LIGHT THEME
═══════════════════════════════════════ */
.db-wrap {
    --card:          #ffffff;
    --card-border:   rgba(0,0,0,0.07);
    --card-shadow:   0 2px 12px rgba(0,0,0,0.06);
    --card-hov-sh:   0 12px 40px rgba(0,0,0,0.13);
    --text-h:        #1a2535;
    --text-b:        #4a5568;
    --text-s:        #64748b;
    --text-m:        #94a3b8;
    --divider:       rgba(0,0,0,0.06);
    --thead-bg:      #f8fafc;
    --row-hov:       #f0f7ff;
    --qa-bg:         #f4f6f9;
    --section-bg:    #f4f6f9;
    --font:          'DM Sans', sans-serif;
    --mono:          'DM Mono', monospace;
    --ease:          0.22s cubic-bezier(.4,0,.2,1);

    /* accent palette */
    --c-amber:   #f59e0b; --c-amber-s:  rgba(245,158,11,0.12);
    --c-blue:    #2563eb; --c-blue-s:   rgba(37,99,235,0.12);
    --c-cyan:    #0891b2; --c-cyan-s:   rgba(8,145,178,0.12);
    --c-green:   #059669; --c-green-s:  rgba(5,150,105,0.12);
    --c-violet:  #7c3aed; --c-violet-s: rgba(124,58,237,0.12);
    --c-rose:    #e11d48; --c-rose-s:   rgba(225,29,72,0.12);
    --c-pink:    #db2777; --c-pink-s:   rgba(219,39,119,0.12);
    --c-orange:  #ea580c; --c-orange-s: rgba(234,88,12,0.12);
    --c-teal:    #0d9488; --c-teal-s:   rgba(13,148,136,0.12);
}

/* ═══════════════════════════════════════
   DARK THEME
═══════════════════════════════════════ */
body.dark-mode .db-wrap,
body.sidebar-dark-primary .db-wrap,
[data-theme="dark"] .db-wrap,
[data-bs-theme="dark"] .db-wrap {
    --card:          #1e2733;
    --card-border:   rgba(255,255,255,0.07);
    --card-shadow:   0 2px 14px rgba(0,0,0,0.35);
    --card-hov-sh:   0 12px 40px rgba(0,0,0,0.55);
    --text-h:        #e4eef8;
    --text-b:        #7a9ab8;
    --text-s:        #4a6278;
    --text-m:        #2e4a60;
    --divider:       rgba(255,255,255,0.05);
    --thead-bg:      #141A21;
    --row-hov:       #243040;
    --qa-bg:         #141A21;
    --section-bg:    #141A21;
    --c-amber:   #fbbf24; --c-amber-s:  rgba(251,191,36,0.13);
    --c-blue:    #4d84ff; --c-blue-s:   rgba(77,132,255,0.13);
    --c-cyan:    #22d3ee; --c-cyan-s:   rgba(34,211,238,0.13);
    --c-green:   #10d97f; --c-green-s:  rgba(16,217,127,0.13);
    --c-violet:  #a78bfa; --c-violet-s: rgba(167,139,250,0.13);
    --c-rose:    #fb7185; --c-rose-s:   rgba(251,113,133,0.13);
    --c-pink:    #f472b6; --c-pink-s:   rgba(244,114,182,0.13);
    --c-orange:  #fb923c; --c-orange-s: rgba(251,146,60,0.13);
    --c-teal:    #2dd4bf; --c-teal-s:   rgba(45,212,191,0.13);
}

/* ── base ── */
.db-wrap * { box-sizing: border-box; font-family: var(--font); }
.db-wrap    { background: transparent; padding: 0 0 1.5rem; animation: fadeIn 0.4s ease; }
@keyframes fadeIn { from{opacity:0} to{opacity:1} }

/* ═══════════════════════════════════════
   DASHBOARD HEADER BANNER
═══════════════════════════════════════ */
.db-banner {
    background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 45%, #2563eb 75%, #3b82f6 100%);
    padding: 2rem 2.5rem;
    border-radius: 0 0 28px 28px;
    margin-bottom: 1.8rem;
    position: relative; overflow: hidden;
    animation: slideDown 0.5s ease;
}
@keyframes slideDown { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }

.db-banner::before {
    content:''; position:absolute; top:-100px; right:-60px;
    width:360px; height:360px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.10) 0%, transparent 70%);
    animation: bFloat 18s ease-in-out infinite;
}
.db-banner::after {
    content:''; position:absolute; bottom:-80px; left:-40px;
    width:260px; height:260px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
    animation: bFloat2 14s ease-in-out infinite;
}
@keyframes bFloat  { 0%,100%{transform:translate(0,0)} 50%{transform:translate(18px,18px)} }
@keyframes bFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-18px,-18px)} }

.db-banner-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
.db-banner-left  { display:flex; align-items:center; gap:1.2rem; }
.db-banner-icon  {
    width:58px; height:58px; border-radius:18px;
    background:rgba(255,255,255,0.18); border:2px solid rgba(255,255,255,0.28);
    display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; color:white;
    box-shadow:0 8px 24px rgba(0,0,0,0.18);
    animation: iconFloat 3s ease-in-out infinite;
}
@keyframes iconFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

.db-banner-text h1 { color:white; font-size:1.8rem; font-weight:800; margin:0; letter-spacing:-0.5px; }
.db-banner-text p  { color:rgba(255,255,255,0.80); font-size:0.88rem; margin:4px 0 0; font-weight:500; }

.db-banner-right { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

.db-time-badge {
    background:rgba(255,255,255,0.16); border:1px solid rgba(255,255,255,0.28);
    color:white; padding:8px 16px; border-radius:12px;
    font-size:0.82rem; font-weight:600;
    display:flex; align-items:center; gap:8px;
    backdrop-filter:blur(6px);
    font-family: var(--mono);
}
.db-time-badge i { font-size:0.75rem; opacity:0.8; }

.db-live-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(255,255,255,0.16); border:1px solid rgba(255,255,255,0.28);
    color:white; padding:7px 14px; border-radius:20px;
    font-size:0.74rem; font-weight:700; letter-spacing:0.08em;
    backdrop-filter:blur(6px);
}
.db-live-dot {
    width:7px; height:7px; border-radius:50%;
    background:#4ade80; box-shadow:0 0 6px #4ade80;
    animation:livePulse 1.4s infinite;
}
@keyframes livePulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(1.6)} }

/* ═══════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════ */
.db-stats {
    display: grid;
    grid-template-columns: repeat(6, minmax(0,1fr));
    gap: 14px; margin-bottom: 1.6rem;
}
@media(max-width:1200px){ .db-stats { grid-template-columns:repeat(3,1fr); } }
@media(max-width:600px)  { .db-stats { grid-template-columns:repeat(2,1fr); } }

.db-sc {
    background: var(--card);
    border: 1px solid var(--card-border);
    border-radius: 18px;
    padding: 1.2rem 1.1rem 1rem;
    position: relative; overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: transform var(--ease), box-shadow var(--ease), border-color var(--ease);
    animation: scUp 0.42s ease both;
    cursor: default;
}
.db-sc:hover { transform:translateY(-5px); box-shadow:var(--card-hov-sh); border-color:var(--sc-c); }

/* top color strip */
.db-sc::before {
    content:''; position:absolute; top:0; left:0; right:0;
    height:3px; border-radius:18px 18px 0 0;
    background: var(--sc-c);
    transform: scaleX(0); transform-origin:left;
    transition: transform 0.7s cubic-bezier(.4,0,.2,1);
}
.db-sc.loaded::before { transform:scaleX(1); }

/* subtle gradient overlay */
.db-sc::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(135deg, color-mix(in srgb, var(--sc-c) 5%, transparent) 0%, transparent 60%);
}

/* accent colours */
.db-sc.ac-amber   { --sc-c: var(--c-amber);  }
.db-sc.ac-blue    { --sc-c: var(--c-blue);   }
.db-sc.ac-cyan    { --sc-c: var(--c-cyan);   }
.db-sc.ac-green   { --sc-c: var(--c-green);  }
.db-sc.ac-violet  { --sc-c: var(--c-violet); }
.db-sc.ac-rose    { --sc-c: var(--c-rose);   }

.sc-inner { position:relative; z-index:1; }
.sc-top   { display:flex; align-items:center; justify-content:space-between; margin-bottom:0.6rem; }
.sc-lbl   { font-size:0.62rem; font-weight:700; text-transform:uppercase; letter-spacing:0.09em; color:var(--text-s); }

.sc-icon-pill {
    width:30px; height:30px; border-radius:9px;
    display:flex; align-items:center; justify-content:center;
    font-size:0.82rem; flex-shrink:0;
    background: color-mix(in srgb, var(--sc-c) 14%, transparent);
    color: var(--sc-c);
    transition: transform var(--ease);
}
.db-sc:hover .sc-icon-pill { transform:rotate(-8deg) scale(1.15); }

.sc-val {
    font-size:2.2rem; font-weight:800;
    color:var(--sc-c); line-height:1;
    font-family:var(--mono); letter-spacing:-1px;
    margin-bottom:0.35rem;
    transition: color var(--ease);
}
.sc-val.sm { font-size:1.1rem; letter-spacing:0; font-family:var(--font); color:var(--sc-c); }

.sc-foot { display:flex; align-items:center; justify-content:space-between; margin-top:0.6rem; }
.sc-sub  { font-size:0.66rem; font-weight:600; color:var(--text-s); display:flex; align-items:center; gap:4px; }
.sc-sub.up     { color:var(--c-green); }
.sc-sub.warn   { color:var(--c-amber); }
.sc-sub.info   { color:var(--c-cyan); }
.sc-sub.purple { color:var(--c-violet); }
.sc-sub.rose   { color:var(--c-rose); }

.sc-bar-track { flex:1; height:3px; margin-left:10px; background:color-mix(in srgb, var(--sc-c) 13%, transparent); border-radius:99px; overflow:hidden; }
.sc-bar-fill  { height:100%; border-radius:99px; background:var(--sc-c); transform-origin:left; transform:scaleX(0); transition:transform 0.75s cubic-bezier(.4,0,.2,1) 0.1s; }
.db-sc.loaded .sc-bar-fill { transform:scaleX(1); }

.db-sc:nth-child(1){animation-delay:.03s}
.db-sc:nth-child(2){animation-delay:.08s}
.db-sc:nth-child(3){animation-delay:.13s}
.db-sc:nth-child(4){animation-delay:.18s}
.db-sc:nth-child(5){animation-delay:.23s}
.db-sc:nth-child(6){animation-delay:.28s}
@keyframes scUp { from{opacity:0;transform:translateY(16px) scale(.96)} to{opacity:1;transform:translateY(0) scale(1)} }

.db-pend-blink { animation:blink 1.3s infinite; }
@keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.6)} }

/* ═══════════════════════════════════════
   PANELS (Recent Orders / Reservations)
═══════════════════════════════════════ */
.db-panel {
    background: var(--card);
    border: 1px solid var(--card-border);
    border-radius: 20px; overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: box-shadow var(--ease), transform var(--ease);
    animation: scUp 0.46s ease both;
    height: 100%;
}
.db-panel:hover { box-shadow:var(--card-hov-sh); transform:translateY(-3px); }

.db-ph {
    padding: 1rem 1.4rem;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
}
.db-ph::before { content:''; position:absolute; inset:0; background:linear-gradient(105deg, var(--ph-a) 0%, var(--ph-b) 100%); }
.db-ph.ph-blue { --ph-a:#1d4ed8; --ph-b:#3b82f6; }
.db-ph.ph-teal { --ph-a:#0e7490; --ph-b:#0891b2; }
.db-ph > * { position:relative; z-index:1; }

.db-ph h6 { margin:0; color:#fff; font-weight:700; font-size:0.84rem; display:flex; align-items:center; gap:8px; }
.db-ph h6 i { opacity:.85; font-size:.76rem; }

.db-view-all {
    background:rgba(255,255,255,0.18); color:#fff;
    border:1px solid rgba(255,255,255,0.28);
    padding:5px 14px; border-radius:20px;
    font-size:0.72rem; font-weight:600; text-decoration:none;
    display:inline-flex; align-items:center; gap:5px;
    transition: all var(--ease);
}
.db-view-all:hover { background:rgba(255,255,255,0.30); color:#fff; gap:8px; text-decoration:none; }

/* ═══════════════════════════════════════
   TABLE
═══════════════════════════════════════ */
.db-tbl { width:100%; border-collapse:collapse; }
.db-tbl thead { background: linear-gradient(135deg, #1d4ed8, #3b82f6); }
.db-tbl thead th {
    color:rgba(255,255,255,0.88);
    font-size:0.65rem; font-weight:800;
    text-transform:uppercase; letter-spacing:0.09em;
    padding:10px 16px; border:none; white-space:nowrap;
}
.db-tbl tbody tr {
    border-bottom:1px solid var(--divider);
    transition:background var(--ease);
    animation:rowIn 0.35s ease both;
}
.db-tbl.teal-head thead { background: linear-gradient(135deg, #0e7490, #0891b2); }

.db-tbl tbody tr:last-child { border-bottom:none; }
.db-tbl tbody tr:hover { background:var(--row-hov); }
.db-tbl tbody td { padding:10px 16px; vertical-align:middle; font-size:0.83rem; color:var(--text-b); border:none; }
.db-tbl tbody tr:nth-child(1){animation-delay:.04s}
.db-tbl tbody tr:nth-child(2){animation-delay:.09s}
.db-tbl tbody tr:nth-child(3){animation-delay:.14s}
.db-tbl tbody tr:nth-child(4){animation-delay:.19s}
.db-tbl tbody tr:nth-child(5){animation-delay:.24s}
@keyframes rowIn { from{opacity:0;transform:translateX(-8px)} to{opacity:1;transform:translateX(0)} }

/* ── Table elements ── */
.db-oid {
    background:var(--c-blue-s); color:var(--c-blue);
    border:1px solid var(--c-blue-s);
    padding:3px 9px; border-radius:7px;
    font-size:0.74rem; font-weight:700; font-family:var(--mono);
}
.db-avatar {
    width:32px; height:32px; border-radius:9px;
    display:inline-flex; align-items:center; justify-content:center;
    font-weight:700; font-size:0.72rem; color:#fff; flex-shrink:0;
}
.db-cname { font-size:0.84rem; font-weight:600; color:var(--text-h); }
.db-amount {
    font-weight:700; color:var(--c-green); font-size:0.84rem;
    font-family:var(--mono); background:var(--c-green-s);
    padding:3px 9px; border-radius:7px; border:1px solid var(--c-green-s);
}
.db-chip {
    padding:3px 10px; border-radius:8px;
    font-size:0.72rem; font-weight:700;
    display:inline-flex; align-items:center; gap:4px;
}
.chip-dine { background:var(--c-blue-s);  color:var(--c-blue);  border:1px solid var(--c-blue-s); }
.chip-take { background:var(--c-amber-s); color:var(--c-amber); border:1px solid var(--c-amber-s); }

/* status pill */
.db-pill {
    padding:4px 11px; border-radius:20px;
    font-size:0.68rem; font-weight:700;
    text-transform:uppercase; letter-spacing:0.05em;
    display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
}
.db-pill .pdot { width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }
.pill-pending   { background:var(--c-amber-s);  color:var(--c-amber);  border:1px solid var(--c-amber-s); }
.pill-cooking   { background:var(--c-rose-s);   color:var(--c-rose);   border:1px solid var(--c-rose-s); }
.pill-ready     { background:var(--c-green-s);  color:var(--c-green);  border:1px solid var(--c-green-s); }
.pill-served    { background:var(--c-cyan-s);   color:var(--c-cyan);   border:1px solid var(--c-cyan-s); }
.pill-completed { background:var(--c-blue-s);   color:var(--c-blue);   border:1px solid var(--c-blue-s); }
.pill-cancelled { background:rgba(100,116,139,0.12); color:#64748b; border:1px solid rgba(100,116,139,0.15); }
.pill-confirmed { background:var(--c-green-s);  color:var(--c-green);  border:1px solid var(--c-green-s); }
.pill-processing{ background:var(--c-violet-s); color:var(--c-violet); border:1px solid var(--c-violet-s); }

.db-gname { font-weight:600; font-size:0.84rem; color:var(--text-h); }
.db-gsub  { font-size:0.7rem; color:var(--text-s); display:flex; align-items:center; gap:3px; margin-top:2px; }
.db-dMain { font-weight:600; font-size:0.8rem; color:var(--text-h); display:flex; align-items:center; gap:4px; }
.db-dSub  { font-size:0.7rem; color:var(--text-s); display:flex; align-items:center; gap:3px; margin-top:2px; }

.db-empty { text-align:center; padding:2.5rem 1rem; }
.db-empty i { font-size:2rem; color:var(--text-m); opacity:.4; display:block; margin-bottom:8px; }
.db-empty p { margin:0; font-size:0.82rem; color:var(--text-m); }

/* ═══════════════════════════════════════
   QUICK ACTIONS
═══════════════════════════════════════ */
.db-qa {
    background:var(--card); border:1px solid var(--card-border);
    border-radius:20px; overflow:hidden;
    box-shadow:var(--card-shadow);
    animation: scUp 0.5s 0.3s ease both;
    margin-top:1.6rem;
}
.db-qa-head {
    padding:12px 20px; border-bottom:1px solid var(--divider);
    display:flex; align-items:center; gap:8px;
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
}
.db-qa-head i  { color:#fbbf24; font-size:0.84rem; }
.db-qa-head h6 { margin:0; font-weight:700; font-size:0.86rem; color:#fff; }
.db-qa-head span { color:rgba(255,255,255,0.65); font-size:0.74rem; margin-left:auto; }

.db-qa-body {
    padding:16px 20px; background:var(--qa-bg);
    display:flex; flex-wrap:wrap; gap:10px;
}
.db-qa-btn {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 18px; border-radius:12px;
    font-size:0.82rem; font-weight:700;
    text-decoration:none; border:1.5px solid transparent;
    transition:all var(--ease); position:relative; overflow:hidden;
}
.db-qa-btn i { font-size:.78rem; transition:transform var(--ease); }
.db-qa-btn:hover { transform:translateY(-3px); text-decoration:none; box-shadow:0 8px 20px rgba(0,0,0,0.15); color:#fff !important; }
.db-qa-btn:hover i { transform:scale(1.2) rotate(-5deg); }

.qa-blue    { color:var(--c-blue);   background:var(--c-blue-s);   border-color:var(--c-blue-s); }
.qa-blue:hover    { background:var(--c-blue);   border-color:var(--c-blue); }
.qa-green   { color:var(--c-green);  background:var(--c-green-s);  border-color:var(--c-green-s); }
.qa-green:hover   { background:var(--c-green);  border-color:var(--c-green); }
.qa-cyan    { color:var(--c-cyan);   background:var(--c-cyan-s);   border-color:var(--c-cyan-s); }
.qa-cyan:hover    { background:var(--c-cyan);   border-color:var(--c-cyan); }
.qa-amber   { color:var(--c-amber);  background:var(--c-amber-s);  border-color:var(--c-amber-s); }
.qa-amber:hover   { background:var(--c-amber);  border-color:var(--c-amber); }
.qa-rose    { color:var(--c-rose);   background:var(--c-rose-s);   border-color:var(--c-rose-s); }
.qa-rose:hover    { background:var(--c-rose);   border-color:var(--c-rose); }
.qa-violet  { color:var(--c-violet); background:var(--c-violet-s); border-color:var(--c-violet-s); }
.qa-violet:hover  { background:var(--c-violet); border-color:var(--c-violet); }

.qa-ripple {
    position:absolute; width:6px; height:6px; border-radius:50%;
    background:rgba(255,255,255,0.45); pointer-events:none;
    animation:ripOut .5s ease-out forwards;
}
@keyframes ripOut { to{transform:scale(30);opacity:0} }

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media(max-width:768px){
    .db-banner { padding:1.5rem; }
    .db-banner-text h1 { font-size:1.4rem; }
    .sc-val { font-size:1.7rem; }
    .sc-val.sm { font-size:0.95rem; }
    .db-qa-btn { width:100%; justify-content:center; }
    .db-tbl thead th, .db-tbl tbody td { padding:8px 10px; }
}
</style>
@endpush

@section('content')
<div class="db-wrap">

{{-- ══════════ BANNER HEADER ══════════ --}}
<div class="db-banner mb-4">
    <div class="db-banner-inner">
        <div class="db-banner-left">
            <div class="db-banner-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="db-banner-text">
                <h1>Dashboard</h1>
                <p>Welcome back! Here's what's happening today.</p>
            </div>
        </div>
        <div class="db-banner-right">
            <div class="db-time-badge">
                <i class="fas fa-calendar-alt"></i>
                <span id="currentDate"></span>
            </div>
            <span class="db-live-badge">
                <span class="db-live-dot"></span>
                LIVE
            </span>
        </div>
    </div>
</div>

{{-- ══════════ STAT CARDS ══════════ --}}
<div class="db-stats mb-4">

    <div class="db-sc ac-amber">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Pending Orders</span>
                <span class="sc-icon-pill"><i class="fas fa-hourglass-half"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="{{ $stats['pending_orders'] }}">0</div>
            <div class="sc-foot">
                <span class="sc-sub warn"><i class="fas fa-circle db-pend-blink"></i> Awaiting</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-blue">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Total Orders</span>
                <span class="sc-icon-pill"><i class="fas fa-receipt"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="{{ $stats['total_orders'] }}">0</div>
            <div class="sc-foot">
                <span class="sc-sub up"><i class="fas fa-arrow-up"></i> All time</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-cyan">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Reservations</span>
                <span class="sc-icon-pill"><i class="fas fa-calendar-alt"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="{{ $stats['total_reservations'] }}">0</div>
            <div class="sc-foot">
                <span class="sc-sub info"><i class="fas fa-calendar-check"></i> Booked</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-green">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Today Revenue</span>
                <span class="sc-icon-pill"><i class="fas fa-rupee-sign"></i></span>
            </div>
            <div class="sc-val sm">Rs.&nbsp;{{ number_format($stats['today_revenue'], 0) }}</div>
            <div class="sc-foot">
                <span class="sc-sub up"><i class="fas fa-arrow-up"></i> Today</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-violet">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Menu Items</span>
                <span class="sc-icon-pill"><i class="fas fa-utensils"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="{{ $stats['total_menu_items'] }}">0</div>
            <div class="sc-foot">
                <span class="sc-sub purple"><i class="fas fa-list"></i> Active</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-rose">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Total Users</span>
                <span class="sc-icon-pill"><i class="fas fa-users"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="{{ $stats['total_users'] }}">0</div>
            <div class="sc-foot">
                <span class="sc-sub rose"><i class="fas fa-user-plus"></i> Registered</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

</div>

{{-- ══════════ TABLES ROW ══════════ --}}
<div class="row mb-0">

    {{-- Recent Orders --}}
    <div class="col-lg-7 mb-4">
        <div class="db-panel" style="animation-delay:.16s">
            <div class="db-ph ph-blue">
                <h6><i class="fas fa-receipt"></i> Recent Orders</h6>
                <a href="{{ route('admin.orders.index') }}" class="db-view-all">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="db-tbl">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        @php
                            $h  = abs(crc32($order->user->name ?? 'G')) % 360;
                            $h2 = ($h + 50) % 360;
                            $pm = [
                                'pending'   => ['pill-pending',   true],
                                'cooking'   => ['pill-cooking',   true],
                                'ready'     => ['pill-ready',     false],
                                'served'    => ['pill-served',    false],
                                'completed' => ['pill-completed', false],
                                'cancelled' => ['pill-cancelled', false],
                                'processing'=> ['pill-processing',false],
                            ];
                            [$pc, $bl] = $pm[$order->status] ?? ['pill-pending', false];
                        @endphp
                        <tr>
                            <td><span class="db-oid">#{{ $order->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center" style="gap:8px">
                                    <span class="db-avatar" style="background:linear-gradient(135deg,hsl({{$h}},52%,46%),hsl({{$h2}},52%,36%))">
                                        {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                    </span>
                                    <span class="db-cname">{{ $order->user->name ?? 'Guest' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($order->table)
                                    <span class="db-chip chip-dine">
                                        <i class="fas fa-chair"></i> T#{{ $order->table->table_number }}
                                    </span>
                                @else
                                    <span class="db-chip chip-take">
                                        <i class="fas fa-shopping-bag"></i> Takeaway
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="db-amount">Rs.&nbsp;{{ number_format($order->total_amount, 0) }}</span>
                            </td>
                            <td>
                                <span class="db-pill {{ $pc }}">
                                    <span class="pdot {{ $bl ? 'db-pend-blink' : '' }}"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5">
                            <div class="db-empty">
                                <i class="fas fa-receipt"></i>
                                <p>No orders yet</p>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Reservations --}}
    <div class="col-lg-5 mb-4">
        <div class="db-panel" style="animation-delay:.22s">
            <div class="db-ph ph-teal">
                <h6><i class="fas fa-calendar-alt"></i> Recent Reservations</h6>
                <a href="{{ route('admin.reservations.index') }}" class="db-view-all">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="db-tbl teal-head">
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReservations as $res)
                        @php
                            $gh  = abs(crc32($res->guest_name)) % 360;
                            $gh2 = ($gh + 50) % 360;
                            $rm  = [
                                'confirmed' => ['pill-confirmed', false],
                                'pending'   => ['pill-pending',   true],
                                'cancelled' => ['pill-cancelled', false],
                                'completed' => ['pill-completed', false],
                            ];
                            [$rp, $rb] = $rm[$res->status] ?? ['pill-pending', false];
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center" style="gap:8px">
                                    <span class="db-avatar" style="background:linear-gradient(135deg,hsl({{$gh}},52%,46%),hsl({{$gh2}},52%,36%))">
                                        {{ strtoupper(substr($res->guest_name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <div class="db-gname">{{ $res->guest_name }}</div>
                                        <div class="db-gsub">
                                            <i class="fas fa-phone" style="font-size:.55rem"></i>
                                            {{ $res->guest_phone }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="db-dMain">
                                    <i class="fas fa-calendar" style="color:var(--c-blue);font-size:.65rem"></i>
                                    {{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}
                                </div>
                                <div class="db-dSub">
                                    <i class="fas fa-clock" style="font-size:.58rem"></i>
                                    {{ $res->reservation_time }}
                                </div>
                            </td>
                            <td>
                                <span class="db-pill {{ $rp }}">
                                    <span class="pdot {{ $rb ? 'db-pend-blink' : '' }}"></span>
                                    {{ ucfirst($res->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3">
                            <div class="db-empty">
                                <i class="fas fa-calendar-times"></i>
                                <p>No reservations yet</p>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ══════════ QUICK ACTIONS ══════════ --}}
<div class="db-qa">
    <div class="db-qa-head">
        <i class="fas fa-bolt"></i>
        <h6>Quick Actions</h6>
        <span>Shortcuts to common tasks</span>
    </div>
    <div class="db-qa-body">
        <a href="{{ route('admin.categories.create') }}"  class="db-qa-btn qa-blue">
            <i class="fas fa-layer-group"></i> Add Category
        </a>
        <a href="{{ route('admin.menu.create') }}"        class="db-qa-btn qa-green">
            <i class="fas fa-utensils"></i> Add Menu Item
        </a>
        <a href="{{ route('admin.tables.create') }}"      class="db-qa-btn qa-cyan">
            <i class="fas fa-chair"></i> Add Table
        </a>
        <a href="{{ route('admin.orders.index') }}"       class="db-qa-btn qa-amber">
            <i class="fas fa-receipt"></i> View Orders
        </a>
        <a href="{{ route('admin.reservations.index') }}" class="db-qa-btn qa-rose">
            <i class="fas fa-calendar-check"></i> View Reservations
        </a>
        <a href="{{ route('admin.menu.index') }}"         class="db-qa-btn qa-violet">
            <i class="fas fa-hamburger"></i> View Menu
        </a>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Live Date ──
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
        const now = new Date();
        dateEl.textContent = now.toLocaleDateString('en-PK', {
            weekday:'short', day:'numeric', month:'short', year:'numeric'
        });
    }

    // ── Counter Animation ──
    document.querySelectorAll('.db-counter').forEach(el => {
        const target = parseInt(el.dataset.target) || 0;
        if (!target) return;
        const dur = 900, fps = 60;
        const steps = dur / (1000 / fps);
        let f = 0;
        const t = setInterval(() => {
            f++;
            const ease = 1 - Math.pow(1 - f / steps, 3);
            el.textContent = Math.round(ease * target);
            if (f >= steps) { el.textContent = target; clearInterval(t); }
        }, 1000 / fps);
    });

    // ── Accent bar + strip animation ──
    setTimeout(() => {
        document.querySelectorAll('.db-sc').forEach((c, i) => {
            setTimeout(() => c.classList.add('loaded'), i * 80);
        });
    }, 250);

    // ── Ripple on Quick Actions ──
    document.querySelectorAll('.db-qa-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const r = this.getBoundingClientRect();
            const d = document.createElement('span');
            d.className = 'qa-ripple';
            d.style.top  = (e.clientY - r.top  - 3) + 'px';
            d.style.left = (e.clientX - r.left - 3) + 'px';
            this.appendChild(d);
            setTimeout(() => d.remove(), 520);
        });
    });

    // ── Dark mode detection ──
    const dark = document.body.classList.contains('dark-mode') ||
                 document.body.classList.contains('dark') ||
                 document.documentElement.getAttribute('data-theme')    === 'dark' ||
                 document.documentElement.getAttribute('data-bs-theme') === 'dark';
    if (dark) document.documentElement.setAttribute('data-theme', 'dark');

});
</script>
@endpush
