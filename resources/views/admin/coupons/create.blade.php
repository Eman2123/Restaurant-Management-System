@extends('layouts.admin')
@section('title', 'Create Coupon')
@section('page-title', 'Create Coupon')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

  /* ========== LIGHT THEME ========== */
  .coupon-wrapper {
    --card-bg:           #ffffff;
    --card-shadow:       0 2px 12px rgba(0,0,0,0.06);
    --card-hover-shadow: 0 12px 40px rgba(0,0,0,0.13);
    --text-primary:      #1a2535;
    --text-secondary:    #4a5568;
    --text-muted:        #94a3b8;
    --section-bg:        #f4f6f9;
    --border-color:      rgba(0,0,0,0.08);
    --input-bg:          #f8fafc;
    --input-border:      rgba(0,0,0,0.12);
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
    --c-amber:           #d97706;
    --c-amber-soft:      rgba(217,119,6,0.12);
    --header-grad:       linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --ticket-bg:         linear-gradient(135deg, #1a2535 0%, #0d1117 100%);
  }

  /* ========== DARK THEME ========== */
  body.dark-mode .coupon-wrapper,
  body.sidebar-dark-primary .coupon-wrapper,
  [data-theme="dark"] .coupon-wrapper,
  [data-bs-theme="dark"] .coupon-wrapper {
    --card-bg:           #1e2733;
    --card-shadow:       0 2px 12px rgba(0,0,0,0.4);
    --card-hover-shadow: 0 12px 40px rgba(0,0,0,0.6);
    --text-primary:      #e4eef8;
    --text-secondary:    #7a9ab8;
    --text-muted:        #4a6278;
    --section-bg:        #141a21;
    --border-color:      rgba(255,255,255,0.07);
    --input-bg:          #141a21;
    --input-border:      rgba(255,255,255,0.10);
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
    --c-amber:           #fbbf24;
    --c-amber-soft:      rgba(251,191,36,0.13);
    --ticket-bg:         linear-gradient(135deg, #0d1117 0%, #060a0f 100%);
  }

  /* ========== BASE ========== */
  .coupon-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
  .coupon-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
  @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

  /* ========== GRADIENT HEADER ========== */
  .coupon-header {
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
  .coupon-header::before {
    content:''; position:absolute; top:-110px; right:-70px;
    width:340px; height:340px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.14) 0%, transparent 70%);
    animation: float1 18s ease-in-out infinite;
  }
  .coupon-header::after {
    content:''; position:absolute; bottom:-110px; left:-50px;
    width:290px; height:290px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    animation: float2 14s ease-in-out infinite;
  }
  @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
  @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

  .coupon-header-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 1rem;
  }
  .coupon-header-left { display:flex; align-items:center; gap:1.2rem; }
  .coupon-header-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.22);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: white;
    border: 2px solid rgba(255,255,255,0.28);
  }
  .coupon-header h1 {
    color: white; font-size: 1.9rem; font-weight: 800;
    margin: 0; letter-spacing: -0.5px;
  }
  .coupon-header p {
    color: rgba(255,255,255,0.85); font-size: 0.92rem;
    margin: 3px 0 0; font-weight: 500;
  }
  .header-breadcrumb {
    display: flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,0.16);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 12px; padding: 8px 16px;
    font-size: 0.82rem; font-weight: 600; color: white;
    text-decoration: none;
  }
  .header-breadcrumb:hover { background: rgba(255,255,255,0.24); color: white; text-decoration: none; }
  .header-breadcrumb i { font-size: 0.85rem; }

  /* ========== BODY ========== */
  .coupon-body { padding: 0 1.5rem 2rem; }

  /* ========== STEPS BAR ========== */
  .steps-bar {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 1rem 1.5rem;
    box-shadow: var(--card-shadow);
    display: flex; align-items: center;
    gap: 0; overflow-x: auto;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.4s ease;
  }
  @keyframes fadeInUp {
    from { opacity:0; transform:translateY(12px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .step { display:flex; align-items:center; gap:10px; flex-shrink:0; }
  .step-dot {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.78rem; font-weight: 800;
    background: linear-gradient(135deg, var(--c-amber), var(--c-warning));
    color: #fff;
    box-shadow: 0 2px 10px rgba(217,119,6,0.3);
    flex-shrink: 0;
  }
  .step-name {
    font-size: 0.82rem; font-weight: 700; color: var(--text-primary);
    white-space: nowrap;
  }
  .step-sub {
    font-size: 0.68rem; color: var(--text-muted); white-space: nowrap;
  }
  .step-line {
    flex: 1; height: 2px;
    background: var(--border-color);
    margin: 0 12px; min-width: 24px; border-radius: 1px;
  }

  /* ========== LAYOUT ========== */
  .coupon-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 16px;
    align-items: start;
  }
  @media(max-width:960px){ .coupon-layout { grid-template-columns: 1fr; } }

  /* ========== SECTION CARD ========== */
  .section-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    margin-bottom: 16px;
    animation: fadeInUp 0.4s ease both;
  }
  .section-card:nth-child(1){ animation-delay:0.05s; }
  .section-card:nth-child(2){ animation-delay:0.10s; }
  .section-card:nth-child(3){ animation-delay:0.15s; }
  .section-card:last-child { margin-bottom: 0; }

  .section-header {
    padding: 1rem 1.4rem;
    border-bottom: 1px solid var(--border-color);
    display: flex; align-items: center; gap: 10px;
    background: var(--section-bg);
  }
  .section-header-icon {
    width: 32px; height: 32px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; flex-shrink: 0;
  }
  .section-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); flex:1; }
  .section-step-badge { font-size: 0.7rem; color: var(--text-muted); white-space: nowrap; }
  .section-body { padding: 1.4rem; }

  /* Group label */
  .group-label {
    font-size: 0.68rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: var(--c-accent); margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border-color);
    display: flex; align-items: center; gap: 6px;
  }

  /* ========== FORM ELEMENTS ========== */
  .form-label {
    font-size: 0.80rem; font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 6px; display: flex;
    align-items: center; gap: 5px;
  }
  .form-label i { font-size: 0.85rem; color: var(--text-muted); }
  .req { color: var(--c-danger); font-size: 0.7rem; }

  .form-hint {
    font-size: 0.71rem; color: var(--text-muted);
    margin-top: 5px; display: flex;
    align-items: center; gap: 4px;
  }

  .input-wrap { position: relative; display: flex; align-items: center; }
  .input-prefix {
    position: absolute; left: 11px;
    color: var(--text-muted); font-size: 0.88rem;
    pointer-events: none; z-index: 1;
    display: flex; align-items: center;
  }
  .input-prefix-text {
    position: absolute; left: 11px;
    color: var(--text-muted); font-size: 0.76rem;
    font-weight: 700; pointer-events: none; z-index: 1;
  }
  .input-suffix {
    position: absolute; right: 10px;
    color: var(--text-muted); font-size: 0.72rem;
    font-weight: 700; background: var(--section-bg);
    padding: 2px 8px; border-radius: 6px;
    border: 1px solid var(--border-color);
    pointer-events: none;
  }

  .form-input,
  .form-select {
    width: 100%; padding: 9px 12px;
    background: var(--card-bg) !important;
    border: 1.5px solid var(--input-border) !important;
    border-radius: 10px !important;
    color: var(--text-primary) !important;
    font-size: 0.875rem; outline: none;
    transition: all 0.2s;
    font-family: var(--font-main) !important;
    -webkit-appearance: none; appearance: none;
  }
  .form-input::placeholder { color: var(--text-muted) !important; }
  .form-input:focus,
  .form-select:focus {
    border-color: var(--c-amber) !important;
    box-shadow: 0 0 0 3px var(--c-amber-soft) !important;
    background: var(--card-bg) !important;
  }
  .form-input.is-invalid { border-color: var(--c-danger) !important; box-shadow: 0 0 0 3px var(--c-danger-soft) !important; }
  .input-wrap .form-input { padding-left: 34px; padding-right: 44px; }
  .form-input--code {
    font-family: var(--font-mono) !important;
    font-size: 0.95rem !important; font-weight: 800 !important;
    letter-spacing: 0.12em; text-transform: uppercase;
  }

  /* code + generate row */
  .code-group { display:flex; gap:8px; align-items:center; }
  .code-group .input-wrap { flex:1; }
  .btn-generate {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 9px 14px; background: transparent;
    border: 1.5px solid var(--input-border);
    border-radius: 10px; color: var(--text-muted);
    font-size: 0.80rem; font-weight: 700;
    cursor: pointer; transition: all 0.2s;
    white-space: nowrap; flex-shrink: 0;
    font-family: var(--font-main);
  }
  .btn-generate:hover {
    border-color: var(--c-amber); color: var(--c-amber);
    background: var(--c-amber-soft);
  }
  .btn-generate.spinning i { animation: spin360 0.5s linear; }
  @keyframes spin360 { to { transform: rotate(360deg); } }

  /* ========== DISCOUNT TYPE CARDS ========== */
  .type-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
  .type-radio { display:none; }
  .type-card {
    display: flex; flex-direction: column; align-items: center;
    gap: 8px; padding: 14px 10px;
    border: 2px solid var(--input-border);
    border-radius: 14px; cursor: pointer;
    transition: all 0.2s;
    background: var(--card-bg);
    text-align: center; position: relative;
  }
  .type-card:hover {
    border-color: rgba(217,119,6,0.4);
    background: var(--c-amber-soft);
  }
  .type-radio:checked + .type-card.pct {
    border-color: var(--c-purple);
    background: var(--c-purple-soft);
    box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
  }
  .type-radio:checked + .type-card.fixed {
    border-color: var(--c-accent);
    background: var(--c-accent-soft);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
  }
  .type-check {
    position: absolute; top:8px; right:9px;
    width: 18px; height: 18px; border-radius: 50%;
    background: transparent; border: 2px solid var(--input-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.55rem; color: transparent; transition: all 0.2s;
  }
  .type-radio:checked + .type-card.pct .type-check { background:var(--c-purple); border-color:var(--c-purple); color:#fff; }
  .type-radio:checked + .type-card.fixed .type-check { background:var(--c-accent); border-color:var(--c-accent); color:#fff; }
  .type-icon {
    width:38px; height:38px; border-radius:10px;
    display:flex; align-items:center; justify-content:center; font-size:1.1rem;
  }
  .type-icon.pct   { background:var(--c-purple-soft); color:var(--c-purple); border:1px solid rgba(124,58,237,0.15); }
  .type-icon.fixed { background:var(--c-accent-soft);  color:var(--c-accent);  border:1px solid rgba(37,99,235,0.15); }
  .type-name    { font-size:0.78rem; font-weight:700; color:var(--text-primary); }
  .type-example { font-size:0.67rem; color:var(--text-muted); }

  /* ========== PRESETS ========== */
  .presets-label { font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:var(--text-muted); margin-bottom:6px; }
  .presets { display:flex; flex-wrap:wrap; gap:6px; }
  .preset-chip {
    padding: 4px 12px; border-radius: 20px;
    border: 1.5px solid var(--input-border);
    background: transparent; color: var(--text-muted);
    font-size: 0.73rem; font-weight: 700;
    cursor: pointer; transition: all 0.18s;
    font-family: var(--font-main);
  }
  .preset-chip:hover {
    border-color: var(--c-amber); color: var(--c-amber);
    background: var(--c-amber-soft);
  }

  /* ========== FORM GRID ========== */
  .form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
  .form-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
  @media(max-width:640px){
    .form-grid-2, .form-grid-3 { grid-template-columns:1fr; }
  }

  /* ========== TOGGLE ========== */
  .toggle-row {
    display: flex; align-items: center;
    justify-content: space-between; gap: 14px;
    padding: 13px 16px;
    background: var(--section-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
  }
  .toggle-label { font-size:0.88rem; font-weight:700; color:var(--text-primary); display:flex; align-items:center; gap:7px; }
  .toggle-desc  { font-size:0.74rem; color:var(--text-muted); margin-top:2px; }
  .custom-switch { position:relative; width:46px; height:26px; display:inline-block; flex-shrink:0; }
  .custom-switch input { display:none; }
  .switch-track {
    position:absolute; inset:0;
    background:var(--input-border); border-radius:26px;
    cursor:pointer; transition:all 0.25s;
  }
  .switch-track::after {
    content:''; position:absolute; top:3px; left:3px;
    width:20px; height:20px;
    background:white; border-radius:50%;
    transition:transform 0.25s;
    box-shadow:0 1px 4px rgba(0,0,0,0.2);
  }
  .custom-switch input:checked + .switch-track { background:var(--c-success); }
  .custom-switch input:checked + .switch-track::after { transform:translateX(20px); }

  /* ========== FORM ACTIONS ========== */
  .form-actions {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.4rem;
    border-top: 1px solid var(--border-color);
    background: var(--section-bg);
    gap: 10px; flex-wrap: wrap;
  }
  .btn-back {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; background: transparent;
    border: 1.5px solid var(--input-border);
    border-radius: 10px; color: var(--text-secondary);
    font-size: 0.85rem; font-weight: 700;
    cursor: pointer; text-decoration: none;
    transition: all 0.2s; font-family: var(--font-main);
  }
  .btn-back:hover {
    border-color: var(--border-color);
    color: var(--text-primary);
    background: var(--card-bg);
    text-decoration: none;
  }
  .btn-create {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 24px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff; border: none; border-radius: 10px;
    font-size: 0.88rem; font-weight: 800;
    cursor: pointer; transition: all 0.2s;
    font-family: var(--font-main);
    text-transform: uppercase; letter-spacing: 0.04em;
    box-shadow: 0 4px 14px rgba(217,119,6,0.35);
  }
  .btn-create:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(217,119,6,0.45);
  }
  .btn-create:active { transform: translateY(0); }
  .btn-spinner {
    display:none; width:14px; height:14px;
    border:2px solid rgba(255,255,255,0.4);
    border-top-color:#fff; border-radius:50%;
    animation:rotate360 0.6s linear infinite;
  }
  @keyframes rotate360 { to { transform:rotate(360deg); } }
  .btn-create.is-loading .btn-spinner { display:block; }
  .btn-create.is-loading span { opacity:.7; }

  /* ========== ERROR BOX ========== */
  .error-box {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 12px 14px;
    background: var(--c-danger-soft);
    border: 1px solid rgba(220,38,38,0.2);
    border-radius: 12px; margin-bottom: 16px;
    animation: fadeInUp 0.3s ease;
  }
  .error-icon {
    width:32px; height:32px; border-radius:8px;
    background:var(--c-danger-soft);
    border:1px solid rgba(220,38,38,0.2);
    display:flex; align-items:center; justify-content:center;
    color:var(--c-danger); font-size:1rem; flex-shrink:0;
  }
  .error-title { font-size:0.82rem; font-weight:700; color:var(--c-danger); margin-bottom:4px; }
  .error-list { list-style:none; padding:0; margin:0; }
  .error-list li {
    font-size:0.78rem; color:var(--text-muted);
    display:flex; align-items:baseline; gap:6px; padding:2px 0;
  }
  .error-list li::before {
    content:''; width:4px; height:4px; border-radius:50%;
    background:var(--c-danger); flex-shrink:0; margin-top:2px;
  }

  /* ========== SIDEBAR ========== */
  .sidebar { display:flex; flex-direction:column; gap:16px; }

  /* ── Ticket Preview ── */
  .ticket-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    animation: fadeInUp 0.4s ease 0.1s both;
  }
  .ticket-card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--section-bg);
    display: flex; align-items: center;
    justify-content: space-between;
  }
  .ticket-card-header-left {
    display:flex; align-items:center; gap:7px;
    font-size:0.82rem; font-weight:700; color:var(--text-primary);
  }
  .ticket-card-header-left i { color:var(--c-amber); }
  .live-dot {
    width:7px; height:7px; border-radius:50%;
    background:var(--c-success);
    animation:pulse 2s infinite;
  }
  @keyframes pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.5;transform:scale(.85);} }

  .ticket-body { padding: 1.25rem; }
  .ticket {
    background: var(--ticket-bg);
    border: 2px dashed rgba(245,158,11,0.28);
    border-radius: 14px;
    padding: 1.35rem 1.25rem;
    text-align: center;
    position: relative; overflow: hidden;
  }
  .ticket::before, .ticket::after {
    content:''; position:absolute;
    width:22px; height:22px; border-radius:50%;
    background: var(--card-bg);
    top:50%; transform:translateY(-50%);
  }
  .ticket::before { left:-11px; }
  .ticket::after  { right:-11px; }
  .ticket-restaurant {
    font-size:0.6rem; font-weight:800;
    text-transform:uppercase; letter-spacing:.14em;
    color:rgba(245,158,11,0.5); margin-bottom:8px;
    display:flex; align-items:center; justify-content:center; gap:5px;
  }
  .ticket-code-display {
    font-family:var(--font-mono);
    font-size:1.2rem; font-weight:900;
    color:#f59e0b; letter-spacing:.14em;
    margin-bottom:8px; word-break:break-all;
    transition:all 0.2s;
  }
  .ticket-value-display {
    font-size:2rem; font-weight:900; color:#fff;
    line-height:1; margin-bottom:4px; min-height:2.4rem;
    transition:all 0.2s;
  }
  .ticket-type-display {
    font-size:0.63rem; color:rgba(255,255,255,0.4);
    text-transform:uppercase; letter-spacing:.1em; margin-bottom:14px;
  }
  .ticket-divider { border:none; border-top:1px dashed rgba(245,158,11,0.18); margin:0 0 14px; }
  .ticket-meta-row { display:grid; grid-template-columns:repeat(3,1fr); gap:4px; }
  .ticket-meta-cell { display:flex; flex-direction:column; align-items:center; gap:2px; }
  .ticket-meta-val { font-size:0.72rem; font-weight:800; color:rgba(255,255,255,0.75); }
  .ticket-meta-key { font-size:0.57rem; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:.07em; }

  /* ── Quick Templates ── */
  .quick-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    animation: fadeInUp 0.4s ease 0.15s both;
  }
  .quick-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--section-bg);
    display:flex; align-items:center; gap:7px;
    font-size:0.82rem; font-weight:700; color:var(--text-primary);
  }
  .quick-header i { color:var(--c-purple); }
  .quick-body { padding: 1rem 1.25rem; }
  .quick-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
  .quick-btn {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    padding: 12px 8px;
    border: 1.5px solid var(--input-border);
    border-radius: 12px; background: transparent;
    cursor: pointer; transition: all 0.2s;
    text-align: center; font-family: var(--font-main);
  }
  .quick-btn:hover {
    border-color: var(--c-amber); background: var(--c-amber-soft);
    transform: translateY(-2px);
  }
  .quick-btn-icon {
    width:30px; height:30px; border-radius:8px;
    display:flex; align-items:center; justify-content:center; font-size:0.9rem;
  }
  .quick-btn-label { font-size:0.68rem; font-weight:700; color:var(--text-muted); }

  /* ── Tips Card ── */
  .tips-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    animation: fadeInUp 0.4s ease 0.2s both;
  }
  .tips-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--section-bg);
    display:flex; align-items:center; gap:7px;
    font-size:0.82rem; font-weight:700; color:var(--text-primary);
  }
  .tips-header i { color:var(--c-teal); }
  .tips-body { padding: 1rem 1.25rem; }
  .tip-item {
    display:flex; align-items:flex-start; gap:10px;
    padding:9px 0; border-bottom:1px solid var(--border-color);
  }
  .tip-item:last-child { border-bottom:none; padding-bottom:0; }
  .tip-icon {
    width:26px; height:26px; border-radius:7px;
    display:flex; align-items:center; justify-content:center;
    font-size:0.8rem; flex-shrink:0;
  }
  .tip-text { font-size:0.76rem; color:var(--text-muted); line-height:1.5; }
  .tip-text strong { color:var(--text-primary); }

  /* Responsive */
  @media(max-width:768px){
    .coupon-header { padding:1.5rem; }
    .coupon-header h1 { font-size:1.5rem; }
    .coupon-body { padding:0 1rem 1.5rem; }
  }
</style>
@endpush

@section('content')
<div class="coupon-wrapper">

  {{-- ── Gradient Header ── --}}
  <div class="coupon-header">
    <div class="coupon-header-inner">
      <div class="coupon-header-left">
        <div class="coupon-header-icon">
          <i class="fas fa-ticket-alt"></i>
        </div>
        <div>
          <h1>Create New Coupon</h1>
          <p>Set up a discount code for your customers</p>
        </div>
      </div>
      <a href="{{ route('admin.coupons.index') }}" class="header-breadcrumb">
        <i class="fas fa-arrow-left"></i> Back to Coupons
      </a>
    </div>
  </div>

  <div class="coupon-body">

    {{-- ── Steps Bar ── --}}
    <div class="steps-bar">
      <div class="step">
        <div class="step-dot">1</div>
        <div><div class="step-name">Identity</div><div class="step-sub">Code &amp; type</div></div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-dot">2</div>
        <div><div class="step-name">Discount</div><div class="step-sub">Value &amp; limits</div></div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-dot">3</div>
        <div><div class="step-name">Extras</div><div class="step-sub">Description &amp; status</div></div>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.coupons.store') }}" id="couponForm" novalidate>
      @csrf

      <div class="coupon-layout">

        {{-- ════ LEFT COLUMN ════ --}}
        <div>

          @if($errors->any())
          <div class="error-box">
            <div class="error-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
              <div class="error-title">Please fix the following errors</div>
              <ul class="error-list">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif

          {{-- ── Card 1: Identity ── --}}
          <div class="section-card">
            <div class="section-header">
              <div class="section-header-icon" style="background:var(--c-amber-soft);color:var(--c-amber);">
                <i class="fas fa-ticket-alt"></i>
              </div>
              <span class="section-title">Coupon Identity</span>
              <span class="section-step-badge">Step 1 of 3</span>
            </div>
            <div class="section-body">
              <div class="group-label"><i class="fas fa-code"></i> Code &amp; Discount Type</div>

              {{-- Code --}}
              <div style="margin-bottom:18px;">
                <label class="form-label" for="couponCode">
                  <i class="fas fa-barcode"></i> Coupon Code <span class="req">*</span>
                </label>
                <div class="code-group">
                  <div class="input-wrap">
                    <span class="input-prefix"><i class="fas fa-hashtag"></i></span>
                    <input type="text" id="couponCode" name="code"
                           class="form-input form-input--code {{ $errors->has('code') ? 'is-invalid' : '' }}"
                           value="{{ old('code') }}"
                           placeholder="e.g. SAVE20"
                           maxlength="20" required autocomplete="off"
                           oninput="syncPreview()">
                  </div>
                  <button type="button" class="btn-generate" id="generateBtn" onclick="generateCode()">
                    <i class="fas fa-sync-alt"></i> Generate
                  </button>
                </div>
                <div class="form-hint"><i class="fas fa-info-circle"></i> Max 20 chars — letters &amp; numbers only, auto-uppercased</div>
              </div>

              {{-- Discount Type --}}
              <div>
                <label class="form-label"><i class="fas fa-sliders-h"></i> Discount Type <span class="req">*</span></label>
                <div class="type-grid">
                  <div>
                    <input type="radio" class="type-radio" name="type" id="typePct" value="percentage"
                           onchange="syncPreview()" {{ old('type','percentage') === 'percentage' ? 'checked' : '' }}>
                    <label for="typePct" class="type-card pct">
                      <span class="type-check"><i class="fas fa-check"></i></span>
                      <div class="type-icon pct"><i class="fas fa-percentage"></i></div>
                      <span class="type-name">Percentage</span>
                      <span class="type-example">e.g. 20% OFF</span>
                    </label>
                  </div>
                  <div>
                    <input type="radio" class="type-radio" name="type" id="typeFixed" value="fixed"
                           onchange="syncPreview()" {{ old('type') === 'fixed' ? 'checked' : '' }}>
                    <label for="typeFixed" class="type-card fixed">
                      <span class="type-check"><i class="fas fa-check"></i></span>
                      <div class="type-icon fixed"><i class="fas fa-rupee-sign"></i></div>
                      <span class="type-name">Fixed Amount</span>
                      <span class="type-example">e.g. Rs.100 OFF</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ── Card 2: Discount Settings ── --}}
          <div class="section-card">
            <div class="section-header">
              <div class="section-header-icon" style="background:var(--c-purple-soft);color:var(--c-purple);">
                <i class="fas fa-tag"></i>
              </div>
              <span class="section-title">Discount Settings</span>
              <span class="section-step-badge">Step 2 of 3</span>
            </div>
            <div class="section-body">
              <div class="group-label"><i class="fas fa-sliders-h"></i> Value, Limits &amp; Expiry</div>

              <div class="form-grid-2" style="margin-bottom:14px;">

                {{-- Value --}}
                <div>
                  <label class="form-label" for="couponValue">
                    <i class="fas fa-tag"></i>
                    <span id="valueLbl">Discount Value (%)</span>
                    <span class="req">*</span>
                  </label>
                  <div class="input-wrap">
                    <span class="input-prefix" id="valuePrefix"><i class="fas fa-percentage"></i></span>
                    <input type="number" id="couponValue" name="value"
                           class="form-input {{ $errors->has('value') ? 'is-invalid' : '' }}"
                           value="{{ old('value') }}"
                           placeholder="e.g. 20" min="1" step="0.01" required
                           oninput="syncPreview()">
                    <span class="input-suffix" id="valueSuffix">%</span>
                  </div>
                  <div style="margin-top:10px;">
                    <div class="presets-label">Quick presets</div>
                    <div class="presets" id="presetsWrap">
                      <button type="button" class="preset-chip" onclick="applyPreset(5)">5%</button>
                      <button type="button" class="preset-chip" onclick="applyPreset(10)">10%</button>
                      <button type="button" class="preset-chip" onclick="applyPreset(15)">15%</button>
                      <button type="button" class="preset-chip" onclick="applyPreset(20)">20%</button>
                      <button type="button" class="preset-chip" onclick="applyPreset(25)">25%</button>
                      <button type="button" class="preset-chip" onclick="applyPreset(50)">50%</button>
                    </div>
                  </div>
                </div>

                {{-- Min Order --}}
                <div>
                  <label class="form-label" for="couponMinOrder">
                    <i class="fas fa-shopping-cart"></i> Minimum Order
                  </label>
                  <div class="input-wrap">
                    <span class="input-prefix-text">Rs.</span>
                    <input type="number" id="couponMinOrder" name="min_order"
                           class="form-input {{ $errors->has('min_order') ? 'is-invalid' : '' }}"
                           value="{{ old('min_order', 0) }}"
                           placeholder="0 = no minimum" min="0"
                           oninput="syncPreview()">
                  </div>
                  <div class="form-hint"><i class="fas fa-info-circle"></i> Set 0 for no minimum requirement</div>
                </div>

              </div>

              <div class="form-grid-2">

                {{-- Max Uses --}}
                <div>
                  <label class="form-label" for="couponMaxUses">
                    <i class="fas fa-users"></i> Max Uses
                  </label>
                  <div class="input-wrap">
                    <span class="input-prefix"><i class="fas fa-redo-alt"></i></span>
                    <input type="number" id="couponMaxUses" name="max_uses"
                           class="form-input {{ $errors->has('max_uses') ? 'is-invalid' : '' }}"
                           value="{{ old('max_uses') }}"
                           placeholder="Unlimited" min="1"
                           oninput="syncPreview()">
                  </div>
                  <div class="form-hint"><i class="fas fa-info-circle"></i> Leave empty for unlimited uses</div>
                </div>

                {{-- Expiry --}}
                <div>
                  <label class="form-label" for="couponExpiry">
                    <i class="fas fa-calendar-alt"></i> Expiry Date
                  </label>
                  <div class="input-wrap">
                    <span class="input-prefix"><i class="fas fa-calendar"></i></span>
                    <input type="date" id="couponExpiry" name="expires_at"
                           class="form-input {{ $errors->has('expires_at') ? 'is-invalid' : '' }}"
                           value="{{ old('expires_at') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           oninput="syncPreview()">
                  </div>
                  <div class="form-hint"><i class="fas fa-info-circle"></i> Leave empty — never expires</div>
                </div>

              </div>
            </div>
          </div>

          {{-- ── Card 3: Additional Info + Actions ── --}}
          <div class="section-card">
            <div class="section-header">
              <div class="section-header-icon" style="background:var(--c-teal-soft);color:var(--c-teal);">
                <i class="fas fa-sticky-note"></i>
              </div>
              <span class="section-title">Additional Info</span>
              <span class="section-step-badge">Step 3 of 3</span>
            </div>
            <div class="section-body">
              <div class="group-label"><i class="fas fa-file-alt"></i> Description &amp; Status</div>

              <div style="margin-bottom:14px;">
                <label class="form-label" for="couponDesc">
                  <i class="fas fa-align-left"></i> Description
                </label>
                <div class="input-wrap">
                  <span class="input-prefix"><i class="fas fa-align-left"></i></span>
                  <input type="text" id="couponDesc" name="description"
                         class="form-input"
                         value="{{ old('description') }}"
                         placeholder="e.g. 20% off on weekends for loyal customers"
                         maxlength="120">
                </div>
                <div class="form-hint"><i class="fas fa-info-circle"></i> Internal note — not shown to customers</div>
              </div>

              <div class="toggle-row">
                <div>
                  <div class="toggle-label">
                    <i class="fas fa-toggle-on" style="color:var(--c-success);"></i>
                    Active on Creation
                  </div>
                  <div class="toggle-desc">Enable immediately so customers can apply it at checkout</div>
                </div>
                <label class="custom-switch">
                  <input type="checkbox" name="is_active" value="1" id="couponActive"
                         {{ old('is_active', true) ? 'checked' : '' }}>
                  <span class="switch-track"></span>
                </label>
              </div>
            </div>

            <div class="form-actions">
              <a href="{{ route('admin.coupons.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Coupons
              </a>
              <button type="submit" class="btn-create" id="submitBtn">
                <span class="btn-spinner"></span>
                <i class="fas fa-ticket-alt"></i>
                <span>Create Coupon</span>
              </button>
            </div>
          </div>

        </div>{{-- /left --}}

        {{-- ════ RIGHT SIDEBAR ════ --}}
        <div class="sidebar">

          {{-- Live Ticket Preview --}}
          <div class="ticket-card">
            <div class="ticket-card-header">
              <div class="ticket-card-header-left">
                <i class="fas fa-eye"></i> Live Preview
              </div>
              <span class="live-dot" title="Updates as you type"></span>
            </div>
            <div class="ticket-body">
              <div class="ticket">
                <div class="ticket-restaurant">
                  <i class="fas fa-store" style="font-size:.7rem;"></i>
                  Restaurant Coupon
                </div>
                <div class="ticket-code-display" id="previewCode">SAVE20</div>
                <div class="ticket-value-display" id="previewValue">—</div>
                <div class="ticket-type-display" id="previewType">Percentage Discount</div>
                <hr class="ticket-divider">
                <div class="ticket-meta-row">
                  <div class="ticket-meta-cell">
                    <span class="ticket-meta-val" id="previewMin">None</span>
                    <span class="ticket-meta-key">Min Order</span>
                  </div>
                  <div class="ticket-meta-cell">
                    <span class="ticket-meta-val" id="previewMax">&#8734;</span>
                    <span class="ticket-meta-key">Max Uses</span>
                  </div>
                  <div class="ticket-meta-cell">
                    <span class="ticket-meta-val" id="previewExp">&#8734;</span>
                    <span class="ticket-meta-key">Expires</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Quick Templates --}}
          <div class="quick-card">
            <div class="quick-header">
              <i class="fas fa-bolt"></i> Quick Fill Templates
            </div>
            <div class="quick-body">
              <div class="quick-grid">
                <button type="button" class="quick-btn"
                        onclick="applyTemplate('WELCOME10','percentage',10,0,'')">
                  <div class="quick-btn-icon" style="background:var(--c-success-soft);color:var(--c-success);border:1px solid rgba(5,150,105,.15);">
                    <i class="fas fa-heart"></i>
                  </div>
                  <span class="quick-btn-label">Welcome 10%</span>
                </button>
                <button type="button" class="quick-btn"
                        onclick="applyTemplate('FLASH50','percentage',50,200,'')">
                  <div class="quick-btn-icon" style="background:var(--c-amber-soft);color:var(--c-amber);border:1px solid rgba(217,119,6,.15);">
                    <i class="fas fa-bolt"></i>
                  </div>
                  <span class="quick-btn-label">Flash 50%</span>
                </button>
                <button type="button" class="quick-btn"
                        onclick="applyTemplate('FLAT100','fixed',100,500,'')">
                  <div class="quick-btn-icon" style="background:var(--c-accent-soft);color:var(--c-accent);border:1px solid rgba(37,99,235,.15);">
                    <i class="fas fa-rupee-sign"></i>
                  </div>
                  <span class="quick-btn-label">Flat Rs.100</span>
                </button>
                <button type="button" class="quick-btn"
                        onclick="applyTemplate('VIP25','percentage',25,300,'')">
                  <div class="quick-btn-icon" style="background:var(--c-purple-soft);color:var(--c-purple);border:1px solid rgba(124,58,237,.15);">
                    <i class="fas fa-crown"></i>
                  </div>
                  <span class="quick-btn-label">VIP 25%</span>
                </button>
              </div>
            </div>
          </div>

          {{-- Tips --}}
          <div class="tips-card">
            <div class="tips-header">
              <i class="fas fa-lightbulb"></i> Coupon Tips
            </div>
            <div class="tips-body">
              <div class="tip-item">
                <div class="tip-icon" style="background:var(--c-amber-soft);color:var(--c-amber);border:1px solid rgba(217,119,6,.15);">
                  <i class="fas fa-code"></i>
                </div>
                <p class="tip-text" style="margin:0;">
                  <strong>Short codes work best</strong> — 6–10 characters are easy to remember and type.
                </p>
              </div>
              <div class="tip-item">
                <div class="tip-icon" style="background:var(--c-success-soft);color:var(--c-success);border:1px solid rgba(5,150,105,.15);">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <p class="tip-text" style="margin:0;">
                  <strong>Set an expiry date</strong> to create urgency and boost conversions.
                </p>
              </div>
              <div class="tip-item">
                <div class="tip-icon" style="background:var(--c-accent-soft);color:var(--c-accent);border:1px solid rgba(37,99,235,.15);">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <p class="tip-text" style="margin:0;">
                  <strong>Minimum order values</strong> encourage customers to add more items to qualify.
                </p>
              </div>
              <div class="tip-item">
                <div class="tip-icon" style="background:var(--c-danger-soft);color:var(--c-danger);border:1px solid rgba(220,38,38,.15);">
                  <i class="fas fa-users"></i>
                </div>
                <p class="tip-text" style="margin:0;">
                  <strong>Limit max uses</strong> to control cost on high-value discount campaigns.
                </p>
              </div>
            </div>
          </div>

        </div>{{-- /sidebar --}}

      </div>{{-- /coupon-layout --}}
    </form>

  </div>{{-- /coupon-body --}}
</div>{{-- /coupon-wrapper --}}
@endsection

@push('scripts')
<script>
  /* ── Live Preview Sync ── */
  function syncPreview() {
    const code   = document.getElementById('couponCode').value.toUpperCase().trim() || '—';
    const value  = parseFloat(document.getElementById('couponValue').value) || 0;
    const minOrd = parseFloat(document.getElementById('couponMinOrder').value) || 0;
    const maxUses= document.getElementById('couponMaxUses').value.trim();
    const expiry = document.getElementById('couponExpiry').value;
    const isPct  = document.getElementById('typePct').checked;

    document.getElementById('previewCode').textContent  = code;
    document.getElementById('previewValue').textContent = value > 0
        ? (isPct ? value + '% OFF' : 'Rs.' + Math.round(value) + ' OFF') : '—';
    document.getElementById('previewType').textContent  = isPct
        ? 'Percentage Discount' : 'Fixed Amount Discount';
    document.getElementById('previewMin').textContent   = minOrd > 0
        ? 'Rs.' + minOrd.toLocaleString() : 'None';
    document.getElementById('previewMax').textContent   = maxUses || '\u221E';
    if (expiry) {
      const d = new Date(expiry);
      document.getElementById('previewExp').textContent =
        d.toLocaleDateString('en-GB', { day:'2-digit', month:'short' });
    } else {
      document.getElementById('previewExp').textContent = '\u221E';
    }
    updateValueField(isPct);
  }

  function updateValueField(isPct) {
    const prefix = document.getElementById('valuePrefix');
    const suffix = document.getElementById('valueSuffix');
    const label  = document.getElementById('valueLbl');
    const input  = document.getElementById('couponValue');
    const chips  = document.querySelectorAll('#presetsWrap .preset-chip');
    if (isPct) {
      prefix.innerHTML  = '<i class="fas fa-percentage"></i>';
      suffix.textContent= '%'; label.textContent = 'Discount Value (%)';
      input.max = 100; input.placeholder = 'e.g. 20';
      const pct = [5,10,15,20,25,50];
      chips.forEach((c,i) => { c.textContent = pct[i]+'%'; c.onclick = () => applyPreset(pct[i]); });
    } else {
      prefix.innerHTML  = '<span style="font-size:.76rem;font-weight:700;">Rs.</span>';
      suffix.textContent= 'Rs.'; label.textContent = 'Discount Value (Rs.)';
      input.removeAttribute('max'); input.placeholder = 'e.g. 100';
      const rs = [50,100,150,200,250,500];
      chips.forEach((c,i) => { c.textContent = 'Rs.'+rs[i]; c.onclick = () => applyPreset(rs[i]); });
    }
  }

  function applyPreset(val) {
    const inp = document.getElementById('couponValue');
    inp.value = val; syncPreview();
    inp.style.borderColor = '#f59e0b';
    inp.style.boxShadow   = '0 0 0 3px rgba(245,158,11,.2)';
    setTimeout(() => { inp.style.borderColor = ''; inp.style.boxShadow = ''; }, 700);
  }

  function applyTemplate(code, type, value, minOrder, expires) {
    document.getElementById('couponCode').value    = code;
    document.getElementById('couponValue').value   = value;
    document.getElementById('couponMinOrder').value= minOrder;
    document.getElementById('couponExpiry').value  = expires;
    document.getElementById('typePct').checked     = (type === 'percentage');
    document.getElementById('typeFixed').checked   = (type === 'fixed');
    syncPreview();
    document.getElementById('couponCode').scrollIntoView({ behavior:'smooth', block:'center' });
  }

  function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    if (window.crypto && window.crypto.getRandomValues) {
      const arr = new Uint32Array(8);
      window.crypto.getRandomValues(arr);
      arr.forEach(n => { code += chars[n % chars.length]; });
    } else {
      for (let i = 0; i < 8; i++) code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('couponCode').value = code; syncPreview();
    const btn = document.getElementById('generateBtn');
    btn.classList.add('spinning');
    setTimeout(() => btn.classList.remove('spinning'), 500);
  }

  /* Auto uppercase + strip non-alphanumeric */
  document.getElementById('couponCode').addEventListener('input', function () {
    const pos = this.selectionStart;
    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    this.setSelectionRange(pos, pos);
  });

  /* Submit loading state */
  document.getElementById('couponForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.classList.add('is-loading');
    btn.disabled = true;
  });

  document.addEventListener('DOMContentLoaded', syncPreview);
</script>
@endpush