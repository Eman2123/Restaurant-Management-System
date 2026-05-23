@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Restaurant Settings')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

  /* ========== LIGHT THEME ========== */
  .settings-wrapper {
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
    --header-grad:       linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    --danger-zone-bg:    #fff5f5;
    --danger-zone-border:rgba(220,38,38,0.2);
    --toggle-border:     rgba(0,0,0,0.07);
  }

  /* ========== DARK THEME ========== */
  body.dark-mode .settings-wrapper,
  body.sidebar-dark-primary .settings-wrapper,
  [data-theme="dark"] .settings-wrapper,
  [data-bs-theme="dark"] .settings-wrapper {
    --card-bg:           #1e2733;
    --card-shadow:       0 2px 12px rgba(0,0,0,0.4);
    --card-hover-shadow: 0 12px 40px rgba(0,0,0,0.6);
    --text-primary:      #e4eef8;
    --text-secondary:    #7a9ab8;
    --text-muted:        #4a6278;
    --section-bg:        #141A21;
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
    --danger-zone-bg:    rgba(248,113,113,0.06);
    --danger-zone-border:rgba(248,113,113,0.2);
    --toggle-border:     rgba(255,255,255,0.07);
  }

  /* ========== BASE ========== */
  .settings-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
  .settings-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
  @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

  /* ========== GRADIENT HEADER ========== */
  .settings-header {
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
  .settings-header::before {
    content:''; position:absolute; top:-110px; right:-70px;
    width:340px; height:340px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
    animation: float1 18s ease-in-out infinite;
  }
  .settings-header::after {
    content:''; position:absolute; bottom:-110px; left:-50px;
    width:290px; height:290px; border-radius:50%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    animation: float2 14s ease-in-out infinite;
  }
  @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
  @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

  .settings-header-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 1rem;
  }
  .settings-header-left { display:flex; align-items:center; gap:1.2rem; }
  .settings-header-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.22);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: white;
    border: 2px solid rgba(255,255,255,0.28);
  }
  .settings-header h1 {
    color: white; font-size: 1.9rem; font-weight: 800;
    margin: 0; letter-spacing: -0.5px;
  }
  .settings-header p {
    color: rgba(255,255,255,0.85); font-size: 0.92rem;
    margin: 3px 0 0; font-weight: 500;
  }
  .header-chip {
    background: rgba(255,255,255,0.18);
    color: white; padding: 7px 16px;
    border-radius: 12px; font-weight: 700;
    font-size: 0.84rem; border: 1px solid rgba(255,255,255,0.25);
    display: inline-flex; align-items: center; gap: 7px;
  }

  /* ========== BODY ========== */
  .settings-body { padding: 0 1.5rem 2rem; }

  /* ========== LAYOUT GRID ========== */
  .settings-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 20px;
    align-items: start;
  }
  @media(max-width:900px){ .settings-layout { grid-template-columns: 1fr; } }

  /* ========== SIDEBAR NAV ========== */
  .settings-nav {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    padding: 1.2rem;
    position: sticky; top: 80px;
    animation: fadeInUp 0.4s ease;
  }
  @keyframes fadeInUp {
    from { opacity:0; transform:translateY(12px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .nav-section-label {
    font-size: 0.68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.1em;
    color: var(--text-muted); padding: 0 8px;
    margin-bottom: 10px; margin-top: 4px;
  }

  .settings-tab {
    border: none; background: transparent;
    padding: 10px 12px; font-weight: 600;
    font-size: 0.86rem; color: var(--text-secondary);
    border-radius: 12px; cursor: pointer;
    transition: all 0.18s;
    display: flex; align-items: center; gap: 10px;
    width: 100%; text-align: left;
    margin-bottom: 3px; font-family: var(--font-main);
  }
  .settings-tab .tab-icon {
    width: 30px; height: 30px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.82rem; flex-shrink: 0;
    background: var(--section-bg); color: var(--text-muted);
    transition: all 0.18s;
  }
  .settings-tab:hover {
    background: var(--section-bg);
    color: var(--text-primary);
  }
  .settings-tab:hover .tab-icon {
    background: var(--c-accent-soft);
    color: var(--c-accent);
  }
  .settings-tab.active {
    background: var(--c-accent-soft);
    color: var(--c-accent);
  }
  .settings-tab.active .tab-icon {
    background: var(--c-accent);
    color: #fff;
  }

  .nav-divider {
    height: 1px; background: var(--border-color);
    margin: 12px 0;
  }

  .btn-save {
    width: 100%; padding: 10px 16px;
    background: var(--c-accent); color: #fff;
    border: none; border-radius: 12px;
    font-size: 0.88rem; font-weight: 700;
    cursor: pointer; display: flex;
    align-items: center; justify-content: center; gap: 8px;
    transition: all 0.2s; font-family: var(--font-main);
    text-transform: uppercase; letter-spacing: 0.04em;
  }
  .btn-save:hover {
    background: #1a57d6;
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(37,99,235,0.35);
  }

  /* ========== PANELS ========== */
  .settings-panel { display: none; }
  .settings-panel.active {
    display: block;
    animation: panelIn 0.25s ease;
  }
  @keyframes panelIn {
    from { opacity:0; transform:translateX(8px); }
    to   { opacity:1; transform:translateX(0); }
  }

  /* ========== SECTION CARD ========== */
  .section-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    margin-bottom: 16px;
    animation: fadeInUp 0.35s ease;
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
  .section-body { padding: 1.4rem; }

  /* ========== GROUP BLOCK ========== */
  .setting-group {
    background: var(--section-bg);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    padding: 1.2rem 1.3rem;
    margin-bottom: 16px;
  }
  .setting-group:last-child { margin-bottom: 0; }
  .setting-group-title {
    font-size: 0.68rem; font-weight: 800;
    letter-spacing: 0.09em; text-transform: uppercase;
    color: var(--c-accent); margin-bottom: 14px;
    display: flex; align-items: center; gap: 6px;
  }

  /* ========== FORM ELEMENTS ========== */
  .form-label {
    font-size: 0.82rem; font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 6px; display: block;
  }
  .form-control,
  .form-select {
    background: var(--card-bg) !important;
    border: 1.5px solid var(--input-border) !important;
    border-radius: 10px !important;
    padding: 9px 13px !important;
    font-size: 0.88rem !important;
    color: var(--text-primary) !important;
    transition: all 0.2s;
    font-family: var(--font-main) !important;
    width: 100%;
    outline: none;
  }
  .form-control::placeholder { color: var(--text-muted) !important; }
  .form-control:focus,
  .form-select:focus {
    border-color: var(--c-accent) !important;
    box-shadow: 0 0 0 3px var(--c-accent-soft) !important;
  }
  textarea.form-control { resize: vertical; }

  /* Input group */
  .input-group {
    display: flex; align-items: stretch;
  }
  .input-group .form-control {
    border-radius: 0 10px 10px 0 !important;
    border-left: none !important;
    flex: 1;
  }
  .input-group-text {
    background: var(--section-bg) !important;
    border: 1.5px solid var(--input-border) !important;
    border-right: none !important;
    border-radius: 10px 0 0 10px !important;
    color: var(--text-muted) !important;
    padding: 9px 13px;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex; align-items: center;
    white-space: nowrap;
  }

  .form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
  }
  .form-row-2 { grid-template-columns: 1fr 1fr; }
  .form-row-3 { grid-template-columns: 1fr 1fr 1fr; }
  .form-full  { grid-column: 1 / -1; }
  @media(max-width:600px){
    .form-row-2, .form-row-3 { grid-template-columns: 1fr; }
  }
  .mb-field { margin-bottom: 0; }

  /* ========== TOGGLE ITEMS ========== */
  .toggle-item {
    display: flex; justify-content: space-between;
    align-items: center; padding: 13px 0;
    border-bottom: 1px solid var(--toggle-border);
  }
  .toggle-item:last-child { border-bottom: none; padding-bottom: 0; }
  .toggle-label {
    font-size: 0.9rem; font-weight: 700;
    color: var(--text-primary);
  }
  .toggle-label.danger { color: var(--c-danger); }
  .toggle-desc {
    font-size: 0.78rem; color: var(--text-muted);
    margin-top: 2px; font-weight: 500;
  }

  /* Custom switch */
  .custom-switch {
    position: relative; width: 46px; height: 26px;
    display: inline-block; flex-shrink: 0;
  }
  .custom-switch input { display: none; }
  .switch-track {
    position: absolute; inset: 0;
    background: var(--border-color);
    border-radius: 26px;
    transition: all 0.25s;
    cursor: pointer;
    border: 1.5px solid var(--input-border);
  }
  .switch-track::after {
    content:'';
    position: absolute; top: 2px; left: 3px;
    width: 18px; height: 18px;
    background: white; border-radius: 50%;
    transition: transform 0.25s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
  }
  .custom-switch input:checked + .switch-track {
    background: var(--c-success);
    border-color: var(--c-success);
  }
  .custom-switch input:checked + .switch-track::after {
    transform: translateX(19px);
  }

  /* ========== DANGER ZONE ========== */
  .danger-zone {
    background: var(--danger-zone-bg);
    border: 1px solid var(--danger-zone-border);
    border-radius: 14px;
    padding: 1.2rem 1.3rem;
  }
  .danger-zone .setting-group-title { color: var(--c-danger); }
  .danger-row {
    display: flex; align-items: center;
    justify-content: space-between; gap: 12px;
  }
  .btn-danger-outline {
    padding: 8px 16px; border-radius: 10px;
    border: 1.5px solid var(--c-danger);
    background: transparent; color: var(--c-danger);
    font-size: 0.82rem; font-weight: 700;
    cursor: pointer; display: inline-flex;
    align-items: center; gap: 6px;
    transition: all 0.2s; white-space: nowrap;
    text-decoration: none; font-family: var(--font-main);
  }
  .btn-danger-outline:hover {
    background: var(--c-danger-soft);
    transform: translateY(-1px);
    color: var(--c-danger);
    text-decoration: none;
  }

  /* ========== ALERTS ========== */
  .alert-success-custom {
    background: var(--c-success-soft);
    border: 1px solid rgba(5,150,105,0.2);
    border-radius: 12px; padding: 12px 16px;
    color: var(--c-success);
    font-size: 0.88rem; font-weight: 600;
    display: flex; align-items: center; gap: 9px;
    margin-bottom: 16px;
    animation: fadeInUp 0.3s ease;
  }
  .alert-danger-custom {
    background: var(--c-danger-soft);
    border: 1px solid rgba(220,38,38,0.2);
    border-radius: 12px; padding: 12px 16px;
    color: var(--c-danger);
    font-size: 0.88rem; font-weight: 600;
    margin-bottom: 16px;
    animation: fadeInUp 0.3s ease;
  }
  .alert-close {
    background: none; border: none;
    color: inherit; cursor: pointer;
    margin-left: auto; opacity: .7;
    font-size: 1rem; padding: 0;
  }
  .alert-close:hover { opacity: 1; }

  /* Responsive */
  @media(max-width:768px){
    .settings-header { padding: 1.5rem; }
    .settings-header h1 { font-size: 1.5rem; }
    .settings-body { padding: 0 1rem 1.5rem; }
  }
</style>
@endpush

@section('content')
<div class="settings-wrapper">

  {{-- ── Gradient Header ── --}}
  <div class="settings-header">
    <div class="settings-header-inner">
      <div class="settings-header-left">
        <div class="settings-header-icon">
          <i class="fas fa-cogs"></i>
        </div>
        <div>
          <h1>Restaurant Settings</h1>
          <p>Manage your restaurant configuration and preferences</p>
        </div>
      </div>
      <span class="header-chip">
        <i class="fas fa-shield-alt"></i> Admin Control
      </span>
    </div>
  </div>

  <div class="settings-body">

    <form method="POST" action="{{ route('admin.settings.update') }}">
      @csrf

      <div class="settings-layout">

        {{-- ── Sidebar Navigation ── --}}
        <div class="settings-nav">
          <div class="nav-section-label">Navigation</div>

          <button type="button" class="settings-tab active" onclick="showPanel('general', this)">
            <span class="tab-icon"><i class="fas fa-store"></i></span>
            General Info
          </button>

          <button type="button" class="settings-tab" onclick="showPanel('contact', this)">
            <span class="tab-icon"><i class="fas fa-phone-alt"></i></span>
            Contact Info
          </button>

          <button type="button" class="settings-tab" onclick="showPanel('business', this)">
            <span class="tab-icon"><i class="fas fa-receipt"></i></span>
            Business Rules
          </button>

          <button type="button" class="settings-tab" onclick="showPanel('social', this)">
            <span class="tab-icon"><i class="fas fa-share-alt"></i></span>
            Social Media
          </button>

          <button type="button" class="settings-tab" onclick="showPanel('system', this)">
            <span class="tab-icon"><i class="fas fa-sliders-h"></i></span>
            System
          </button>

          <div class="nav-divider"></div>

          <button type="submit" class="btn-save">
            <i class="fas fa-save"></i> Save All Settings
          </button>
        </div>

        {{-- ── Right Panels ── --}}
        <div>

          {{-- Alerts --}}
          @if(session('success'))
          <div class="alert-success-custom" id="alertSuccess">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button class="alert-close" onclick="document.getElementById('alertSuccess').remove()">
              <i class="fas fa-times"></i>
            </button>
          </div>
          @endif

          @if($errors->any())
          <div class="alert-danger-custom">
            @foreach($errors->all() as $e)
            <div style="display:flex;align-items:center;gap:7px;margin-bottom:4px;">
              <i class="fas fa-exclamation-circle" style="font-size:13px;"></i> {{ $e }}
            </div>
            @endforeach
          </div>
          @endif

          {{-- ── GENERAL PANEL ── --}}
          <div class="settings-panel active" id="panel-general">
            <div class="section-card">
              <div class="section-header">
                <div class="section-header-icon" style="background:var(--c-accent-soft);color:var(--c-accent);">
                  <i class="fas fa-store"></i>
                </div>
                <span class="section-title">General Information</span>
              </div>
              <div class="section-body">
                <div class="setting-group">
                  <div class="setting-group-title">
                    <i class="fas fa-info-circle"></i> Restaurant Details
                  </div>
                  <div style="display:grid;gap:14px;">
                    <div>
                      <label class="form-label">Restaurant Name *</label>
                      <input type="text" name="restaurant_name" class="form-control"
                             value="{{ $settings['restaurant_name'] }}" required
                             placeholder="Your restaurant name">
                    </div>
                    <div>
                      <label class="form-label">About / Description</label>
                      <textarea name="about_text" class="form-control" rows="4"
                                placeholder="Short description of your restaurant...">{{ $settings['about_text'] }}</textarea>
                    </div>
                    <div>
                      <label class="form-label">Business Hours</label>
                      <input type="text" name="restaurant_hours" class="form-control"
                             value="{{ $settings['restaurant_hours'] }}"
                             placeholder="e.g. Daily: 12:00 PM - 11:00 PM">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ── CONTACT PANEL ── --}}
          <div class="settings-panel" id="panel-contact">
            <div class="section-card">
              <div class="section-header">
                <div class="section-header-icon" style="background:var(--c-info-soft);color:var(--c-info);">
                  <i class="fas fa-phone-alt"></i>
                </div>
                <span class="section-title">Contact Information</span>
              </div>
              <div class="section-body">
                <div class="setting-group">
                  <div class="setting-group-title">
                    <i class="fas fa-map-marker-alt"></i> Location & Contact
                  </div>
                  <div style="display:grid;gap:14px;">
                    <div class="form-row form-row-2">
                      <div>
                        <label class="form-label">Email *</label>
                        <input type="email" name="restaurant_email" class="form-control"
                               value="{{ $settings['restaurant_email'] }}" required
                               placeholder="restaurant@email.com">
                      </div>
                      <div>
                        <label class="form-label">Phone *</label>
                        <input type="text" name="restaurant_phone" class="form-control"
                               value="{{ $settings['restaurant_phone'] }}" required
                               placeholder="+92 300 0000000">
                      </div>
                    </div>
                    <div>
                      <label class="form-label">Address *</label>
                      <textarea name="restaurant_address" class="form-control" rows="2"
                                required placeholder="Full restaurant address">{{ $settings['restaurant_address'] }}</textarea>
                    </div>
                    <div style="max-width:320px;">
                      <label class="form-label">
                        <i class="fab fa-whatsapp" style="color:var(--c-success);margin-right:5px;"></i>
                        WhatsApp Number
                      </label>
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="fab fa-whatsapp" style="color:var(--c-success);"></i>
                        </span>
                        <input type="text" name="whatsapp_number" class="form-control"
                               value="{{ $settings['whatsapp_number'] }}"
                               placeholder="+92 300 1234567">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ── BUSINESS PANEL ── --}}
          <div class="settings-panel" id="panel-business">
            <div class="section-card">
              <div class="section-header">
                <div class="section-header-icon" style="background:var(--c-success-soft);color:var(--c-success);">
                  <i class="fas fa-receipt"></i>
                </div>
                <span class="section-title">Business Rules</span>
              </div>
              <div class="section-body">
                <div class="setting-group">
                  <div class="setting-group-title">
                    <i class="fas fa-coins"></i> Pricing & Charges
                  </div>
                  <div style="display:grid;gap:14px;">
                    <div class="form-row form-row-3">
                      <div>
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" name="currency" class="form-control"
                               value="{{ $settings['currency'] }}" maxlength="5" required
                               placeholder="Rs.">
                      </div>
                      <div>
                        <label class="form-label">Tax (%)</label>
                        <div class="input-group">
                          <input type="number" name="tax_percentage" class="form-control"
                                 value="{{ $settings['tax_percentage'] }}"
                                 min="0" max="100" step="0.1" placeholder="0">
                          <span class="input-group-text" style="border-left:none !important;border-radius:0 10px 10px 0 !important;">%</span>
                        </div>
                      </div>
                      <div>
                        <label class="form-label">Delivery Charges</label>
                        <div class="input-group">
                          <span class="input-group-text">Rs.</span>
                          <input type="number" name="delivery_charges" class="form-control"
                                 value="{{ $settings['delivery_charges'] }}" min="0" placeholder="0">
                        </div>
                      </div>
                    </div>
                    <div style="max-width:260px;">
                      <label class="form-label">Minimum Order Amount</label>
                      <div class="input-group">
                        <span class="input-group-text">Rs.</span>
                        <input type="number" name="min_order_amount" class="form-control"
                               value="{{ $settings['min_order_amount'] }}" min="0" placeholder="0">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ── SOCIAL PANEL ── --}}
          <div class="settings-panel" id="panel-social">
            <div class="section-card">
              <div class="section-header">
                <div class="section-header-icon" style="background:var(--c-warning-soft);color:var(--c-warning);">
                  <i class="fas fa-share-alt"></i>
                </div>
                <span class="section-title">Social Media Links</span>
              </div>
              <div class="section-body">
                <div class="setting-group">
                  <div class="setting-group-title">
                    <i class="fas fa-globe"></i> Social Profiles
                  </div>
                  <div style="display:grid;gap:14px;">
                    <div>
                      <label class="form-label">
                        <i class="fab fa-facebook" style="color:#1877f2;margin-right:5px;"></i>
                        Facebook URL
                      </label>
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="fab fa-facebook" style="color:#1877f2;"></i>
                        </span>
                        <input type="url" name="facebook_url" class="form-control"
                               value="{{ $settings['facebook_url'] }}"
                               placeholder="https://facebook.com/yourpage">
                      </div>
                    </div>
                    <div>
                      <label class="form-label">
                        <i class="fab fa-instagram" style="color:#e1306c;margin-right:5px;"></i>
                        Instagram URL
                      </label>
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="fab fa-instagram" style="color:#e1306c;"></i>
                        </span>
                        <input type="url" name="instagram_url" class="form-control"
                               value="{{ $settings['instagram_url'] }}"
                               placeholder="https://instagram.com/yourpage">
                      </div>
                    </div>
                    <div>
                      <label class="form-label">
                        <i class="fab fa-twitter" style="color:#1da1f2;margin-right:5px;"></i>
                        Twitter / X URL
                      </label>
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="fab fa-twitter" style="color:#1da1f2;"></i>
                        </span>
                        <input type="url" name="twitter_url" class="form-control"
                               value="{{ $settings['twitter_url'] }}"
                               placeholder="https://twitter.com/yourpage">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ── SYSTEM PANEL ── --}}
          <div class="settings-panel" id="panel-system">
            <div class="section-card">
              <div class="section-header">
                <div class="section-header-icon" style="background:var(--c-purple-soft);color:var(--c-purple);">
                  <i class="fas fa-sliders-h"></i>
                </div>
                <span class="section-title">System Settings</span>
              </div>
              <div class="section-body">

                {{-- Feature Toggles --}}
                <div class="setting-group">
                  <div class="setting-group-title">
                    <i class="fas fa-toggle-on"></i> Feature Toggles
                  </div>

                  <div class="toggle-item">
                    <div>
                      <div class="toggle-label">Allow Online Orders</div>
                      <div class="toggle-desc">Customers can place orders online</div>
                    </div>
                    <label class="custom-switch">
                      <input type="checkbox" name="allow_orders" id="allow_orders"
                             {{ $settings['allow_orders'] === '1' ? 'checked' : '' }}>
                      <span class="switch-track"></span>
                    </label>
                  </div>

                  <div class="toggle-item">
                    <div>
                      <div class="toggle-label">Allow Reservations</div>
                      <div class="toggle-desc">Customers can make table reservations</div>
                    </div>
                    <label class="custom-switch">
                      <input type="checkbox" name="allow_reservations" id="allow_reservations"
                             {{ $settings['allow_reservations'] === '1' ? 'checked' : '' }}>
                      <span class="switch-track"></span>
                    </label>
                  </div>

                  <div class="toggle-item">
                    <div>
                      <div class="toggle-label danger">Maintenance Mode</div>
                      <div class="toggle-desc">Show maintenance page to all visitors</div>
                    </div>
                    <label class="custom-switch">
                      <input type="checkbox" name="maintenance_mode" id="maintenance_mode"
                             {{ $settings['maintenance_mode'] === '1' ? 'checked' : '' }}>
                      <span class="switch-track"></span>
                    </label>
                  </div>
                </div>

                {{-- Danger Zone --}}
                <div class="danger-zone">
                  <div class="setting-group-title">
                    <i class="fas fa-exclamation-triangle"></i> Danger Zone
                  </div>
                  <div class="danger-row">
                    <div>
                      <div style="font-size:0.9rem;font-weight:700;color:var(--c-danger);">
                        Clear All Cache
                      </div>
                      <div style="font-size:0.78rem;color:var(--text-muted);margin-top:2px;">
                        Clear application cache and temporary data
                      </div>
                    </div>
                    <a href="{{ route('admin.settings.cache.clear') }}"
                       class="btn-danger-outline"
                       onclick="return confirm('Clear all cache?')">
                      <i class="fas fa-trash-alt"></i> Clear Cache
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div>{{-- /right --}}
      </div>{{-- /settings-layout --}}
    </form>

  </div>{{-- /settings-body --}}
</div>{{-- /settings-wrapper --}}
@endsection

@push('scripts')
<script>
  function showPanel(name, btn) {
    document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
    btn.classList.add('active');
  }
</script>
@endpush