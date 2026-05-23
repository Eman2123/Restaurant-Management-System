@extends('layouts.admin')
@section('title', 'Coupons')
@section('page-title', 'Coupon Management')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    /* ========== LIGHT THEME ========== */
    .coupons-wrapper {
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
        --c-accent:          #2563eb;
        --c-accent-soft:     rgba(37,99,235,0.12);
        --code-bg:           #1e2a35;
        --header-grad:       linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --divider:           rgba(0,0,0,0.07);
    }

    /* ========== DARK THEME ========== */
    body.dark-mode .coupons-wrapper,
    body.sidebar-dark-primary .coupons-wrapper,
    [data-theme="dark"] .coupons-wrapper,
    [data-bs-theme="dark"] .coupons-wrapper {
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
        --c-accent:          #4d84ff;
        --c-accent-soft:     rgba(77,132,255,0.14);
        --code-bg:           #0d1117;
    }

    /* ========== BASE ========== */
    .coupons-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
    .coupons-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from{opacity:0}to{opacity:1} }

    /* ========== PAGE HEADER ========== */
    .cpn-header {
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
    .cpn-header::before {
        content:''; position:absolute; top:-120px; right:-80px;
        width:360px; height:360px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 18s ease-in-out infinite;
    }
    .cpn-header::after {
        content:''; position:absolute; bottom:-120px; left:-60px;
        width:300px; height:300px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.10) 0%, transparent 70%);
        animation: float2 14s ease-in-out infinite;
    }
    @keyframes float1 { 0%,100%{transform:translate(0,0);}50%{transform:translate(20px,20px);} }
    @keyframes float2 { 0%,100%{transform:translate(0,0);}50%{transform:translate(-20px,-20px);} }

    .cpn-header-inner {
        position: relative; z-index: 2;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .cpn-header-left { display:flex; align-items:center; gap:1.2rem; }
    .cpn-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.25);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .cpn-header h1 {
        color: white; font-size: 1.9rem; font-weight: 800;
        margin: 0; letter-spacing: -0.5px;
    }
    .cpn-header p {
        color: rgba(255,255,255,0.88); font-size: 0.92rem;
        margin: 3px 0 0; font-weight: 500;
    }

    .create-btn {
        background: white; color: #d97706;
        padding: 11px 24px; border-radius: 12px;
        font-weight: 700; font-size: 0.88rem;
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        transition: all 0.25s; text-transform: uppercase; letter-spacing: 0.5px;
        text-decoration: none;
    }
    .create-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.25);
        color: #b45309;
    }
    body.dark-mode .create-btn,
    [data-bs-theme="dark"] .create-btn { background: rgba(255,255,255,0.18); color: white; }

    /* ========== STATS ========== */
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
        cursor: default;
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
    .stat-card.warning::before { background: var(--c-warning); }
    .stat-card.success::before { background: var(--c-success); }
    .stat-card.info::before    { background: var(--c-info); }
    .stat-card.danger::before  { background: var(--c-danger); }
    .stat-card:hover { transform: translateY(-5px); box-shadow: var(--card-hover-shadow); }

    .stat-head {
        display: flex; align-items: center;
        justify-content: space-between; margin-bottom: 1rem;
    }
    .stat-label {
        font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.08em;
        color: var(--text-muted);
    }
    .stat-icon-pill {
        width: 32px; height: 32px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem;
    }
    .stat-card.warning .stat-icon-pill { background: var(--c-warning-soft); color: var(--c-warning); }
    .stat-card.success .stat-icon-pill { background: var(--c-success-soft); color: var(--c-success); }
    .stat-card.info    .stat-icon-pill { background: var(--c-info-soft);    color: var(--c-info); }
    .stat-card.danger  .stat-icon-pill { background: var(--c-danger-soft);  color: var(--c-danger); }

    .stat-value {
        font-size: 2.6rem; font-weight: 800;
        line-height: 1; margin-bottom: 0.35rem;
        font-family: var(--font-mono);
    }
    .stat-card.warning .stat-value { color: var(--c-warning); }
    .stat-card.success .stat-value { color: var(--c-success); }
    .stat-card.info    .stat-value { color: var(--c-info); }
    .stat-card.danger  .stat-value { color: var(--c-danger); }

    .stat-sub {
        font-size: 0.78rem; font-weight: 600;
        display: flex; align-items: center; gap: 5px;
    }
    .stat-card.warning .stat-sub { color: var(--c-warning); }
    .stat-card.success .stat-sub { color: var(--c-success); }
    .stat-card.info    .stat-sub { color: var(--c-info); }
    .stat-card.danger  .stat-sub { color: var(--c-danger); }

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
    .modern-table tbody td {
        padding: 1rem 1.2rem;
        color: var(--text-primary); vertical-align: middle;
        font-size: 0.9rem;
    }

    /* ========== CODE BADGE ========== */
    .code-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 10px;
        background: var(--code-bg);
        border: 1px solid rgba(255,255,255,0.08);
        font-family: var(--font-mono);
        font-size: 0.82rem; font-weight: 700;
        color: var(--c-warning); letter-spacing: 0.08em;
        cursor: pointer; transition: all 0.2s;
        position: relative;
    }
    .code-badge:hover { border-color: rgba(245,158,11,0.4); box-shadow: 0 0 0 2px rgba(245,158,11,0.12); }
    .code-badge i { font-size: 0.75rem; opacity: 0.6; }
    .copy-toast {
        position: absolute; top: -28px; left: 50%;
        transform: translateX(-50%);
        background: var(--c-success); color: #fff;
        font-size: 0.68rem; padding: 3px 8px;
        border-radius: 6px; white-space: nowrap;
        opacity: 0; pointer-events: none; transition: opacity 0.2s;
        font-family: var(--font-main);
    }
    .code-badge.copied .copy-toast { opacity: 1; }

    /* ========== INFO BADGES ========== */
    .info-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 11px; border-radius: 10px;
        font-weight: 600; font-size: 0.8rem;
        border: 1px solid; white-space: nowrap;
    }
    .badge-pct    { background:var(--c-purple-soft); color:var(--c-purple); border-color:var(--c-purple-soft); }
    .badge-fixed  { background:var(--c-accent-soft); color:var(--c-accent); border-color:var(--c-accent-soft); }
    .badge-value  { background:var(--c-warning-soft);color:var(--c-warning);border-color:var(--c-warning-soft); font-family:var(--font-mono); font-weight:700; }
    .badge-min    { font-size:0.8rem; color:var(--text-muted); font-family:var(--font-mono); }

    /* ========== USAGE BAR ========== */
    .usage-wrap { min-width: 100px; }
    .usage-text {
        display: flex; justify-content: space-between;
        font-size: 0.77rem; color: var(--text-muted);
        margin-bottom: 5px;
    }
    .usage-used { font-weight: 700; color: var(--text-primary); }
    .usage-track {
        width: 100%; height: 4px; border-radius: 99px;
        background: var(--border-color); overflow: hidden;
    }
    .usage-fill {
        height: 100%; border-radius: 99px;
        background: linear-gradient(90deg, var(--c-warning), #fbbf24);
        transition: width 0.6s cubic-bezier(0.4,0,0.2,1);
    }
    .usage-fill.full { background: linear-gradient(90deg, var(--c-danger), #f87171); }

    /* ========== EXPIRY ========== */
    .expiry-wrap { display: flex; flex-direction: column; gap: 2px; }
    .expiry-date {
        display: flex; align-items: center; gap: 4px;
        font-size: 0.82rem; font-weight: 600;
        color: var(--text-primary);
    }
    .expiry-date.is-expired { color: var(--c-danger); }
    .expiry-date.is-soon    { color: var(--c-warning); }
    .expiry-sub { font-size: 0.72rem; color: var(--text-muted); }
    .expiry-sub.is-expired  { color: var(--c-danger); }
    .expiry-never {
        display: flex; align-items: center; gap: 5px;
        font-size: 0.82rem; color: var(--text-muted);
    }

    /* ========== STATUS BADGE ========== */
    .status-badge {
        padding: 5px 14px; border-radius: 20px;
        font-weight: 700; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.06em;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .status-dot { width:6px; height:6px; border-radius:50%; }
    .status-badge.active   { background:var(--c-success-soft); color:var(--c-success); }
    .status-badge.active   .status-dot { background:var(--c-success); animation: dotPulse 1.4s infinite; }
    .status-badge.inactive { background:var(--c-danger-soft);  color:var(--c-danger); }
    .status-badge.inactive .status-dot { background:var(--c-danger); }
    .status-badge.expired  { background:rgba(107,114,128,0.12); color:#6b7280; }
    .status-badge.expired  .status-dot { background:#6b7280; }
    @keyframes dotPulse { 0%,100%{transform:scale(1);opacity:1;}50%{transform:scale(1.6);opacity:0.5;} }

    /* ========== ACTION BUTTONS ========== */
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
    .action-btn.toggle-on:hover  { background:var(--c-warning-soft); color:var(--c-warning); border-color:var(--c-warning); }
    .action-btn.toggle-off:hover { background:var(--c-success-soft); color:var(--c-success); border-color:var(--c-success); }
    .action-btn.edit:hover       { background:var(--c-info-soft);    color:var(--c-info);    border-color:var(--c-info); }
    .action-btn.delete:hover     { background:var(--c-danger-soft);  color:var(--c-danger);  border-color:var(--c-danger); }

    /* ========== FLASH ========== */
    .flash-msg {
        display: flex; align-items: center; gap: 10px;
        padding: 13px 18px; border-radius: 14px;
        margin: 0 1.5rem 1rem; font-size: 0.88rem; font-weight: 600;
        animation: slideDown 0.35s ease;
    }
    .flash-msg.success { background:var(--c-success-soft); border:1px solid var(--c-success); color:var(--c-success); }
    .flash-msg.error   { background:var(--c-danger-soft);  border:1px solid var(--c-danger);  color:var(--c-danger); }
    .flash-close { margin-left:auto; background:none; border:none; color:inherit; opacity:0.6; cursor:pointer; font-size:1rem; display:flex; align-items:center; }
    .flash-close:hover { opacity:1; }

    /* ========== EMPTY STATE ========== */
    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-icon  {
        width: 80px; height: 80px; border-radius: 50%;
        background: var(--c-warning-soft);
        border: 2px dashed var(--c-warning);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem; font-size: 2rem; color: var(--c-warning);
    }
    .empty-state h3 { color: var(--text-primary); font-size: 1.05rem; font-weight: 700; margin-bottom: 5px; }
    .empty-state p  { color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1.2rem; }

    /* ========== DELETE MODAL ========== */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(3px);
        z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        padding: 1rem; opacity: 0; pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .modal-overlay.is-open { opacity: 1; pointer-events: all; }

    .modal-box {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        width: 100%; max-width: 420px;
        transform: scale(0.93) translateY(12px);
        transition: transform 0.25s cubic-bezier(0.4,0,0.2,1);
    }
    .modal-overlay.is-open .modal-box { transform: scale(1) translateY(0); }

    .modal-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid var(--border-color);
    }
    .modal-head-left { display: flex; align-items: center; gap: 10px; }
    .modal-head-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: var(--c-danger-soft); border: 1px solid var(--c-danger);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-danger); font-size: 1rem;
    }
    .modal-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin: 0; }
    .modal-close-btn {
        width: 30px; height: 30px; border-radius: 8px;
        border: none; background: transparent; color: var(--text-muted);
        font-size: 1.1rem; display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s;
    }
    .modal-close-btn:hover { background: var(--c-danger-soft); color: var(--c-danger); }

    .modal-body { padding: 1.4rem; }
    .modal-warn-box {
        display: flex; gap: 10px; align-items: flex-start;
        padding: 12px 14px;
        background: var(--c-danger-soft);
        border: 1px solid var(--c-danger);
        border-radius: 12px; margin-bottom: 1rem;
    }
    .modal-warn-box i { color: var(--c-danger); font-size: 1rem; flex-shrink:0; margin-top:1px; }
    .modal-warn-text { font-size: 0.83rem; color: var(--text-secondary); line-height: 1.5; }
    .modal-warn-text strong { color: var(--text-primary); }

    .modal-code-preview {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px; background: var(--code-bg);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px; margin-bottom: 1.25rem;
        font-family: var(--font-mono);
        font-size: 1.05rem; font-weight: 800;
        color: var(--c-warning); letter-spacing: 0.12em;
    }

    .modal-footer { display: flex; gap: 10px; justify-content: flex-end; }
    .modal-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 18px; border-radius: 10px;
        font-size: 0.84rem; font-weight: 700;
        border: 1px solid transparent; cursor: pointer;
        transition: all 0.2s; font-family: var(--font-main);
    }
    .modal-btn.cancel {
        background: transparent; color: var(--text-secondary);
        border-color: var(--border-color);
    }
    .modal-btn.cancel:hover { background: var(--section-bg); color: var(--text-primary); }
    .modal-btn.confirm-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff; box-shadow: 0 4px 14px rgba(220,38,38,0.35);
    }
    .modal-btn.confirm-delete:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(220,38,38,0.45); }

    /* ========== RESPONSIVE ========== */
    @media(max-width:768px){
        .cpn-header { padding:1.5rem; }
        .cpn-header h1 { font-size:1.5rem; }
        .stats-section { padding: 0 1rem 1rem; }
        .modern-table thead th,
        .modern-table tbody td { padding: 0.75rem 0.8rem; }
    }
</style>
@endpush

@section('content')
<div class="coupons-wrapper">

    {{-- ── Page Header ── --}}
    <div class="cpn-header">
        <div class="cpn-header-inner">
            <div class="cpn-header-left">
                <div class="cpn-header-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div>
                    <h1>Discount Coupons</h1>
                    <p>Manage promotional codes &amp; discount offers</p>
                </div>
            </div>
            <a href="{{ route('admin.coupons.create') }}" class="create-btn">
                <i class="fas fa-plus"></i>
                <span>New Coupon</span>
            </a>
        </div>
    </div>

    <div class="stats-section">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
        <div class="flash-msg success" id="cpnFlash">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button class="flash-close" onclick="this.closest('.flash-msg').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
        @if(session('error'))
        <div class="flash-msg error" id="cpnFlash">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button class="flash-close" onclick="this.closest('.flash-msg').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        {{-- ── Stats Grid ── --}}
        <div class="stats-grid">

            <div class="stat-card warning">
                <div class="stat-head">
                    <span class="stat-label">Total Coupons</span>
                    <span class="stat-icon-pill"><i class="fas fa-ticket-alt"></i></span>
                </div>
                <div class="stat-value">{{ $coupons->count() }}</div>
                <div class="stat-sub"><i class="fas fa-layer-group"></i> All codes</div>
            </div>

            <div class="stat-card success">
                <div class="stat-head">
                    <span class="stat-label">Active</span>
                    <span class="stat-icon-pill"><i class="fas fa-check-circle"></i></span>
                </div>
                <div class="stat-value">{{ $coupons->where('is_active', true)->count() }}</div>
                <div class="stat-sub"><i class="fas fa-bolt"></i> Live now</div>
            </div>

            <div class="stat-card info">
                <div class="stat-head">
                    <span class="stat-label">Total Used</span>
                    <span class="stat-icon-pill"><i class="fas fa-redo"></i></span>
                </div>
                <div class="stat-value">{{ $coupons->sum('used_count') }}</div>
                <div class="stat-sub"><i class="fas fa-chart-line"></i> Redemptions</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-head">
                    <span class="stat-label">Inactive</span>
                    <span class="stat-icon-pill"><i class="fas fa-ban"></i></span>
                </div>
                <div class="stat-value">{{ $coupons->where('is_active', false)->count() }}</div>
                <div class="stat-sub"><i class="fas fa-times"></i> Disabled</div>
            </div>

        </div>

        {{-- ── Table ── --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Min Order</th>
                            <th>Usage</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)

                        @php
                            $usagePct  = ($coupon->max_uses && $coupon->max_uses > 0)
                                       ? min(100, round(($coupon->used_count / $coupon->max_uses) * 100))
                                       : 0;
                            $isFull    = $coupon->max_uses && $coupon->used_count >= $coupon->max_uses;
                            $isExpired = $coupon->expires_at && $coupon->expires_at->isPast();
                            $isSoon    = !$isExpired && $coupon->expires_at
                                       && $coupon->expires_at->diffInDays(now()) <= 3;
                            $isActive  = $coupon->is_active && $coupon->isValid();
                        @endphp

                        <tr>
                            {{-- Code --}}
                            <td>
                                <span class="code-badge"
                                      onclick="cpnCopyCode(this, '{{ $coupon->code }}')"
                                      title="Click to copy">
                                    <i class="fas fa-copy"></i>
                                    {{ $coupon->code }}
                                    <span class="copy-toast">Copied!</span>
                                </span>
                            </td>

                            {{-- Type --}}
                            <td>
                                @if($coupon->type === 'percentage')
                                    <span class="info-badge badge-pct">
                                        <i class="fas fa-percentage"></i> Percentage
                                    </span>
                                @else
                                    <span class="info-badge badge-fixed">
                                        <i class="fas fa-rupee-sign"></i> Fixed
                                    </span>
                                @endif
                            </td>

                            {{-- Discount --}}
                            <td>
                                <span class="info-badge badge-value">
                                    @if($coupon->type === 'percentage')
                                        {{ $coupon->value }}% OFF
                                    @else
                                        Rs.{{ number_format($coupon->value, 0) }} OFF
                                    @endif
                                </span>
                            </td>

                            {{-- Min Order --}}
                            <td>
                                <span class="badge-min">
                                    Rs.{{ number_format($coupon->min_order, 0) }}
                                </span>
                            </td>

                            {{-- Usage --}}
                            <td>
                                <div class="usage-wrap">
                                    <div class="usage-text">
                                        <span class="usage-used">{{ $coupon->used_count }}</span>
                                        <span>/ {{ $coupon->max_uses ?? '∞' }}</span>
                                    </div>
                                    @if($coupon->max_uses)
                                    <div class="usage-track">
                                        <div class="usage-fill {{ $isFull ? 'full' : '' }}"
                                             style="width:{{ $usagePct }}%"></div>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Expires --}}
                            <td>
                                @if($coupon->expires_at)
                                    <div class="expiry-wrap">
                                        <span class="expiry-date {{ $isExpired ? 'is-expired' : ($isSoon ? 'is-soon' : '') }}">
                                            <i class="fas fa-calendar fa-xs"></i>
                                            {{ $coupon->expires_at->format('d M Y') }}
                                        </span>
                                        <span class="expiry-sub {{ $isExpired ? 'is-expired' : '' }}">
                                            {{ $coupon->expires_at->diffForHumans() }}
                                        </span>
                                    </div>
                                @else
                                    <span class="expiry-never">
                                        <i class="fas fa-infinity"></i> Never
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($isExpired)
                                    <span class="status-badge expired">
                                        <span class="status-dot"></span> Expired
                                    </span>
                                @elseif($isActive)
                                    <span class="status-badge active">
                                        <span class="status-dot"></span> Active
                                    </span>
                                @else
                                    <span class="status-badge inactive">
                                        <span class="status-dot"></span> Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="action-buttons">

                                    {{-- Toggle --}}
                                    <form method="POST"
                                          action="{{ route('admin.coupons.toggle', $coupon) }}"
                                          style="display:contents;">
                                        @csrf @method('PATCH')
                                        @if($coupon->is_active)
                                            <button type="submit"
                                                    class="action-btn toggle-on"
                                                    title="Disable">
                                                <i class="fas fa-toggle-on"></i>
                                            </button>
                                        @else
                                            <button type="submit"
                                                    class="action-btn toggle-off"
                                                    title="Enable">
                                                <i class="fas fa-toggle-off"></i>
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                       class="action-btn edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <button type="button"
                                            class="action-btn delete" title="Delete"
                                            onclick="cpnOpenDeleteModal(
                                                '{{ $coupon->code }}',
                                                '{{ route('admin.coupons.destroy', $coupon) }}'
                                            )">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <h3>No coupons found</h3>
                                    <p>Create your first promotional coupon to start offering discounts</p>
                                    <a href="{{ route('admin.coupons.create') }}" class="create-btn">
                                        <i class="fas fa-plus"></i> Create First Coupon
                                    </a>
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

{{-- ── Delete Modal ── --}}
<div class="modal-overlay" id="cpnDeleteModal" role="dialog" aria-modal="true">
    <div class="modal-box">

        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-head-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h3 class="modal-title">Delete Coupon</h3>
            </div>
            <button class="modal-close-btn" onclick="cpnCloseDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <div class="modal-warn-box">
                <i class="fas fa-exclamation-triangle"></i>
                <p class="modal-warn-text mb-0">
                    You are about to permanently delete coupon
                    <strong id="cpnModalCodeText">—</strong>.
                    This action <strong>cannot be undone</strong>
                    and all usage data will be lost.
                </p>
            </div>

            <div class="modal-code-preview">
                <i class="fas fa-ticket-alt" style="opacity:0.6;"></i>
                <span id="cpnModalCodeBadge">—</span>
            </div>

            <div class="modal-footer">
                <button type="button" class="modal-btn cancel" onclick="cpnCloseDeleteModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form id="cpnDeleteForm" method="POST" style="display:contents;">
                    @csrf @method('DELETE')
                    <button type="submit" class="modal-btn confirm-delete">
                        <i class="fas fa-trash-alt"></i> Delete Coupon
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function cpnOpenDeleteModal(code, actionUrl) {
    document.getElementById('cpnModalCodeText').textContent  = code;
    document.getElementById('cpnModalCodeBadge').textContent = code;
    document.getElementById('cpnDeleteForm').action          = actionUrl;
    const overlay = document.getElementById('cpnDeleteModal');
    overlay.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    overlay.addEventListener('click', function h(e) {
        if (e.target === overlay) { cpnCloseDeleteModal(); overlay.removeEventListener('click', h); }
    });
    document.addEventListener('keydown', function h(e) {
        if (e.key === 'Escape') { cpnCloseDeleteModal(); document.removeEventListener('keydown', h); }
    });
}

function cpnCloseDeleteModal() {
    document.getElementById('cpnDeleteModal').classList.remove('is-open');
    document.body.style.overflow = '';
}

function cpnCopyCode(el, code) {
    navigator.clipboard.writeText(code).then(() => {
        el.classList.add('copied');
        setTimeout(() => el.classList.remove('copied'), 1800);
    }).catch(() => {
        const ta = document.createElement('textarea');
        ta.value = code; ta.style.position = 'fixed'; ta.style.opacity = '0';
        document.body.appendChild(ta); ta.select();
        document.execCommand('copy'); document.body.removeChild(ta);
        el.classList.add('copied');
        setTimeout(() => el.classList.remove('copied'), 1800);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('cpnFlash');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.4s ease';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 400);
        }, 4500);
    }
});
</script>
@endpush