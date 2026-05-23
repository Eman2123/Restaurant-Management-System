@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'All Orders')

@section('content')

<style>
    /* ============================================
       THEME VARIABLES
    ============================================ */
    :root {
        --or-card-bg:      #ffffff;
        --or-card-border:  #e8ecf0;
        --or-card-shadow:  0 2px 16px rgba(0,0,0,0.07);
        --or-text-heading: #1e293b;
        --or-text-body:    #4a5568;
        --or-text-muted:   #94a3b8;
        --or-table-head:   #f7f9fc;
        --or-table-border: #f1f5f9;
        --or-table-hover:  #f8faff;
        --or-input-bg:     #f8fafc;
        --or-input-border: #e2e8f0;
        --or-badge-bg:     #f1f5f9;
        --or-divider:      #f1f5f9;
    }

    [data-theme="dark"],
    body.dark,
    body.dark-mode,
    html[data-bs-theme="dark"] {
        --or-card-bg:      #1c2333;
        --or-card-border:  #2a3447;
        --or-card-shadow:  0 2px 20px rgba(0,0,0,0.35);
        --or-text-heading: #e2e8f0;
        --or-text-body:    #94a3b8;
        --or-text-muted:   #4a5568;
        --or-table-head:   #141A21;
        --or-table-border: #1e2a3a;
        --or-table-hover:  #1e2d40;
        --or-input-bg:     #141A21;
        --or-input-border: #2a3447;
        --or-badge-bg:     #1e2a3a;
        --or-divider:      #1e2a3a;
    }

    /* ============================================
       PAGE HEADER
    ============================================ */
    .or-page-header {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        margin-bottom:   22px;
        flex-wrap:       wrap;
        gap:             12px;
    }

    .or-page-title {
        font-size:   1.05rem;
        font-weight: 700;
        color:       var(--or-text-heading);
        display:     flex;
        align-items: center;
        gap:         9px;
        margin:      0;
    }

    .or-title-icon {
        width:           36px;
        height:          36px;
        background:      linear-gradient(135deg,#1d4ed8,#3b82f6);
        border-radius:   10px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        color:           #fff;
        font-size:       0.88rem;
        flex-shrink:     0;
        box-shadow:      0 3px 10px rgba(59,130,246,0.28);
    }

    .or-breadcrumb {
        display:     flex;
        align-items: center;
        gap:         5px;
        font-size:   0.75rem;
        color:       var(--or-text-muted);
        margin-top:  3px;
    }

    .or-breadcrumb a {
        color:           var(--or-text-muted);
        text-decoration: none;
        transition:      color 0.2s;
    }

    .or-breadcrumb a:hover { color: #3b82f6; }
    .or-breadcrumb .sep    { font-size: 0.52rem; opacity: 0.4; }
    .or-breadcrumb .cur    { color: var(--or-text-heading); font-weight: 600; }

    /* New Order button */
    .or-new-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             7px;
        padding:         10px 20px;
        background:      linear-gradient(135deg,#065f46,#10b981);
        color:           #fff !important;
        border:          none;
        border-radius:   10px;
        font-size:       0.855rem;
        font-weight:     600;
        text-decoration: none !important;
        transition:      all 0.25s ease;
        box-shadow:      0 3px 12px rgba(16,185,129,0.28);
        white-space:     nowrap;
        cursor:          pointer;
    }

    .or-new-btn i    { font-size: 0.78rem; }
    .or-new-btn:hover {
        transform:  translateY(-2px);
        box-shadow: 0 7px 20px rgba(16,185,129,0.42);
        color:      #fff !important;
    }

    /* ============================================
       STAT CARDS
    ============================================ */
    .or-stats {
        display:       flex;
        gap:           14px;
        flex-wrap:     wrap;
        margin-bottom: 20px;
    }

    .or-stat {
        flex:          1;
        min-width:     110px;
        background:    var(--or-card-bg);
        border:        1px solid var(--or-card-border);
        border-radius: 12px;
        padding:       16px 14px 14px;
        display:       flex;
        align-items:   center;
        gap:           12px;
        box-shadow:    var(--or-card-shadow);
        transition:    transform 0.25s ease, box-shadow 0.25s ease;
        animation:     or-up 0.42s ease both;
        position:      relative;
        overflow:      hidden;
        cursor:        default;
    }

    .or-stat::after {
        content:       '';
        position:      absolute;
        top: 0; left: 0; right: 0;
        height:        3px;
        background:    var(--or-stat-color, #3b82f6);
        border-radius: 12px 12px 0 0;
    }

    .or-stat:hover {
        transform:  translateY(-4px);
        box-shadow: 0 8px 26px rgba(0,0,0,0.11);
    }

    /* color per stat */
    .or-stat-total    { --or-stat-color: #3b82f6; animation-delay:.05s; }
    .or-stat-pending  { --or-stat-color: #f59e0b; animation-delay:.08s; }
    .or-stat-cooking  { --or-stat-color: #f97316; animation-delay:.11s; }
    .or-stat-ready    { --or-stat-color: #10b981; animation-delay:.14s; }
    .or-stat-served   { --or-stat-color: #06b6d4; animation-delay:.17s; }
    .or-stat-unpaid   { --or-stat-color: #ef4444; animation-delay:.20s; }

    @keyframes or-up {
        from { opacity:0; transform:translateY(14px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .or-stat-icon {
        width:           40px;
        height:          40px;
        border-radius:   10px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        font-size:       1rem;
        flex-shrink:     0;
        transition:      transform 0.25s;
    }

    .or-stat:hover .or-stat-icon { transform: scale(1.12) rotate(5deg); }

    .or-stat-val {
        font-size:   1.55rem;
        font-weight: 800;
        color:       var(--or-text-heading);
        line-height: 1;
    }

    .or-stat-lbl {
        font-size:      0.67rem;
        color:          var(--or-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight:    600;
        margin-top:     3px;
    }

    /* ============================================
       CARDS (filter, table)
    ============================================ */
    .or-card {
        background:    var(--or-card-bg);
        border:        1px solid var(--or-card-border);
        border-radius: 14px;
        box-shadow:    var(--or-card-shadow);
        overflow:      hidden;
        margin-bottom: 20px;
        animation:     or-up 0.45s ease both;
    }

    .or-card-hd {
        padding:       14px 20px;
        border-bottom: 1px solid var(--or-card-border);
        background:    var(--or-table-head);
        display:       flex;
        align-items:   center;
        gap:           8px;
    }

    .or-card-hd h6 {
        margin:      0;
        font-size:   0.88rem;
        font-weight: 700;
        color:       var(--or-text-heading);
        display:     flex;
        align-items: center;
        gap:         7px;
    }

    .or-card-hd-icon {
        width:           28px;
        height:          28px;
        border-radius:   7px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        font-size:       0.72rem;
        flex-shrink:     0;
    }

    .or-card-body { padding: 18px 20px; }

    /* ============================================
       FILTER FORM
    ============================================ */
    .or-filter-grid {
        display:   grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        gap:       14px;
        align-items: end;
    }

    .or-form-label {
        display:        block;
        font-size:      0.70rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color:          var(--or-text-muted);
        margin-bottom:  6px;
    }

    .or-input,
    .or-select {
        width:         100%;
        background:    var(--or-input-bg);
        border:        1.5px solid var(--or-input-border);
        border-radius: 9px;
        padding:       9px 12px;
        font-size:     0.845rem;
        color:         var(--or-text-heading);
        outline:       none;
        transition:    border-color 0.2s, box-shadow 0.2s;
    }

    .or-select {
        appearance:          none;
        background-image:    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat:   no-repeat;
        background-position: right 11px center;
        padding-right:       34px;
        cursor:              pointer;
    }

    .or-input:focus,
    .or-select:focus {
        border-color: #3b82f6;
        box-shadow:   0 0 0 3px rgba(59,130,246,0.10);
    }

    /* filter buttons */
    .or-filter-btns {
        display: flex;
        gap:     8px;
    }

    .or-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             6px;
        padding:         9px 16px;
        border-radius:   9px;
        font-size:       0.845rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        text-decoration: none;
        transition:      all 0.22s ease;
        white-space:     nowrap;
    }

    .or-btn i    { font-size: 0.76rem; }
    .or-btn:hover { transform: translateY(-1px); text-decoration: none; }

    .or-btn-filter {
        background:  linear-gradient(135deg,#1d4ed8,#3b82f6);
        color:       #fff;
        box-shadow:  0 3px 10px rgba(59,130,246,0.28);
    }

    .or-btn-filter:hover {
        box-shadow: 0 6px 18px rgba(59,130,246,0.40);
        color:      #fff;
    }

    .or-btn-clear {
        background:   var(--or-input-bg);
        color:        var(--or-text-body);
        border-color: var(--or-input-border);
    }

    .or-btn-clear:hover {
        border-color: #64748b;
        color:        var(--or-text-heading);
    }

    /* ============================================
       TOOLBAR (status filters + export)
    ============================================ */
    .or-toolbar {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        flex-wrap:       wrap;
        gap:             12px;
        margin-bottom:   16px;
    }

    .or-status-filters {
        display:   flex;
        flex-wrap: wrap;
        gap:       7px;
    }

    /* status filter pill */
    .or-filter-pill {
        display:         inline-flex;
        align-items:     center;
        gap:             5px;
        padding:         6px 14px;
        border-radius:   20px;
        font-size:       0.78rem;
        font-weight:     600;
        text-decoration: none;
        border:          1.5px solid transparent;
        transition:      all 0.22s ease;
        white-space:     nowrap;
    }

    .or-filter-pill:hover { transform: translateY(-1px); text-decoration: none; }

    /* default inactive */
    .or-pill-default {
        background:   var(--or-input-bg);
        color:        var(--or-text-body);
        border-color: var(--or-input-border);
    }

    .or-pill-default:hover {
        border-color: #64748b;
        color:        var(--or-text-heading);
    }

    /* active states */
    .or-pill-all-active     { background:#3b82f6; color:#fff; border-color:#3b82f6; box-shadow:0 3px 10px rgba(59,130,246,0.28); }
    .or-pill-pending-active { background:#f59e0b; color:#fff; border-color:#f59e0b; box-shadow:0 3px 10px rgba(245,158,11,0.28); }
    .or-pill-cooking-active { background:#f97316; color:#fff; border-color:#f97316; box-shadow:0 3px 10px rgba(249,115,22,0.28); }
    .or-pill-ready-active   { background:#10b981; color:#fff; border-color:#10b981; box-shadow:0 3px 10px rgba(16,185,129,0.28); }
    .or-pill-served-active  { background:#06b6d4; color:#fff; border-color:#06b6d4; box-shadow:0 3px 10px rgba(6,182,212,0.28); }
    .or-pill-cancelled-active { background:#64748b; color:#fff; border-color:#64748b; }
    .or-pill-unpaid-active  { background:#ef4444; color:#fff; border-color:#ef4444; box-shadow:0 3px 10px rgba(239,68,68,0.28); }

    /* export dropdown */
    .or-export-wrap { position: relative; }

    .or-export-btn {
        display:      inline-flex;
        align-items:  center;
        gap:          7px;
        padding:      9px 16px;
        background:   linear-gradient(135deg,#065f46,#10b981);
        color:        #fff;
        border:       none;
        border-radius: 10px;
        font-size:    0.845rem;
        font-weight:  600;
        cursor:       pointer;
        transition:   all 0.22s ease;
        box-shadow:   0 3px 10px rgba(16,185,129,0.25);
    }

    .or-export-btn i    { font-size: 0.76rem; }
    .or-export-btn .chv { font-size: 0.60rem; margin-left: 2px; transition: transform 0.22s; }

    .or-export-btn:hover {
        transform:  translateY(-1px);
        box-shadow: 0 6px 18px rgba(16,185,129,0.38);
    }

    .or-dropdown {
        display:       none;
        position:      absolute;
        top:           calc(100% + 6px);
        right:         0;
        background:    var(--or-card-bg);
        border:        1px solid var(--or-card-border);
        border-radius: 12px;
        box-shadow:    0 10px 30px rgba(0,0,0,0.14);
        min-width:     190px;
        overflow:      hidden;
        z-index:       999;
        animation:     or-drop 0.22s ease;
    }

    @keyframes or-drop {
        from { opacity:0; transform:translateY(-6px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .or-dropdown.show { display: block; }

    .or-dropdown-item {
        display:         flex;
        align-items:     center;
        gap:             9px;
        padding:         11px 16px;
        font-size:       0.845rem;
        font-weight:     500;
        color:           var(--or-text-body);
        text-decoration: none;
        transition:      background 0.18s;
        border-bottom:   1px solid var(--or-divider);
    }

    .or-dropdown-item:last-child { border-bottom: none; }

    .or-dropdown-item:hover {
        background:      var(--or-table-hover);
        text-decoration: none;
        color:           var(--or-text-heading);
    }

    .or-dropdown-item i { font-size: 0.88rem; }

    /* ============================================
       TABLE CARD TOOLBAR
    ============================================ */
    .or-table-toolbar {
        padding:         13px 20px;
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        border-bottom:   1px solid var(--or-card-border);
        flex-wrap:       wrap;
        gap:             10px;
        background:      var(--or-table-head);
    }

    .or-table-title {
        font-size:   0.88rem;
        font-weight: 700;
        color:       var(--or-text-heading);
        display:     flex;
        align-items: center;
        gap:         7px;
    }

    .or-table-title i { color: #3b82f6; }

    .or-rec-chip {
        background:    var(--or-badge-bg);
        border:        1px solid var(--or-card-border);
        color:         var(--or-text-muted);
        padding:       2px 9px;
        border-radius: 20px;
        font-size:     0.68rem;
        font-weight:   600;
    }

    /* search */
    .or-search-wrap {
        position:  relative;
        width:     200px;
    }

    .or-search-wrap i {
        position:       absolute;
        left:           9px;
        top:            50%;
        transform:      translateY(-50%);
        color:          var(--or-text-muted);
        font-size:      0.70rem;
        pointer-events: none;
    }

    .or-search {
        width:         100%;
        background:    var(--or-input-bg);
        border:        1.5px solid var(--or-input-border);
        border-radius: 8px;
        padding:       7px 10px 7px 27px;
        font-size:     0.80rem;
        color:         var(--or-text-heading);
        outline:       none;
        transition:    border-color 0.2s, box-shadow 0.2s;
    }

    .or-search::placeholder { color: var(--or-text-muted); }
    .or-search:focus        { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,0.10); }

    /* ============================================
       TABLE
    ============================================ */
    .or-table {
        width:           100%;
        margin:          0;
        border-collapse: collapse;
    }

    .or-table thead th {
        background:     var(--or-table-head);
        color:          var(--or-text-muted);
        font-size:      0.67rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.9px;
        padding:        11px 16px;
        border-bottom:  2px solid var(--or-card-border);
        border-top:     none;
        white-space:    nowrap;
    }

    .or-table tbody tr {
        border-bottom: 1px solid var(--or-table-border);
        transition:    background 0.18s ease;
        animation:     or-row 0.38s ease both;
    }

    .or-table tbody tr:last-child { border-bottom: none; }
    .or-table tbody tr:hover      { background: var(--or-table-hover); }

    .or-table tbody td {
        padding:        11px 16px;
        vertical-align: middle;
        font-size:      0.855rem;
        color:          var(--or-text-body);
        border:         none;
    }

    /* row stagger */
    .or-table tbody tr:nth-child(1)  { animation-delay:.03s; }
    .or-table tbody tr:nth-child(2)  { animation-delay:.06s; }
    .or-table tbody tr:nth-child(3)  { animation-delay:.09s; }
    .or-table tbody tr:nth-child(4)  { animation-delay:.12s; }
    .or-table tbody tr:nth-child(5)  { animation-delay:.15s; }
    .or-table tbody tr:nth-child(6)  { animation-delay:.18s; }
    .or-table tbody tr:nth-child(7)  { animation-delay:.21s; }
    .or-table tbody tr:nth-child(8)  { animation-delay:.24s; }
    .or-table tbody tr:nth-child(9)  { animation-delay:.27s; }
    .or-table tbody tr:nth-child(10) { animation-delay:.30s; }

    @keyframes or-row {
        from { opacity:0; transform:translateX(-6px); }
        to   { opacity:1; transform:translateX(0); }
    }

    /* ============================================
       TABLE CELL ELEMENTS
    ============================================ */

    /* order ID */
    .or-id {
        background:    rgba(59,130,246,0.08);
        color:         #3b82f6;
        border:        1px solid rgba(59,130,246,0.18);
        padding:       3px 8px;
        border-radius: 7px;
        font-size:     0.78rem;
        font-weight:   700;
        font-family:   monospace;
        display:       inline-block;
    }

    /* customer avatar */
    .or-customer {
        display:     flex;
        align-items: center;
        gap:         8px;
    }

    .or-avatar {
        width:           30px;
        height:          30px;
        border-radius:   8px;
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        font-weight:     700;
        font-size:       0.72rem;
        color:           #fff;
        flex-shrink:     0;
    }

    .or-cust-name {
        font-weight: 600;
        font-size:   0.855rem;
        color:       var(--or-text-heading);
    }

    /* table chip */
    .or-table-chip {
        display:       inline-flex;
        align-items:   center;
        gap:           4px;
        padding:       3px 8px;
        border-radius: 7px;
        font-size:     0.76rem;
        font-weight:   600;
    }

    .or-chip-dine {
        background: rgba(59,130,246,0.08);
        color:      #3b82f6;
        border:     1px solid rgba(59,130,246,0.18);
    }

    .or-chip-take {
        background: rgba(148,163,184,0.10);
        color:      #64748b;
        border:     1px solid rgba(148,163,184,0.20);
    }

    /* type, items badges */
    .or-badge {
        display:        inline-flex;
        align-items:    center;
        gap:            4px;
        padding:        3px 9px;
        border-radius:  20px;
        font-size:      0.72rem;
        font-weight:    700;
    }

    .or-badge-type {
        background: rgba(6,182,212,0.08);
        color:      #0891b2;
        border:     1px solid rgba(6,182,212,0.18);
    }

    .or-badge-items {
        background: var(--or-badge-bg);
        color:      var(--or-text-muted);
        border:     1px solid var(--or-card-border);
    }

    /* amount */
    .or-amount {
        font-weight: 700;
        color:       #059669;
        font-size:   0.875rem;
    }

    /* payment badges */
    .or-pay {
        display:        inline-flex;
        align-items:    center;
        gap:            5px;
        padding:        4px 10px;
        border-radius:  20px;
        font-size:      0.70rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .or-pay-paid   { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }
    .or-pay-unpaid { background:rgba(245,158,11,0.10); color:#d97706; border:1px solid rgba(245,158,11,0.22); }

    /* order status badges */
    .or-status {
        display:        inline-flex;
        align-items:    center;
        gap:            5px;
        padding:        4px 10px;
        border-radius:  20px;
        font-size:      0.70rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .or-status-dot {
        width:         6px;
        height:        6px;
        border-radius: 50%;
        background:    currentColor;
        flex-shrink:   0;
    }

    .or-s-pending   { background:rgba(245,158,11,0.10); color:#d97706; border:1px solid rgba(245,158,11,0.22); }
    .or-s-cooking   { background:rgba(249,115,22,0.10); color:#ea580c; border:1px solid rgba(249,115,22,0.22); }
    .or-s-ready     { background:rgba(59,130,246,0.10); color:#2563eb; border:1px solid rgba(59,130,246,0.22); }
    .or-s-served    { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }
    .or-s-cancelled { background:rgba(148,163,184,0.10); color:#64748b; border:1px solid rgba(148,163,184,0.20); }
    .or-s-completed { background:rgba(16,185,129,0.10); color:#059669; border:1px solid rgba(16,185,129,0.22); }

    /* date */
    .or-date {
        font-size:   0.78rem;
        color:       var(--or-text-muted);
        white-space: nowrap;
    }

    /* ============================================
       ACTION BUTTONS
    ============================================ */
    .or-actions {
        display:     flex;
        align-items: center;
        gap:         6px;
    }

    .or-act {
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        gap:             5px;
        height:          32px;
        padding:         0 12px;
        border-radius:   8px;
        font-size:       0.78rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        text-decoration: none;
        transition:      all 0.22s ease;
        white-space:     nowrap;
    }

    .or-act i    { font-size: 0.74rem; }

    .or-act:hover {
        transform:       translateY(-2px);
        text-decoration: none;
    }

    /* view — blue */
    .or-act-view {
        background:   rgba(59,130,246,0.10);
        color:        #2563eb;
        border-color: rgba(59,130,246,0.22);
    }

    .or-act-view:hover {
        background:   #3b82f6;
        color:        #fff;
        border-color: #3b82f6;
        box-shadow:   0 4px 12px rgba(59,130,246,0.32);
    }

    /* delete — red */
    .or-act-del {
        background:   rgba(239,68,68,0.08);
        color:        #dc2626;
        border-color: rgba(239,68,68,0.20);
    }

    .or-act-del:hover {
        background:   #ef4444;
        color:        #fff;
        border-color: #ef4444;
        box-shadow:   0 4px 12px rgba(239,68,68,0.32);
    }

    /* ============================================
       EMPTY STATE
    ============================================ */
    .or-empty {
        padding:    60px 20px;
        text-align: center;
    }

    .or-empty-icon {
        width:           70px;
        height:          70px;
        background:      rgba(59,130,246,0.07);
        border-radius:   18px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        margin:          0 auto 16px;
        font-size:       1.9rem;
        color:           #3b82f6;
        opacity:         0.55;
    }

    .or-empty h6 {
        font-size:   0.95rem;
        font-weight: 700;
        color:       var(--or-text-heading);
        margin:      0 0 6px;
    }

    .or-empty p {
        font-size: 0.82rem;
        color:     var(--or-text-muted);
        margin:    0;
    }

    /* ============================================
       PAGINATION / FOOTER
    ============================================ */
    .or-foot {
        padding:         12px 20px;
        border-top:      1px solid var(--or-card-border);
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        flex-wrap:       wrap;
        gap:             8px;
        background:      var(--or-table-head);
    }

    .or-foot-info {
        font-size:   0.76rem;
        color:       var(--or-text-muted);
        display:     flex;
        align-items: center;
        gap:         5px;
    }

    .or-foot-info i { color: #3b82f6; }

    /* ============================================
       DELETE MODAL
    ============================================ */
    .or-overlay {
        display:         none;
        position:        fixed;
        inset:           0;
        background:      rgba(0,0,0,0.52);
        z-index:         9999;
        align-items:     center;
        justify-content: center;
        backdrop-filter: blur(3px);
    }

    .or-overlay.show { display: flex; }

    .or-modal {
        background:    var(--or-card-bg);
        border:        1px solid var(--or-card-border);
        border-radius: 16px;
        width:         100%;
        max-width:     390px;
        margin:        16px;
        overflow:      hidden;
        box-shadow:    0 24px 60px rgba(0,0,0,0.22);
        animation:     or-modal 0.28s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes or-modal {
        from { opacity:0; transform:scale(0.88) translateY(16px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }

    .or-modal-hd {
        background:  linear-gradient(110deg,#b91c1c,#ef4444);
        padding:     17px 22px;
        display:     flex;
        align-items: center;
        gap:         11px;
    }

    .or-modal-hd-ico {
        width:           37px;
        height:          37px;
        background:      rgba(255,255,255,0.18);
        border-radius:   9px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        color:           #fff;
        font-size:       0.92rem;
        flex-shrink:     0;
    }

    .or-modal-hd h6 { margin:0; color:#fff; font-weight:700; font-size:0.92rem; }
    .or-modal-hd p  { margin:2px 0 0; color:rgba(255,255,255,0.66); font-size:0.70rem; }

    .or-modal-bd { padding: 20px 22px 0; }

    .or-modal-bd > p {
        font-size:   0.855rem;
        color:       var(--or-text-body);
        margin:      0 0 6px;
        line-height: 1.6;
    }

    .or-modal-id {
        font-weight:   700;
        color:         var(--or-text-heading);
        background:    var(--or-badge-bg);
        border:        1px solid var(--or-card-border);
        border-radius: 7px;
        padding:       5px 12px;
        font-size:     0.855rem;
        display:       inline-block;
        margin:        5px 0 13px;
        font-family:   monospace;
    }

    .or-modal-warn {
        background:    rgba(245,158,11,0.08);
        border:        1px solid rgba(245,158,11,0.20);
        border-radius: 8px;
        padding:       10px 13px;
        font-size:     0.78rem;
        color:         #92400e;
        display:       flex;
        align-items:   flex-start;
        gap:           7px;
        line-height:   1.5;
    }

    [data-theme="dark"] .or-modal-warn,
    body.dark           .or-modal-warn { color: #fbbf24; }

    .or-modal-warn i { color:#f59e0b; flex-shrink:0; margin-top:2px; }

    .or-modal-ft {
        padding: 15px 22px 20px;
        display: flex;
        gap:     9px;
    }

    .or-mbt {
        flex:            1;
        display:         inline-flex;
        align-items:     center;
        justify-content: center;
        gap:             6px;
        padding:         10px 14px;
        border-radius:   9px;
        font-size:       0.845rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        transition:      all 0.22s ease;
    }

    .or-mbt:hover { transform: translateY(-1px); }

    .or-mbt-cancel {
        background:   var(--or-input-bg);
        color:        var(--or-text-body);
        border-color: var(--or-input-border);
    }

    .or-mbt-cancel:hover { box-shadow: 0 3px 10px rgba(0,0,0,0.08); }

    .or-mbt-confirm {
        background:  linear-gradient(135deg,#b91c1c,#ef4444);
        color:       #fff;
        border-color: transparent;
        box-shadow:  0 3px 12px rgba(239,68,68,0.28);
    }

    .or-mbt-confirm:hover { box-shadow: 0 6px 18px rgba(239,68,68,0.42); }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 991px) {
        .or-filter-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 767px) {
        .or-stats       { gap:8px; }
        .or-stat        { min-width:90px; padding:12px 10px 10px; }
        .or-stat-val    { font-size:1.25rem; }
        .or-filter-grid { grid-template-columns: 1fr; }
        .or-toolbar     { flex-direction:column; align-items:flex-start; }
        .or-search-wrap { width:100%; }
        .or-table-toolbar { flex-direction:column; align-items:flex-start; }

        /* hide less important cols */
        .or-table th:nth-child(4),
        .or-table td:nth-child(4),
        .or-table th:nth-child(9),
        .or-table td:nth-child(9) { display: none; }
    }

    @media (max-width: 576px) {
        .or-act span { display: none; }
    }
</style>

<!-- ========================================================
     PAGE HEADER
======================================================== -->
<div class="or-page-header">
    <div>
        <h5 class="or-page-title">
            <div class="or-title-icon">
                <i class="ti ti-receipt"></i>
            </div>
            All Orders
        </h5>
        <div class="or-breadcrumb">
            <i class="ti ti-home" style="font-size:0.65rem;"></i>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="ti ti-chevron-right sep"></i>
            <span class="cur">Orders</span>
        </div>
    </div>
    <a href="{{ route('admin.orders.create') }}" class="or-new-btn">
        <i class="ti ti-plus"></i>
        New Order
    </a>
</div>

<!-- ========================================================
     STAT CARDS
======================================================== -->
<div class="or-stats">

    <div class="or-stat or-stat-total">
        <div class="or-stat-icon"
             style="background:rgba(59,130,246,0.10);color:#3b82f6;">
            <i class="ti ti-receipt"></i>
        </div>
        <div>
            <div class="or-stat-val">{{ $stats['total'] }}</div>
            <div class="or-stat-lbl">Total</div>
        </div>
    </div>

    <div class="or-stat or-stat-pending">
        <div class="or-stat-icon"
             style="background:rgba(245,158,11,0.10);color:#f59e0b;">
            <i class="ti ti-clock"></i>
        </div>
        <div>
            <div class="or-stat-val">{{ $stats['pending'] }}</div>
            <div class="or-stat-lbl">Pending</div>
        </div>
    </div>

    <div class="or-stat or-stat-cooking">
        <div class="or-stat-icon"
             style="background:rgba(249,115,22,0.10);color:#f97316;">
            <i class="ti ti-flame"></i>
        </div>
        <div>
            <div class="or-stat-val">{{ $stats['cooking'] }}</div>
            <div class="or-stat-lbl">Cooking</div>
        </div>
    </div>

    <div class="or-stat or-stat-ready">
        <div class="or-stat-icon"
             style="background:rgba(16,185,129,0.10);color:#10b981;">
            <i class="ti ti-check"></i>
        </div>
        <div>
            <div class="or-stat-val">{{ $stats['ready'] }}</div>
            <div class="or-stat-lbl">Ready</div>
        </div>
    </div>

    <div class="or-stat or-stat-served">
        <div class="or-stat-icon"
             style="background:rgba(6,182,212,0.10);color:#06b6d4;">
            <i class="ti ti-serve"></i>
        </div>
        <div>
            <div class="or-stat-val">{{ $stats['served'] }}</div>
            <div class="or-stat-lbl">Served</div>
        </div>
    </div>

    <div class="or-stat or-stat-unpaid">
        <div class="or-stat-icon"
             style="background:rgba(239,68,68,0.10);color:#ef4444;">
            <i class="ti ti-credit-card-off"></i>
        </div>
        <div>
            <div class="or-stat-val">{{ $stats['unpaid'] }}</div>
            <div class="or-stat-lbl">Unpaid</div>
        </div>
    </div>

</div>

<!-- ========================================================
     DATE / STATUS FILTER
======================================================== -->
<div class="or-card" style="animation-delay:.10s;">
    <div class="or-card-hd">
        <div class="or-card-hd-icon"
             style="background:rgba(59,130,246,0.10);color:#3b82f6;">
            <i class="ti ti-filter"></i>
        </div>
        <h6>Filter Orders</h6>
    </div>
    <div class="or-card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="or-filter-grid">

                <div>
                    <label class="or-form-label">From Date</label>
                    <input type="date"
                           name="date_from"
                           class="or-input"
                           value="{{ request('date_from') }}">
                </div>

                <div>
                    <label class="or-form-label">To Date</label>
                    <input type="date"
                           name="date_to"
                           class="or-input"
                           value="{{ request('date_to') }}">
                </div>

                <div>
                    <label class="or-form-label">Status</label>
                    <select name="status" class="or-select">
                        <option value="">All Status</option>
                        @foreach(['pending','cooking','ready','served','cancelled'] as $s)
                        <option value="{{ $s }}"
                            {{ request('status') === $s ? 'selected':'' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="or-filter-btns">
                    <button type="submit" class="or-btn or-btn-filter">
                        <i class="ti ti-filter"></i> Filter
                    </button>
                    <a href="{{ route('admin.orders.index') }}"
                       class="or-btn or-btn-clear">
                        <i class="ti ti-x"></i> Clear
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     TOOLBAR: STATUS PILLS + EXPORT
======================================================== -->
<div class="or-toolbar">

    <!-- Status Filter Pills -->
    <div class="or-status-filters">

        @php
            $noFilter = !request('status') && !request('payment');
        @endphp

        <a href="{{ route('admin.orders.index') }}"
           class="or-filter-pill {{ $noFilter ? 'or-pill-all-active' : 'or-pill-default' }}">
            <i class="ti ti-list" style="font-size:0.70rem;"></i>
            All
        </a>

        @foreach([
            'pending'   => ['ti-clock',    'or-pill-pending-active'],
            'cooking'   => ['ti-flame',    'or-pill-cooking-active'],
            'ready'     => ['ti-check',    'or-pill-ready-active'],
            'served'    => ['ti-serve',    'or-pill-served-active'],
            'cancelled' => ['ti-ban',      'or-pill-cancelled-active'],
        ] as $s => [$icon, $cls])
        <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
           class="or-filter-pill {{
               request('status') === $s ? $cls : 'or-pill-default'
           }}">
            <i class="ti {{ $icon }}" style="font-size:0.70rem;"></i>
            {{ ucfirst($s) }}
        </a>
        @endforeach

        <a href="{{ route('admin.orders.index', ['payment' => 'unpaid']) }}"
           class="or-filter-pill {{
               request('payment') === 'unpaid'
                   ? 'or-pill-unpaid-active' : 'or-pill-default'
           }}">
            <i class="ti ti-credit-card-off" style="font-size:0.70rem;"></i>
            Unpaid
        </a>

    </div>

    <!-- Export Dropdown -->
    <div class="or-export-wrap">
        <button class="or-export-btn" id="orExportBtn">
            <i class="ti ti-download"></i>
            Export
            <i class="ti ti-chevron-down chv" id="orChv"></i>
        </button>
        <div class="or-dropdown" id="orDropdown">
            <a href="{{ route('admin.export.orders.excel', request()->all()) }}"
               class="or-dropdown-item">
                <i class="ti ti-file-spreadsheet"
                   style="color:#10b981;"></i>
                Download Excel
            </a>
            <a href="{{ route('admin.export.orders.pdf', request()->all()) }}"
               class="or-dropdown-item">
                <i class="ti ti-file-text"
                   style="color:#ef4444;"></i>
                Download PDF
            </a>
        </div>
    </div>

</div>

<!-- ========================================================
     ORDERS TABLE CARD
======================================================== -->
<div class="or-card" style="animation-delay:.18s;">

    <!-- Table Toolbar -->
    <div class="or-table-toolbar">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="or-table-title">
                <i class="ti ti-list"></i>
                Orders List
            </div>
            <span class="or-rec-chip">
                {{ $orders->total() }} records
            </span>
        </div>
        <div class="or-search-wrap">
            <i class="ti ti-search"></i>
            <input type="text"
                   class="or-search"
                   id="orSearch"
                   placeholder="Search orders...">
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="or-table" id="orTable">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Customer</th>
                    <th>Table</th>
                    <th>Type</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Time</th>
                    <th style="text-align:center; width:110px;">Actions</th>
                </tr>
            </thead>
            <tbody id="orBody">
                @forelse($orders as $order)
                @php
                    $statusMap = [
                        'pending'   => 'or-s-pending',
                        'cooking'   => 'or-s-cooking',
                        'ready'     => 'or-s-ready',
                        'served'    => 'or-s-served',
                        'cancelled' => 'or-s-cancelled',
                        'completed' => 'or-s-completed',
                    ];
                    $sCls = $statusMap[$order->status] ?? 'or-s-pending';
                @endphp
                <tr data-search="{{ strtolower($order->user->name ?? 'guest') }} {{ $order->id }}">

                    <!-- ID -->
                    <td>
                        <span class="or-id">#{{ $order->id }}</span>
                    </td>

                    <!-- Customer -->
                    <td>
                        <div class="or-customer">
                            <span class="or-avatar"
                                  style="background:linear-gradient(135deg,
                                    hsl({{ abs(crc32($order->user->name ?? 'G')) % 360 }},55%,48%),
                                    hsl({{ (abs(crc32($order->user->name ?? 'G'))+50)%360 }},55%,38%))">
                                {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                            </span>
                            <span class="or-cust-name">
                                {{ $order->user->name ?? 'Guest' }}
                            </span>
                        </div>
                    </td>

                    <!-- Table -->
                    <td>
                        @if($order->table)
                            <span class="or-table-chip or-chip-dine">
                                <i class="ti ti-armchair"
                                   style="font-size:0.62rem;"></i>
                                T#{{ $order->table->table_number }}
                            </span>
                        @else
                            <span class="or-table-chip or-chip-take">
                                <i class="ti ti-shopping-bag"
                                   style="font-size:0.62rem;"></i>
                                Takeaway
                            </span>
                        @endif
                    </td>

                    <!-- Type -->
                    <td>
                        <span class="or-badge or-badge-type">
                            {{ ucfirst(str_replace('_',' ',$order->order_type)) }}
                        </span>
                    </td>

                    <!-- Items -->
                    <td>
                        <span class="or-badge or-badge-items">
                            <i class="ti ti-tools-kitchen-2"
                               style="font-size:0.62rem;"></i>
                            {{ $order->orderItems->count() }}
                        </span>
                    </td>

                    <!-- Total -->
                    <td>
                        <span class="or-amount">
                            Rs.&nbsp;{{ number_format($order->total_amount, 0) }}
                        </span>
                    </td>

                    <!-- Payment -->
                    <td>
                        @if($order->payment_status === 'paid')
                            <span class="or-pay or-pay-paid">
                                <i class="ti ti-circle-check"
                                   style="font-size:0.60rem;"></i>
                                Paid
                            </span>
                        @else
                            <span class="or-pay or-pay-unpaid">
                                <i class="ti ti-clock"
                                   style="font-size:0.60rem;"></i>
                                Unpaid
                            </span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td>
                        <span class="or-status {{ $sCls }}">
                            <span class="or-status-dot"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <!-- Time -->
                    <td>
                        <span class="or-date">
                            {{ $order->created_at->format('d M, h:i A') }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td>
                        <div class="or-actions" style="justify-content:center;">

                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="or-act or-act-view"
                               title="View Order">
                                <i class="ti ti-eye"></i>
                                <span>View</span>
                            </a>

                            <button type="button"
                                    class="or-act or-act-del"
                                    title="Delete Order"
                                    onclick="orOpenModal(
                                        {{ $order->id }},
                                        '{{ route('admin.orders.destroy', $order) }}'
                                    )">
                                <i class="ti ti-trash"></i>
                            </button>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="or-empty">
                            <div class="or-empty-icon">
                                <i class="ti ti-receipt-off"></i>
                            </div>
                            <h6>No Orders Found</h6>
                            <p>Try adjusting your filters or create a new order</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer / Pagination -->
    @if($orders->total() > 0)
    <div class="or-foot">
        <span class="or-foot-info">
            <i class="ti ti-info-circle"></i>
            Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
            of {{ $orders->total() }} orders
        </span>
        <div>{{ $orders->links() }}</div>
    </div>
    @endif

</div>

<!-- ========================================================
     DELETE MODAL
======================================================== -->
<div class="or-overlay" id="orModal">
    <div class="or-modal">

        <div class="or-modal-hd">
            <div class="or-modal-hd-ico">
                <i class="ti ti-trash"></i>
            </div>
            <div>
                <h6>Delete Order</h6>
                <p>This action cannot be undone</p>
            </div>
        </div>

        <div class="or-modal-bd">
            <p>You are about to permanently delete:</p>
            <div class="or-modal-id" id="orModalId">—</div>
            <div class="or-modal-warn">
                <i class="ti ti-alert-triangle"></i>
                <span>
                    All order items and payment records associated
                    with this order will also be deleted.
                </span>
            </div>
        </div>

        <div class="or-modal-ft">
            <button type="button"
                    class="or-mbt or-mbt-cancel"
                    onclick="orCloseModal()">
                <i class="ti ti-x"></i> Cancel
            </button>
            <form id="orDelForm" method="POST" style="flex:1;display:contents;">
                @csrf
                @method('DELETE')
                <button type="submit" class="or-mbt or-mbt-confirm">
                    <i class="ti ti-trash"></i> Yes, Delete
                </button>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---- export dropdown ---- */
    const expBtn  = document.getElementById('orExportBtn');
    const expDrop = document.getElementById('orDropdown');
    const expChv  = document.getElementById('orChv');

    expBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        expDrop.classList.toggle('show');
        expChv.style.transform =
            expDrop.classList.contains('show') ? 'rotate(180deg)' : '';
    });

    document.addEventListener('click', function () {
        expDrop.classList.remove('show');
        expChv.style.transform = '';
    });

    /* ---- live search ---- */
    const srch = document.getElementById('orSearch');
    const rows = document.querySelectorAll('#orBody tr[data-search]');

    if (srch) {
        srch.addEventListener('input', function () {
            const q   = this.value.toLowerCase().trim();
            let   vis = 0;

            rows.forEach(r => {
                const show = r.dataset.search.includes(q);
                r.style.display = show ? '' : 'none';
                if (show) vis++;
            });

            let nr = document.getElementById('orNoRes');
            if (!vis && q) {
                if (!nr) {
                    nr    = document.createElement('tr');
                    nr.id = 'orNoRes';
                    nr.innerHTML = `<td colspan="10">
                        <div class="or-empty" style="padding:32px 20px;">
                            <div class="or-empty-icon">
                                <i class="ti ti-search"></i>
                            </div>
                            <h6>No match for "<span id="orQ"></span>"</h6>
                            <p>Try a different keyword</p>
                        </div></td>`;
                    document.getElementById('orBody').appendChild(nr);
                }
                document.getElementById('orQ').textContent = q;
                nr.style.display = '';
            } else if (nr) {
                nr.style.display = 'none';
            }
        });
    }

    /* ---- dark theme ---- */
    const dark =
        document.body.classList.contains('dark') ||
        document.body.classList.contains('dark-mode') ||
        document.documentElement.getAttribute('data-theme')    === 'dark' ||
        document.documentElement.getAttribute('data-bs-theme') === 'dark';
    if (dark) document.documentElement.setAttribute('data-theme','dark');

});

/* ---- modal ---- */
function orOpenModal(id, action) {
    document.getElementById('orModalId').textContent  = 'Order #' + id;
    document.getElementById('orDelForm').action       = action;
    document.getElementById('orModal').classList.add('show');
}

function orCloseModal() {
    document.getElementById('orModal').classList.remove('show');
}

document.getElementById('orModal').addEventListener('click', function (e) {
    if (e.target === this) orCloseModal();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') orCloseModal();
});
</script>

@endsection