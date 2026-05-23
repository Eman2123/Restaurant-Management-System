@extends('layouts.admin')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')

<style>
    /* ============================================
       THEME VARIABLES
    ============================================ */
    :root {
        --fc-page-bg:        #f4f6f9;
        --fc-card-bg:        #ffffff;
        --fc-card-border:    #e8ecf0;
        --fc-card-shadow:    0 2px 16px rgba(0,0,0,0.07);
        --fc-input-bg:       #f8fafc;
        --fc-input-border:   #e2e8f0;
        --fc-input-focus-bg: #ffffff;
        --fc-input-text:     #1e293b;
        --fc-label-color:    #374151;
        --fc-text-muted:     #94a3b8;
        --fc-text-heading:   #1e293b;
        --fc-divider:        #f1f5f9;
        --fc-upload-bg:      #f8fafc;
        --fc-upload-border:  #e2e8f0;
        --fc-upload-hover:   #fffbeb;
        --fc-switch-bg:      #e2e8f0;
    }

    [data-theme="dark"],
    body.dark,
    body.dark-mode,
    html[data-bs-theme="dark"] {
        --fc-page-bg:        #141A21;
        --fc-card-bg:        #1c2333;
        --fc-card-border:    #2a3447;
        --fc-card-shadow:    0 2px 20px rgba(0,0,0,0.35);
        --fc-input-bg:       #141A21;
        --fc-input-border:   #2a3447;
        --fc-input-focus-bg: #1a2234;
        --fc-input-text:     #e2e8f0;
        --fc-label-color:    #cbd5e1;
        --fc-text-muted:     #4a5568;
        --fc-text-heading:   #e2e8f0;
        --fc-divider:        #1e2a3a;
        --fc-upload-bg:      #141A21;
        --fc-upload-border:  #2a3447;
        --fc-upload-hover:   #1f2a1a;
        --fc-switch-bg:      #2a3447;
    }

    /* ============================================
       PAGE
    ============================================ */
    .fc-page {
        min-height:     calc(100vh - 70px);
        background:     var(--fc-page-bg);
        margin:         -20px -20px 0;
        display:        flex;
        flex-direction: column;
    }

    /* ============================================
       TOP BAR
    ============================================ */
    .fc-topbar {
        background:      var(--fc-card-bg);
        border-bottom:   1px solid var(--fc-card-border);
        padding:         14px 28px;
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        flex-wrap:       wrap;
        gap:             10px;
    }

    .fc-topbar-title {
        font-size:   1rem;
        font-weight: 700;
        color:       var(--fc-text-heading);
        display:     flex;
        align-items: center;
        gap:         8px;
    }

    .fc-topbar-title i { color: #f59e0b; }

    .fc-breadcrumb {
        display:     flex;
        align-items: center;
        gap:         6px;
        font-size:   0.80rem;
        color:       var(--fc-text-muted);
        flex-wrap:   wrap;
        margin-top:  3px;
    }

    .fc-breadcrumb a {
        color:           var(--fc-text-muted);
        text-decoration: none;
        transition:      color 0.2s;
    }

    .fc-breadcrumb a:hover  { color: #f59e0b; }
    .fc-breadcrumb .sep     { font-size: 0.60rem; opacity: 0.45; }
    .fc-breadcrumb .current { color: var(--fc-text-heading); font-weight: 600; }

    /* ============================================
       MAIN AREA
    ============================================ */
    .fc-main {
        flex:        1;
        padding:     28px;
        display:     flex;
        gap:         24px;
        align-items: flex-start;
    }

    /* ============================================
       FORM PANEL
    ============================================ */
    .fc-form-panel {
        flex:          1;
        min-width:     0;
        background:    var(--fc-card-bg);
        border:        1px solid var(--fc-card-border);
        border-radius: 14px;
        box-shadow:    var(--fc-card-shadow);
        overflow:      hidden;
        animation:     fc-slideIn 0.4s ease both;
    }

    @keyframes fc-slideIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* warning/amber gradient header */
    .fc-panel-header {
        background:  linear-gradient(110deg, #b45309 0%, #f59e0b 100%);
        padding:     20px 24px;
        display:     flex;
        align-items: center;
        gap:         12px;
    }

    .fc-panel-icon {
        width:           44px;
        height:          44px;
        background:      rgba(255,255,255,0.18);
        border-radius:   12px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        color:           #fff;
        font-size:       1rem;
        flex-shrink:     0;
    }

    .fc-panel-header h5 {
        margin:      0;
        color:       #fff;
        font-weight: 700;
        font-size:   1rem;
    }

    .fc-panel-header p {
        margin:    2px 0 0;
        color:     rgba(255,255,255,0.68);
        font-size: 0.76rem;
    }

    /* edit badge on header */
    .fc-edit-badge {
        margin-left:   auto;
        background:    rgba(255,255,255,0.18);
        border:        1px solid rgba(255,255,255,0.28);
        color:         #fff;
        padding:       5px 12px;
        border-radius: 20px;
        font-size:     0.74rem;
        font-weight:   600;
        display:       flex;
        align-items:   center;
        gap:           6px;
        flex-shrink:   0;
    }

    .fc-panel-body { padding: 28px 24px; }

    /* ============================================
       FORM ELEMENTS
    ============================================ */
    .fc-form-group  { margin-bottom: 22px; }

    .fc-label {
        display:        block;
        font-size:      0.76rem;
        font-weight:    700;
        text-transform: uppercase;
        letter-spacing: 0.9px;
        color:          var(--fc-label-color);
        margin-bottom:  8px;
    }

    .fc-label .req { color: #ef4444; margin-left: 2px; }

    .fc-label .opt {
        font-size:      0.68rem;
        font-weight:    500;
        text-transform: none;
        letter-spacing: 0;
        color:          var(--fc-text-muted);
        margin-left:    6px;
    }

    .fc-input {
        width:         100%;
        background:    var(--fc-input-bg);
        border:        1.5px solid var(--fc-input-border);
        border-radius: 10px;
        padding:       11px 14px;
        font-size:     0.90rem;
        color:         var(--fc-input-text);
        outline:       none;
        transition:    border-color 0.22s, background 0.22s, box-shadow 0.22s;
        display:       block;
    }

    .fc-input::placeholder { color: var(--fc-text-muted); }

    .fc-input:focus {
        border-color: #f59e0b;
        background:   var(--fc-input-focus-bg);
        box-shadow:   0 0 0 3px rgba(245,158,11,0.12);
    }

    .fc-input.is-error {
        border-color: #ef4444;
        box-shadow:   0 0 0 3px rgba(239,68,68,0.10);
    }

    /* char counter */
    .fc-input-footer {
        display:         flex;
        justify-content: flex-end;
        margin-top:      5px;
    }

    .fc-char-count      { font-size: 0.72rem; color: var(--fc-text-muted); }
    .fc-char-count.warn { color: #f59e0b; }
    .fc-char-count.over { color: #ef4444; }

    /* ============================================
       CURRENT IMAGE PREVIEW
    ============================================ */
    .fc-current-img-wrap {
        background:    var(--fc-upload-bg);
        border:        1px solid var(--fc-card-border);
        border-radius: 12px;
        overflow:      hidden;
        margin-bottom: 12px;
    }

    .fc-current-img-top {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        padding:         10px 14px;
        border-bottom:   1px solid var(--fc-card-border);
    }

    .fc-current-img-label {
        font-size:   0.75rem;
        font-weight: 600;
        color:       var(--fc-text-muted);
        display:     flex;
        align-items: center;
        gap:         5px;
    }

    .fc-current-img-label i { color: #10b981; }

    .fc-img-change-hint {
        font-size:     0.70rem;
        color:         #f59e0b;
        font-weight:   600;
        background:    rgba(245,158,11,0.10);
        border:        1px solid rgba(245,158,11,0.20);
        padding:       2px 8px;
        border-radius: 6px;
        display:       flex;
        align-items:   center;
        gap:           4px;
    }

    .fc-current-img-body {
        padding:    12px 14px;
        display:    flex;
        gap:        14px;
        align-items: center;
    }

    .fc-current-img-body img {
        width:         90px;
        height:        70px;
        object-fit:    cover;
        border-radius: 9px;
        border:        2px solid var(--fc-card-border);
        flex-shrink:   0;
    }

    .fc-current-img-info {
        flex: 1;
    }

    .fc-current-img-info p {
        font-size:  0.80rem;
        color:      var(--fc-text-muted);
        margin:     0 0 8px;
        line-height: 1.5;
    }

    /* ============================================
       UPLOAD ZONE
    ============================================ */
    .fc-upload-zone {
        border:        2px dashed var(--fc-upload-border);
        border-radius: 12px;
        background:    var(--fc-upload-bg);
        padding:       26px 20px;
        text-align:    center;
        cursor:        pointer;
        transition:    all 0.25s ease;
        position:      relative;
        overflow:      hidden;
    }

    .fc-upload-zone:hover,
    .fc-upload-zone.drag-over {
        border-color: #f59e0b;
        background:   var(--fc-upload-hover);
    }

    .fc-upload-zone input[type="file"] {
        position: absolute;
        inset:    0;
        opacity:  0;
        cursor:   pointer;
        width:    100%;
        height:   100%;
    }

    .fc-upload-icon {
        width:           48px;
        height:          48px;
        background:      rgba(245,158,11,0.10);
        border-radius:   12px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        margin:          0 auto 12px;
        color:           #f59e0b;
        font-size:       1.2rem;
        transition:      transform 0.25s ease;
    }

    .fc-upload-zone:hover .fc-upload-icon {
        transform: scale(1.08) translateY(-3px);
    }

    .fc-upload-title {
        font-size:   0.855rem;
        font-weight: 600;
        color:       var(--fc-text-heading);
        margin-bottom: 4px;
    }

    .fc-upload-sub {
        font-size: 0.76rem;
        color:     var(--fc-text-muted);
    }

    .fc-upload-sub span {
        display:       inline-block;
        background:    var(--fc-card-bg);
        border:        1px solid var(--fc-card-border);
        border-radius: 5px;
        padding:       1px 7px;
        font-size:     0.68rem;
        font-weight:   600;
        margin:        3px 2px 0;
    }

    /* new preview after selecting */
    .fc-new-preview {
        display:       none;
        margin-top:    12px;
        border-radius: 10px;
        overflow:      hidden;
        border:        2px solid var(--fc-input-border);
        position:      relative;
    }

    .fc-new-preview img {
        width:      100%;
        height:     150px;
        object-fit: cover;
        display:    block;
    }

    .fc-new-preview-bar {
        background:  var(--fc-card-bg);
        padding:     8px 12px;
        display:     flex;
        align-items: center;
        justify-content: space-between;
        border-top:  1px solid var(--fc-card-border);
    }

    .fc-preview-name {
        font-size:   0.75rem;
        font-weight: 600;
        color:       var(--fc-text-heading);
        display:     flex;
        align-items: center;
        gap:         5px;
    }

    .fc-preview-name i { color: #10b981; }

    .fc-preview-remove {
        background:    rgba(239,68,68,0.10);
        border:        1px solid rgba(239,68,68,0.20);
        color:         #dc2626;
        padding:       3px 9px;
        border-radius: 6px;
        font-size:     0.72rem;
        font-weight:   600;
        cursor:        pointer;
        display:       flex;
        align-items:   center;
        gap:           4px;
        transition:    all 0.2s;
    }

    .fc-preview-remove:hover {
        background:   #ef4444;
        color:        #fff;
        border-color: #ef4444;
    }

    /* ============================================
       TOGGLE
    ============================================ */
    .fc-toggle-wrap {
        background:      var(--fc-upload-bg);
        border:          1px solid var(--fc-upload-border);
        border-radius:   10px;
        padding:         14px 16px;
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        gap:             10px;
        transition:      border-color 0.22s;
        cursor:          pointer;
    }

    .fc-toggle-wrap:hover { border-color: #f59e0b; }

    .fc-toggle-title {
        font-size:   0.875rem;
        font-weight: 600;
        color:       var(--fc-text-heading);
        display:     flex;
        align-items: center;
        gap:         7px;
    }

    .fc-active-dot {
        width:         8px;
        height:        8px;
        border-radius: 50%;
        display:       inline-block;
    }

    .fc-active-dot.on {
        background: #10b981;
        animation:  fc-pulse 1.8s ease-in-out infinite;
    }

    .fc-active-dot.off { background: #94a3b8; }

    @keyframes fc-pulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); }
        50%     { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
    }

    .fc-toggle-desc {
        font-size:  0.74rem;
        color:      var(--fc-text-muted);
        margin-top: 3px;
    }

    .fc-switch {
        position:    relative;
        width:       46px;
        height:      26px;
        flex-shrink: 0;
    }

    .fc-switch input {
        opacity:  0;
        width:    0;
        height:   0;
        position: absolute;
    }

    .fc-switch-track {
        position:      absolute;
        inset:         0;
        background:    var(--fc-switch-bg);
        border-radius: 26px;
        cursor:        pointer;
        transition:    background 0.25s ease;
    }

    .fc-switch-track::after {
        content:       '';
        position:      absolute;
        top:           3px;
        left:          3px;
        width:         20px;
        height:        20px;
        background:    #fff;
        border-radius: 50%;
        transition:    transform 0.25s ease;
        box-shadow:    0 1px 5px rgba(0,0,0,0.25);
    }

    .fc-switch input:checked + .fc-switch-track { background: #f59e0b; }

    .fc-switch input:checked + .fc-switch-track::after {
        transform: translateX(20px);
    }

    /* ============================================
       ERROR ALERT
    ============================================ */
    .fc-alert {
        background:    rgba(239,68,68,0.07);
        border:        1px solid rgba(239,68,68,0.20);
        border-left:   4px solid #ef4444;
        border-radius: 10px;
        padding:       13px 16px;
        margin-bottom: 24px;
        animation:     fc-shake 0.4s ease;
    }

    @keyframes fc-shake {
        0%,100% { transform: translateX(0); }
        25%     { transform: translateX(-5px); }
        75%     { transform: translateX(5px); }
    }

    .fc-alert-head {
        display:       flex;
        align-items:   center;
        gap:           7px;
        font-size:     0.80rem;
        font-weight:   700;
        color:         #dc2626;
        margin-bottom: 8px;
    }

    .fc-alert ul {
        margin:       0;
        padding-left: 16px;
    }

    .fc-alert ul li {
        font-size:   0.80rem;
        color:       #dc2626;
        line-height: 1.7;
    }

    /* ============================================
       DIVIDER
    ============================================ */
    .fc-divider {
        border:     none;
        border-top: 1px solid var(--fc-divider);
        margin:     26px 0;
    }

    /* ============================================
       FOOTER BUTTONS
    ============================================ */
    .fc-footer {
        display:         flex;
        align-items:     center;
        justify-content: space-between;
        gap:             10px;
    }

    .fc-btn {
        display:         inline-flex;
        align-items:     center;
        gap:             7px;
        padding:         11px 22px;
        border-radius:   10px;
        font-size:       0.855rem;
        font-weight:     600;
        border:          1.5px solid transparent;
        cursor:          pointer;
        text-decoration: none;
        transition:      all 0.25s ease;
        position:        relative;
        overflow:        hidden;
    }

    .fc-btn i { font-size: 0.80rem; transition: transform 0.25s ease; }

    .fc-btn:hover {
        text-decoration: none;
        transform:       translateY(-2px);
    }

    .fc-btn-back {
        background:   var(--fc-upload-bg);
        color:        var(--fc-label-color);
        border-color: var(--fc-input-border);
    }

    .fc-btn-back:hover {
        border-color: #64748b;
        color:        var(--fc-text-heading);
        box-shadow:   0 4px 14px rgba(0,0,0,0.08);
    }

    .fc-btn-back:hover i { transform: translateX(-3px); }

    /* amber update button */
    .fc-btn-update {
        background:  linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        color:       #ffffff;
        border-color: transparent;
        box-shadow:  0 3px 14px rgba(245,158,11,0.35);
    }

    .fc-btn-update:hover {
        box-shadow: 0 7px 22px rgba(245,158,11,0.50);
        color:      #ffffff;
    }

    .fc-btn-update.fc-loading {
        pointer-events: none;
        opacity:        0.80;
    }

    @keyframes fc-spin {
        to { transform: rotate(360deg); }
    }

    /* delete btn */
    .fc-btn-delete {
        background:   rgba(239,68,68,0.08);
        color:        #dc2626;
        border-color: rgba(239,68,68,0.20);
    }

    .fc-btn-delete:hover {
        background:   #ef4444;
        color:        #fff;
        border-color: #ef4444;
        box-shadow:   0 4px 14px rgba(239,68,68,0.30);
    }

    /* ============================================
       RIGHT INFO SIDEBAR
    ============================================ */
    .fc-info-sidebar {
        width:          300px;
        flex-shrink:    0;
        display:        flex;
        flex-direction: column;
        gap:            16px;
        animation:      fc-slideIn 0.4s 0.1s ease both;
    }

    .fc-info-card {
        background:    var(--fc-card-bg);
        border:        1px solid var(--fc-card-border);
        border-radius: 14px;
        box-shadow:    var(--fc-card-shadow);
        overflow:      hidden;
    }

    .fc-info-card-head {
        padding:       13px 18px;
        border-bottom: 1px solid var(--fc-card-border);
        display:       flex;
        align-items:   center;
        gap:           8px;
    }

    .fc-info-icon {
        width:           30px;
        height:          30px;
        border-radius:   8px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        font-size:       0.78rem;
        flex-shrink:     0;
    }

    .fc-info-card-head h6 {
        margin:      0;
        font-size:   0.84rem;
        font-weight: 700;
        color:       var(--fc-text-heading);
    }

    .fc-info-card-body { padding: 16px 18px; }

    /* category meta info */
    .fc-meta-list {
        list-style: none;
        margin:     0;
        padding:    0;
        display:    flex;
        flex-direction: column;
        gap:        12px;
    }

    .fc-meta-item {
        display:     flex;
        align-items: flex-start;
        gap:         10px;
    }

    .fc-meta-icon {
        width:           28px;
        height:          28px;
        border-radius:   7px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        font-size:       0.72rem;
        flex-shrink:     0;
        margin-top:      1px;
    }

    .fc-meta-key {
        font-size:  0.72rem;
        color:      var(--fc-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .fc-meta-val {
        font-size:   0.84rem;
        font-weight: 600;
        color:       var(--fc-text-heading);
        margin-top:  2px;
    }

    /* status pill */
    .fc-status-pill {
        display:       inline-flex;
        align-items:   center;
        gap:           5px;
        padding:       3px 10px;
        border-radius: 20px;
        font-size:     0.72rem;
        font-weight:   700;
    }

    .fc-status-pill.active {
        background: rgba(16,185,129,0.12);
        color:      #059669;
        border:     1px solid rgba(16,185,129,0.22);
    }

    .fc-status-pill.inactive {
        background: rgba(148,163,184,0.12);
        color:      #64748b;
        border:     1px solid rgba(148,163,184,0.22);
    }

    /* tips */
    .fc-tips {
        list-style: none;
        margin:     0;
        padding:    0;
        display:    flex;
        flex-direction: column;
        gap:        11px;
    }

    .fc-tips li {
        display:     flex;
        gap:         9px;
        font-size:   0.815rem;
        color:       var(--fc-label-color);
        line-height: 1.55;
    }

    .fc-tip-dot {
        width:         7px;
        height:        7px;
        border-radius: 50%;
        flex-shrink:   0;
        margin-top:    5px;
    }

    /* danger zone */
    .fc-danger-zone {
        background:    rgba(239,68,68,0.05);
        border:        1px solid rgba(239,68,68,0.18);
        border-radius: 14px;
        overflow:      hidden;
    }

    .fc-danger-head {
        padding:       13px 18px;
        border-bottom: 1px solid rgba(239,68,68,0.15);
        display:       flex;
        align-items:   center;
        gap:           8px;
    }

    .fc-danger-head h6 {
        margin:      0;
        font-size:   0.84rem;
        font-weight: 700;
        color:       #dc2626;
    }

    .fc-danger-body { padding: 16px 18px; }

    .fc-danger-body p {
        font-size:   0.80rem;
        color:       var(--fc-text-muted);
        margin:      0 0 12px;
        line-height: 1.55;
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 991px) {
        .fc-main         { flex-direction: column; }
        .fc-info-sidebar { width: 100%; }
    }

    @media (max-width: 767px) {
        .fc-main       { padding: 16px; }
        .fc-topbar     { padding: 12px 16px; }
        .fc-panel-body { padding: 20px 16px; }
        .fc-footer     { flex-direction: column-reverse; }
        .fc-btn        { width: 100%; justify-content: center; }
        .fc-page       { margin: -15px -15px 0; }
        .fc-edit-badge { display: none; }
    }
</style>

<div class="fc-page">

    <!-- ===== TOP BAR ===== -->
    <div class="fc-topbar">
        <div>
            <div class="fc-topbar-title">
                <i class="fas fa-edit"></i>
                Edit Category
            </div>
            <div class="fc-breadcrumb">
                <i class="fas fa-home" style="font-size:0.68rem;"></i>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <i class="fas fa-chevron-right sep"></i>
                <a href="{{ route('admin.categories.index') }}">Categories</a>
                <i class="fas fa-chevron-right sep"></i>
                <span class="current">Edit — {{ $category->name }}</span>
            </div>
        </div>
        <a href="{{ route('admin.categories.index') }}"
           class="fc-btn fc-btn-back" style="transform:none;">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- ===== MAIN ===== -->
    <div class="fc-main">

        <!-- LEFT FORM PANEL -->
        <div class="fc-form-panel">

            <!-- Panel Header -->
            <div class="fc-panel-header">
                <div class="fc-panel-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h5>Edit Category</h5>
                    <p>Update the details for "{{ $category->name }}"</p>
                </div>
                <div class="fc-edit-badge">
                    <i class="fas fa-hashtag"></i>
                    ID: {{ $category->id }}
                </div>
            </div>

            <!-- Panel Body -->
            <div class="fc-panel-body">

                <!-- Error Alert -->
                @if($errors->any())
                <div class="fc-alert">
                    <div class="fc-alert-head">
                        <i class="fas fa-exclamation-circle"></i>
                        Please fix the following errors:
                    </div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.categories.update', $category) }}"
                      enctype="multipart/form-data"
                      id="editForm">
                    @csrf
                    @method('PUT')

                    <!-- Category Name -->
                    <div class="fc-form-group">
                        <label class="fc-label" for="catName">
                            Category Name <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="catName"
                               name="name"
                               class="fc-input {{ $errors->has('name') ? 'is-error' : '' }}"
                               value="{{ old('name', $category->name) }}"
                               placeholder="e.g. Starters, Main Course"
                               maxlength="60"
                               autocomplete="off"
                               required>
                        <div class="fc-input-footer">
                            <span class="fc-char-count" id="charCount">
                                {{ strlen(old('name', $category->name)) }} / 60
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="fc-form-group">
                        <label class="fc-label" for="catDesc">
                            Description
                            <span class="opt">(Optional)</span>
                        </label>
                        <textarea id="catDesc"
                                  name="description"
                                  class="fc-input"
                                  rows="3"
                                  placeholder="Short description about this category..."
                                  style="resize:vertical; min-height:80px;">{{ old('description', $category->description ?? '') }}</textarea>
                    </div>

                    <!-- Image -->
                    <div class="fc-form-group">
                        <label class="fc-label">
                            Category Image
                            <span class="opt">(Optional)</span>
                        </label>

                        <!-- Current image (if exists) -->
                        @if($category->image)
                        <div class="fc-current-img-wrap" id="currentImgWrap">
                            <div class="fc-current-img-top">
                                <span class="fc-current-img-label">
                                    <i class="fas fa-check-circle"></i>
                                    Current Image
                                </span>
                                <span class="fc-img-change-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Upload new to replace
                                </span>
                            </div>
                            <div class="fc-current-img-body">
                                <img src="{{ asset('storage/'.$category->image) }}"
                                     alt="{{ $category->name }}"
                                     id="currentImg">
                                <div class="fc-current-img-info">
                                    <p>
                                        This is the current image for this category.
                                        Upload a new image below to replace it, or
                                        leave empty to keep it.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Upload zone -->
                        <div class="fc-upload-zone" id="uploadZone">
                            <input type="file"
                                   name="image"
                                   id="imageInput"
                                   accept="image/*">
                            <div class="fc-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="fc-upload-title">
                                @if($category->image)
                                    Click to replace image
                                @else
                                    Click to browse or drag & drop
                                @endif
                            </div>
                            <div class="fc-upload-sub">
                                <span>JPG</span>
                                <span>PNG</span>
                                <span>WEBP</span>
                                &nbsp;&mdash;&nbsp; Max 2MB
                            </div>
                        </div>

                        <!-- New image preview -->
                        <div class="fc-new-preview" id="newPreview">
                            <img id="previewImg" src="" alt="New Preview">
                            <div class="fc-new-preview-bar">
                                <span class="fc-preview-name">
                                    <i class="fas fa-check-circle"></i>
                                    <span id="previewFileName">New image selected</span>
                                </span>
                                <button type="button"
                                        class="fc-preview-remove"
                                        id="removeImg">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Status Toggle -->
                    <div class="fc-form-group">
                        <label class="fc-label">Status</label>
                        <label class="fc-toggle-wrap" for="is_active">
                            <div class="fc-toggle-info">
                                <div class="fc-toggle-title">
                                    <span class="fc-active-dot {{ $category->is_active ? 'on' : 'off' }}"
                                          id="activeDot"></span>
                                    <span id="toggleText">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="fc-toggle-desc">
                                    Category will be visible to customers on the menu
                                </div>
                            </div>
                            <label class="fc-switch">
                                <input type="checkbox"
                                       name="is_active"
                                       id="is_active"
                                       value="1"
                                       {{ $category->is_active ? 'checked' : '' }}>
                                <span class="fc-switch-track"></span>
                            </label>
                        </label>
                    </div>

                    <hr class="fc-divider">

                    <!-- Footer -->
                    <div class="fc-footer">
                        <a href="{{ route('admin.categories.index') }}"
                           class="fc-btn fc-btn-back">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit"
                                class="fc-btn fc-btn-update"
                                id="updateBtn">
                            <i class="fas fa-save" id="updateBtnIcon"></i>
                            <span id="updateBtnText">Update Category</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- RIGHT INFO SIDEBAR -->
        <div class="fc-info-sidebar">

            <!-- Category Info Card -->
            <div class="fc-info-card">
                <div class="fc-info-card-head">
                    <div class="fc-info-icon"
                         style="background:rgba(245,158,11,0.10); color:#f59e0b;">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h6>Category Info</h6>
                </div>
                <div class="fc-info-card-body">
                    <ul class="fc-meta-list">
                        <li class="fc-meta-item">
                            <div class="fc-meta-icon"
                                 style="background:rgba(59,130,246,0.10); color:#3b82f6;">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div>
                                <div class="fc-meta-key">Category ID</div>
                                <div class="fc-meta-val">#{{ $category->id }}</div>
                            </div>
                        </li>
                        <li class="fc-meta-item">
                            <div class="fc-meta-icon"
                                 style="background:rgba(16,185,129,0.10); color:#10b981;">
                                <i class="fas fa-toggle-on"></i>
                            </div>
                            <div>
                                <div class="fc-meta-key">Current Status</div>
                                <div class="fc-meta-val">
                                    <span class="fc-status-pill {{ $category->is_active ? 'active' : 'inactive' }}">
                                        <i class="fas fa-circle" style="font-size:0.5rem;"></i>
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li class="fc-meta-item">
                            <div class="fc-meta-icon"
                                 style="background:rgba(139,92,246,0.10); color:#8b5cf6;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <div class="fc-meta-key">Created</div>
                                <div class="fc-meta-val">
                                    {{ $category->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </li>
                        <li class="fc-meta-item">
                            <div class="fc-meta-icon"
                                 style="background:rgba(245,158,11,0.10); color:#f59e0b;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div class="fc-meta-key">Last Updated</div>
                                <div class="fc-meta-val">
                                    {{ $category->updated_at->format('d M Y, h:i A') }}
                                </div>
                            </div>
                        </li>
                        @if(isset($category->menu_items_count))
                        <li class="fc-meta-item">
                            <div class="fc-meta-icon"
                                 style="background:rgba(239,68,68,0.10); color:#ef4444;">
                                <i class="fas fa-hamburger"></i>
                            </div>
                            <div>
                                <div class="fc-meta-key">Menu Items</div>
                                <div class="fc-meta-val">
                                    {{ $category->menu_items_count }} items
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="fc-info-card">
                <div class="fc-info-card-head">
                    <div class="fc-info-icon"
                         style="background:rgba(245,158,11,0.10); color:#f59e0b;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h6>Edit Tips</h6>
                </div>
                <div class="fc-info-card-body">
                    <ul class="fc-tips">
                        <li>
                            <span class="fc-tip-dot" style="background:#f59e0b;"></span>
                            Leave image empty to keep the current one
                        </li>
                        <li>
                            <span class="fc-tip-dot" style="background:#3b82f6;"></span>
                            Name changes apply immediately after save
                        </li>
                        <li>
                            <span class="fc-tip-dot" style="background:#10b981;"></span>
                            Deactivating hides category from customers
                        </li>
                        <li>
                            <span class="fc-tip-dot" style="background:#8b5cf6;"></span>
                            Existing menu items remain linked after rename
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="fc-danger-zone">
                <div class="fc-danger-head">
                    <div class="fc-info-icon"
                         style="background:rgba(239,68,68,0.12); color:#dc2626;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h6>Danger Zone</h6>
                </div>
                <div class="fc-danger-body">
                    <p>
                        Deleting this category will remove it permanently.
                        Menu items linked to it may become uncategorized.
                    </p>
                    <form method="POST"
                          action="{{ route('admin.categories.destroy', $category) }}"
                          id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="fc-btn fc-btn-delete"
                                style="width:100%; justify-content:center;"
                                id="deleteBtn">
                            <i class="fas fa-trash-alt"></i>
                            Delete Category
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <!-- end sidebar -->

    </div>
    <!-- end main -->

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---- char counter ---- */
    const nameInput = document.getElementById('catName');
    const charCount = document.getElementById('charCount');

    nameInput.addEventListener('input', function () {
        const len = this.value.length;
        charCount.textContent = len + ' / 60';
        charCount.className   = 'fc-char-count';
        if (len > 51) charCount.classList.add('warn');
        if (len >= 60) charCount.classList.add('over');
    });

    /* ---- image preview ---- */
    const input      = document.getElementById('imageInput');
    const newPreview = document.getElementById('newPreview');
    const prevImg    = document.getElementById('previewImg');
    const prevName   = document.getElementById('previewFileName');
    const removeBtn  = document.getElementById('removeImg');
    const zone       = document.getElementById('uploadZone');

    if (input) {
        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                prevImg.src              = e.target.result;
                prevName.textContent     = file.name;
                newPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', function () {
            input.value              = '';
            prevImg.src              = '';
            newPreview.style.display = 'none';
        });
    }

    /* ---- drag & drop ---- */
    if (zone) {
        ['dragover','dragenter'].forEach(ev => {
            zone.addEventListener(ev, e => {
                e.preventDefault();
                zone.classList.add('drag-over');
            });
        });

        ['dragleave','dragend'].forEach(ev => {
            zone.addEventListener(ev, () => zone.classList.remove('drag-over'));
        });

        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const dt  = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    }

    /* ---- toggle text ---- */
    const toggleChk  = document.getElementById('is_active');
    const toggleText = document.getElementById('toggleText');
    const activeDot  = document.getElementById('activeDot');

    if (toggleChk) {
        toggleChk.addEventListener('change', function () {
            if (this.checked) {
                toggleText.textContent = 'Active';
                activeDot.className    = 'fc-active-dot on';
            } else {
                toggleText.textContent = 'Inactive';
                activeDot.className    = 'fc-active-dot off';
            }
        });
    }

    /* ---- update loading ---- */
    const form          = document.getElementById('editForm');
    const updateBtn     = document.getElementById('updateBtn');
    const updateBtnIcon = document.getElementById('updateBtnIcon');
    const updateBtnText = document.getElementById('updateBtnText');

    if (form) {
        form.addEventListener('submit', function () {
            updateBtn.classList.add('fc-loading');
            updateBtnIcon.className      = 'fas fa-circle-notch';
            updateBtnIcon.style.animation = 'fc-spin 0.7s linear infinite';
            updateBtnText.textContent    = 'Updating...';
        });
    }

    /* ---- delete confirm ---- */
    const deleteBtn  = document.getElementById('deleteBtn');
    const deleteForm = document.getElementById('deleteForm');

    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            if (confirm('Are you sure you want to delete "{{ $category->name }}"?\nThis action cannot be undone.')) {
                deleteForm.submit();
            }
        });
    }

    /* ---- dark theme detect ---- */
    const isDark =
        document.body.classList.contains('dark') ||
        document.body.classList.contains('dark-mode') ||
        document.documentElement.getAttribute('data-theme') === 'dark' ||
        document.documentElement.getAttribute('data-bs-theme') === 'dark';

    if (isDark) {
        document.documentElement.setAttribute('data-theme', 'dark');
    }

});
</script>

@endsection