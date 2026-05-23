@extends('layouts.admin')
@section('title', 'Add Category')
@section('page-title', 'Add Category')

@section('content')

<style>
    /* ============================================
       THEME VARIABLES
    ============================================ */
    :root {
        --fc-page-bg:         #f4f6f9;
        --fc-card-bg:         #ffffff;
        --fc-card-border:     #e8ecf0;
        --fc-card-shadow:     0 2px 16px rgba(0,0,0,0.07);
        --fc-input-bg:        #f8fafc;
        --fc-input-border:    #e2e8f0;
        --fc-input-focus-bg:  #ffffff;
        --fc-input-text:      #1e293b;
        --fc-label-color:     #374151;
        --fc-text-muted:      #94a3b8;
        --fc-text-heading:    #1e293b;
        --fc-divider:         #f1f5f9;
        --fc-upload-bg:       #f8fafc;
        --fc-upload-border:   #e2e8f0;
        --fc-upload-hover:    #eff6ff;
        --fc-switch-bg:       #e2e8f0;
        --fc-sidebar-w:       250px;
    }

    [data-theme="dark"],
    body.dark,
    body.dark-mode,
    html[data-bs-theme="dark"] {
        --fc-page-bg:         #141A21;
        --fc-card-bg:         #1c2333;
        --fc-card-border:     #2a3447;
        --fc-card-shadow:     0 2px 20px rgba(0,0,0,0.35);
        --fc-input-bg:        #141A21;
        --fc-input-border:    #2a3447;
        --fc-input-focus-bg:  #1a2234;
        --fc-input-text:      #e2e8f0;
        --fc-label-color:     #cbd5e1;
        --fc-text-muted:      #4a5568;
        --fc-text-heading:    #e2e8f0;
        --fc-divider:         #1e2a3a;
        --fc-upload-bg:       #141A21;
        --fc-upload-border:   #2a3447;
        --fc-upload-hover:    #1a2640;
        --fc-switch-bg:       #2a3447;
    }

    /* ============================================
       PAGE WRAPPER — fills full content area
    ============================================ */
    .fc-page {
        min-height:     calc(100vh - 70px);
        background:     var(--fc-page-bg);
        padding:        0;
        margin:         -20px -20px 0;   /* cancel admin wrapper padding */
        display:        flex;
        flex-direction: column;
    }

    /* ============================================
       TOP BREADCRUMB BAR
    ============================================ */
    .fc-topbar {
        background:     var(--fc-card-bg);
        border-bottom:  1px solid var(--fc-card-border);
        padding:        14px 28px;
        display:        flex;
        align-items:    center;
        justify-content: space-between;
        flex-wrap:      wrap;
        gap:            10px;
    }

    .fc-breadcrumb {
        display:     flex;
        align-items: center;
        gap:         6px;
        font-size:   0.82rem;
        color:       var(--fc-text-muted);
        flex-wrap:   wrap;
    }

    .fc-breadcrumb a {
        color:           var(--fc-text-muted);
        text-decoration: none;
        transition:      color 0.2s;
    }

    .fc-breadcrumb a:hover { color: #3b82f6; }

    .fc-breadcrumb .sep {
        font-size: 0.65rem;
        opacity:   0.5;
    }

    .fc-breadcrumb .current {
        color:       var(--fc-text-heading);
        font-weight: 600;
    }

    .fc-topbar-title {
        font-size:   1rem;
        font-weight: 700;
        color:       var(--fc-text-heading);
        display:     flex;
        align-items: center;
        gap:         8px;
    }

    .fc-topbar-title i {
        color:      #3b82f6;
        font-size:  0.90rem;
    }

    /* ============================================
       MAIN CONTENT AREA
    ============================================ */
    .fc-main {
        flex:    1;
        padding: 28px;
        display: flex;
        gap:     24px;
        align-items: flex-start;
    }

    /* ============================================
       LEFT — FORM PANEL
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

    /* panel header */
    .fc-panel-header {
        background:  linear-gradient(110deg, #1d4ed8 0%, #3b82f6 100%);
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

    /* panel body */
    .fc-panel-body {
        padding: 28px 24px;
    }

    /* ============================================
       RIGHT — INFO SIDEBAR
    ============================================ */
    .fc-info-sidebar {
        width:      300px;
        flex-shrink: 0;
        display:    flex;
        flex-direction: column;
        gap:        16px;
        animation:  fc-slideIn 0.4s 0.1s ease both;
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

    .fc-info-card-head i {
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

    .fc-info-card-body {
        padding: 16px 18px;
    }

    /* tips list */
    .fc-tips {
        list-style: none;
        margin:     0;
        padding:    0;
        display:    flex;
        flex-direction: column;
        gap:        12px;
    }

    .fc-tips li {
        display:   flex;
        gap:       10px;
        font-size: 0.815rem;
        color:     var(--fc-label-color);
        line-height: 1.55;
    }

    .fc-tip-dot {
        width:       8px;
        height:      8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top:  5px;
    }

    /* steps */
    .fc-steps {
        display:        flex;
        flex-direction: column;
        gap:            0;
    }

    .fc-step {
        display:  flex;
        gap:      12px;
        position: relative;
    }

    .fc-step:not(:last-child)::before {
        content:    '';
        position:   absolute;
        left:       15px;
        top:        32px;
        bottom:     0;
        width:      2px;
        background: var(--fc-divider);
    }

    .fc-step-num {
        width:           32px;
        height:          32px;
        border-radius:   50%;
        background:      rgba(59,130,246,0.10);
        border:          2px solid rgba(59,130,246,0.20);
        color:           #3b82f6;
        font-size:       0.75rem;
        font-weight:     700;
        display:         flex;
        align-items:     center;
        justify-content: center;
        flex-shrink:     0;
        margin-bottom:   18px;
    }

    .fc-step-text {
        padding-top: 6px;
    }

    .fc-step-title {
        font-size:   0.82rem;
        font-weight: 700;
        color:       var(--fc-text-heading);
        margin-bottom: 2px;
    }

    .fc-step-desc {
        font-size: 0.76rem;
        color:     var(--fc-text-muted);
    }

    /* stat pills in info */
    .fc-stat-row {
        display: flex;
        gap:     10px;
    }

    .fc-stat-pill {
        flex:          1;
        background:    var(--fc-upload-bg);
        border:        1px solid var(--fc-card-border);
        border-radius: 10px;
        padding:       12px 10px;
        text-align:    center;
    }

    .fc-stat-pill-val {
        font-size:   1.1rem;
        font-weight: 800;
        color:       var(--fc-text-heading);
        line-height: 1;
    }

    .fc-stat-pill-label {
        font-size:  0.68rem;
        color:      var(--fc-text-muted);
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ============================================
       FORM ELEMENTS
    ============================================ */
    .fc-form-group {
        margin-bottom: 22px;
    }

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
        border-color: #3b82f6;
        background:   var(--fc-input-focus-bg);
        box-shadow:   0 0 0 3px rgba(59,130,246,0.12);
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

    .fc-char-count {
        font-size: 0.72rem;
        color:     var(--fc-text-muted);
    }

    .fc-char-count.warn { color: #f59e0b; }
    .fc-char-count.over { color: #ef4444; }

    /* ============================================
       UPLOAD ZONE
    ============================================ */
    .fc-upload-zone {
        border:        2px dashed var(--fc-upload-border);
        border-radius: 12px;
        background:    var(--fc-upload-bg);
        padding:       32px 20px;
        text-align:    center;
        cursor:        pointer;
        transition:    all 0.25s ease;
        position:      relative;
        overflow:      hidden;
    }

    .fc-upload-zone:hover,
    .fc-upload-zone.drag-over {
        border-color: #3b82f6;
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
        width:           56px;
        height:          56px;
        background:      rgba(59,130,246,0.10);
        border-radius:   14px;
        display:         flex;
        align-items:     center;
        justify-content: center;
        margin:          0 auto 14px;
        color:           #3b82f6;
        font-size:       1.4rem;
        transition:      transform 0.25s ease;
    }

    .fc-upload-zone:hover .fc-upload-icon {
        transform: scale(1.08) translateY(-3px);
    }

    .fc-upload-title {
        font-size:   0.875rem;
        font-weight: 600;
        color:       var(--fc-text-heading);
        margin-bottom: 5px;
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

    /* preview */
    .fc-preview {
        display:       none;
        margin-top:    14px;
        border-radius: 12px;
        overflow:      hidden;
        border:        2px solid var(--fc-input-border);
        position:      relative;
    }

    .fc-preview img {
        width:      100%;
        height:     160px;
        object-fit: cover;
        display:    block;
    }

    .fc-preview-bar {
        background: var(--fc-card-bg);
        padding:    8px 12px;
        display:    flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid var(--fc-card-border);
    }

    .fc-preview-name {
        font-size:   0.76rem;
        font-weight: 600;
        color:       var(--fc-text-heading);
        display:     flex;
        align-items: center;
        gap:         6px;
    }

    .fc-preview-name i { color: #10b981; }

    .fc-preview-remove {
        background:    rgba(239,68,68,0.10);
        border:        1px solid rgba(239,68,68,0.20);
        color:         #dc2626;
        padding:       3px 10px;
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
        background: #ef4444;
        color:      #fff;
        border-color: #ef4444;
    }

    /* ============================================
       TOGGLE
    ============================================ */
    .fc-toggle-wrap {
        background:     var(--fc-upload-bg);
        border:         1px solid var(--fc-upload-border);
        border-radius:  10px;
        padding:        14px 16px;
        display:        flex;
        align-items:    center;
        justify-content: space-between;
        gap:            10px;
        transition:     border-color 0.22s;
        cursor:         pointer;
    }

    .fc-toggle-wrap:hover { border-color: #3b82f6; }

    .fc-toggle-info  { flex: 1; }

    .fc-toggle-title {
        font-size:   0.875rem;
        font-weight: 600;
        color:       var(--fc-text-heading);
        display:     flex;
        align-items: center;
        gap:         6px;
    }

    .fc-active-dot {
        width:         8px;
        height:        8px;
        border-radius: 50%;
        background:    #10b981;
        display:       inline-block;
        animation:     fc-pulse 1.8s ease-in-out infinite;
    }

    @keyframes fc-pulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); }
        50%     { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
    }

    .fc-toggle-desc {
        font-size:  0.74rem;
        color:      var(--fc-text-muted);
        margin-top: 3px;
    }

    /* custom switch */
    .fc-switch {
        position:  relative;
        width:     46px;
        height:    26px;
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

    .fc-switch input:checked + .fc-switch-track { background: #3b82f6; }

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

    .fc-btn-save {
        background:  linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
        color:       #ffffff;
        border-color: transparent;
        box-shadow:  0 3px 14px rgba(59,130,246,0.35);
    }

    .fc-btn-save:hover {
        box-shadow: 0 7px 22px rgba(59,130,246,0.50);
        color:      #ffffff;
    }

    .fc-btn-save.fc-loading {
        pointer-events: none;
        opacity:        0.80;
    }

    @keyframes fc-spin {
        to { transform: rotate(360deg); }
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 991px) {
        .fc-main         { flex-direction: column; }
        .fc-info-sidebar { width: 100%; }
    }

    @media (max-width: 767px) {
        .fc-main    { padding: 16px; }
        .fc-topbar  { padding: 12px 16px; }
        .fc-panel-body { padding: 20px 16px; }
        .fc-footer  { flex-direction: column-reverse; }
        .fc-btn     { width: 100%; justify-content: center; }
        .fc-page    { margin: -15px -15px 0; }
    }
</style>

<div class="fc-page">

    <!-- ===== TOP BAR ===== -->
    <div class="fc-topbar">
        <div>
            <div class="fc-topbar-title">
                <i class="fas fa-layer-group"></i>
                Add New Category
            </div>
            <div class="fc-breadcrumb mt-1">
                <i class="fas fa-home" style="font-size:0.70rem;"></i>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <i class="fas fa-chevron-right sep"></i>
                <a href="{{ route('admin.categories.index') }}">Categories</a>
                <i class="fas fa-chevron-right sep"></i>
                <span class="current">Add New</span>
            </div>
        </div>
        <a href="{{ route('admin.categories.index') }}"
           class="fc-btn fc-btn-back" style="transform:none;">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- ===== MAIN AREA ===== -->
    <div class="fc-main">

        <!-- LEFT — FORM PANEL -->
        <div class="fc-form-panel">

            <!-- Panel Header -->
            <div class="fc-panel-header">
                <div class="fc-panel-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h5>Category Details</h5>
                    <p>Fill in the information below to create a new category</p>
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
                      action="{{ route('admin.categories.store') }}"
                      enctype="multipart/form-data"
                      id="categoryForm">
                    @csrf

                    <!-- Category Name -->
                    <div class="fc-form-group">
                        <label class="fc-label" for="catName">
                            Category Name <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="catName"
                               name="name"
                               class="fc-input {{ $errors->has('name') ? 'is-error' : '' }}"
                               value="{{ old('name') }}"
                               placeholder="e.g. Starters, Main Course, Desserts"
                               autocomplete="off"
                               maxlength="60"
                               required>
                        <div class="fc-input-footer">
                            <span class="fc-char-count" id="charCount">0 / 60</span>
                        </div>
                    </div>

                    <!-- Description (bonus field) -->
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
                                  style="resize:vertical; min-height:80px;">{{ old('description') }}</textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="fc-form-group">
                        <label class="fc-label">
                            Category Image
                            <span class="opt">(Optional)</span>
                        </label>

                        <div class="fc-upload-zone" id="uploadZone">
                            <input type="file"
                                   name="image"
                                   id="imageInput"
                                   accept="image/*">
                            <div class="fc-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="fc-upload-title">
                                Click to browse or drag & drop
                            </div>
                            <div class="fc-upload-sub">
                                <span>JPG</span>
                                <span>PNG</span>
                                <span>WEBP</span>
                                &nbsp;&mdash;&nbsp; Max 2MB
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="fc-preview" id="imgPreview">
                            <img id="previewImg" src="" alt="Preview">
                            <div class="fc-preview-bar">
                                <span class="fc-preview-name">
                                    <i class="fas fa-check-circle"></i>
                                    <span id="previewFileName">Image selected</span>
                                </span>
                                <button type="button"
                                        class="fc-preview-remove"
                                        id="removeImg">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Active Toggle -->
                    <div class="fc-form-group">
                        <label class="fc-label">Status</label>
                        <label class="fc-toggle-wrap" for="is_active">
                            <div class="fc-toggle-info">
                                <div class="fc-toggle-title">
                                    <span class="fc-active-dot" id="activeDot"></span>
                                    <span id="toggleText">Active</span>
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
                                       checked>
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
                                class="fc-btn fc-btn-save"
                                id="saveBtn">
                            <i class="fas fa-save" id="saveBtnIcon"></i>
                            <span id="saveBtnText">Save Category</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- RIGHT — INFO SIDEBAR -->
        <div class="fc-info-sidebar">

            <!-- Steps Card -->
            <div class="fc-info-card">
                <div class="fc-info-card-head">
                    <i class="fas fa-list-ol"
                       style="background:rgba(59,130,246,0.10);
                              color:#3b82f6;
                              width:30px;height:30px;
                              border-radius:8px;
                              display:flex;align-items:center;
                              justify-content:center;font-size:0.78rem;"></i>
                    <h6>How it works</h6>
                </div>
                <div class="fc-info-card-body">
                    <div class="fc-steps">
                        <div class="fc-step">
                            <div class="fc-step-num">1</div>
                            <div class="fc-step-text">
                                <div class="fc-step-title">Enter Category Name</div>
                                <div class="fc-step-desc">
                                    Give a clear name like "Starters" or "Beverages"
                                </div>
                            </div>
                        </div>
                        <div class="fc-step">
                            <div class="fc-step-num">2</div>
                            <div class="fc-step-text">
                                <div class="fc-step-title">Upload an Image</div>
                                <div class="fc-step-desc">
                                    Optional but recommended for better UI
                                </div>
                            </div>
                        </div>
                        <div class="fc-step">
                            <div class="fc-step-num">3</div>
                            <div class="fc-step-text">
                                <div class="fc-step-title">Set Status & Save</div>
                                <div class="fc-step-desc">
                                    Active categories appear in the customer menu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="fc-info-card">
                <div class="fc-info-card-head">
                    <i class="fas fa-lightbulb"
                       style="background:rgba(245,158,11,0.10);
                              color:#f59e0b;
                              width:30px;height:30px;
                              border-radius:8px;
                              display:flex;align-items:center;
                              justify-content:center;font-size:0.78rem;"></i>
                    <h6>Tips</h6>
                </div>
                <div class="fc-info-card-body">
                    <ul class="fc-tips">
                        <li>
                            <span class="fc-tip-dot" style="background:#3b82f6;"></span>
                            Keep category names short and descriptive
                        </li>
                        <li>
                            <span class="fc-tip-dot" style="background:#10b981;"></span>
                            Use high-quality images for better appearance
                        </li>
                        <li>
                            <span class="fc-tip-dot" style="background:#f59e0b;"></span>
                            Inactive categories are hidden from customers
                        </li>
                        <li>
                            <span class="fc-tip-dot" style="background:#8b5cf6;"></span>
                            You can edit or delete categories anytime
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Image Specs Card -->
            <div class="fc-info-card">
                <div class="fc-info-card-head">
                    <i class="fas fa-image"
                       style="background:rgba(16,185,129,0.10);
                              color:#10b981;
                              width:30px;height:30px;
                              border-radius:8px;
                              display:flex;align-items:center;
                              justify-content:center;font-size:0.78rem;"></i>
                    <h6>Image Guidelines</h6>
                </div>
                <div class="fc-info-card-body">
                    <div class="fc-stat-row mb-3">
                        <div class="fc-stat-pill">
                            <div class="fc-stat-pill-val">2MB</div>
                            <div class="fc-stat-pill-label">Max Size</div>
                        </div>
                        <div class="fc-stat-pill">
                            <div class="fc-stat-pill-val">1:1</div>
                            <div class="fc-stat-pill-label">Ratio</div>
                        </div>
                        <div class="fc-stat-pill">
                            <div class="fc-stat-pill-val">PNG</div>
                            <div class="fc-stat-pill-label">Format</div>
                        </div>
                    </div>
                    <p style="font-size:0.76rem; color:var(--fc-text-muted); margin:0;">
                        <i class="fas fa-info-circle"
                           style="color:#3b82f6; margin-right:4px;"></i>
                        Square images work best. Min resolution 400×400px recommended.
                    </p>
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
    const nameInput  = document.getElementById('catName');
    const charCount  = document.getElementById('charCount');
    const maxLen     = 60;

    nameInput.addEventListener('input', function () {
        const len = this.value.length;
        charCount.textContent = len + ' / ' + maxLen;
        charCount.className   = 'fc-char-count';
        if (len > maxLen * 0.85) charCount.classList.add('warn');
        if (len >= maxLen)       charCount.classList.add('over');
    });

    /* ---- image preview ---- */
    const input      = document.getElementById('imageInput');
    const preview    = document.getElementById('imgPreview');
    const prevImg    = document.getElementById('previewImg');
    const prevName   = document.getElementById('previewFileName');
    const removeBtn  = document.getElementById('removeImg');
    const zone       = document.getElementById('uploadZone');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            prevImg.src           = e.target.result;
            prevName.textContent  = file.name;
            preview.style.display = 'block';
            zone.style.display    = 'none';
        };
        reader.readAsDataURL(file);
    });

    removeBtn.addEventListener('click', function () {
        input.value           = '';
        prevImg.src           = '';
        preview.style.display = 'none';
        zone.style.display    = 'block';
    });

    /* ---- drag & drop ---- */
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

    /* ---- toggle text ---- */
    const toggleChk  = document.getElementById('is_active');
    const toggleText = document.getElementById('toggleText');
    const activeDot  = document.getElementById('activeDot');

    toggleChk.addEventListener('change', function () {
        if (this.checked) {
            toggleText.textContent       = 'Active';
            activeDot.style.background   = '#10b981';
            activeDot.style.animation    = 'fc-pulse 1.8s ease-in-out infinite';
        } else {
            toggleText.textContent       = 'Inactive';
            activeDot.style.background   = '#94a3b8';
            activeDot.style.animation    = 'none';
        }
    });

    /* ---- save loading ---- */
    const form       = document.getElementById('categoryForm');
    const saveBtn    = document.getElementById('saveBtn');
    const saveBtnIcon= document.getElementById('saveBtnIcon');
    const saveBtnTxt = document.getElementById('saveBtnText');

    form.addEventListener('submit', function () {
        saveBtn.classList.add('fc-loading');
        saveBtnIcon.className = 'fas fa-circle-notch';
        saveBtnIcon.style.animation = 'fc-spin 0.7s linear infinite';
        saveBtnTxt.textContent = 'Saving...';
    });

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