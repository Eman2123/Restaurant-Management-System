@extends('layouts.admin')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    /* ========== LIGHT THEME ========== */
    .edituser-wrapper {
        --card-bg:           #ffffff;
        --card-shadow:       0 2px 12px rgba(0,0,0,0.06);
        --card-hover-shadow: 0 12px 40px rgba(0,0,0,0.13);
        --text-primary:      #1a2535;
        --text-secondary:    #4a5568;
        --text-muted:        #94a3b8;
        --section-bg:        #f4f6f9;
        --border-color:      rgba(0,0,0,0.08);
        --input-bg:          #f8fafc;
        --input-border:      rgba(0,0,0,0.10);
        --font-main:         'DM Sans', sans-serif;
        --font-mono:         'DM Mono', monospace;
        --c-accent:          #f59e0b;
        --c-accent-2:        #d97706;
        --c-accent-soft:     rgba(245,158,11,0.12);
        --c-success:         #059669;
        --c-success-soft:    rgba(5,150,105,0.12);
        --c-purple:          #667eea;
        --c-purple-soft:     rgba(102,126,234,0.12);
        --c-danger:          #dc2626;
        --c-danger-soft:     rgba(220,38,38,0.10);
        --header-grad:       linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --divider:           rgba(0,0,0,0.07);
    }

    /* ========== DARK THEME ========== */
    body.dark-mode .edituser-wrapper,
    body.sidebar-dark-primary .edituser-wrapper,
    [data-theme="dark"] .edituser-wrapper,
    [data-bs-theme="dark"] .edituser-wrapper {
        --card-bg:           #1e2733;
        --card-shadow:       0 2px 12px rgba(0,0,0,0.4);
        --card-hover-shadow: 0 12px 40px rgba(0,0,0,0.6);
        --text-primary:      #e4eef8;
        --text-secondary:    #7a9ab8;
        --text-muted:        #4a6278;
        --section-bg:        #141A21;
        --border-color:      rgba(255,255,255,0.07);
        --input-bg:          #141A21;
        --input-border:      rgba(255,255,255,0.08);
        --c-accent:          #fbbf24;
        --c-accent-2:        #f59e0b;
        --c-accent-soft:     rgba(251,191,36,0.14);
        --c-success:         #10d97f;
        --c-success-soft:    rgba(16,217,127,0.13);
        --c-purple:          #818cf8;
        --c-purple-soft:     rgba(129,140,248,0.14);
        --c-danger:          #f87171;
        --c-danger-soft:     rgba(248,113,113,0.13);
        --divider:           rgba(255,255,255,0.06);
    }

    /* ========== BASE ========== */
    .edituser-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
    .edituser-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    /* ========== PAGE HEADER ========== */
    .eu-header {
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
    .eu-header::before {
        content:'';
        position:absolute; top:-120px; right:-80px;
        width:360px; height:360px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 18s ease-in-out infinite;
    }
    .eu-header::after {
        content:'';
        position:absolute; bottom:-120px; left:-60px;
        width:300px; height:300px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.10) 0%, transparent 70%);
        animation: float2 14s ease-in-out infinite;
    }
    @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
    @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

    .eu-header-inner {
        position: relative; z-index: 2;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .eu-header-left { display:flex; align-items:center; gap:1.2rem; }
    .eu-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.25);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .eu-header h1 {
        color: white; font-size: 1.9rem; font-weight: 800;
        margin: 0; letter-spacing: -0.5px;
    }
    .eu-header p {
        color: rgba(255,255,255,0.88); font-size: 0.92rem;
        margin: 3px 0 0; font-weight: 500;
    }

    /* User avatar pill in header */
    .eu-user-pill {
        display: inline-flex; align-items: center; gap: 10px;
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 14px;
        padding: 8px 18px 8px 8px;
    }
    .eu-avatar {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(255,255,255,0.3);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem; color: white;
        letter-spacing: 0;
    }
    .eu-user-pill span {
        color: white; font-weight: 700; font-size: 0.9rem;
    }

    .back-header-btn {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 700; font-size: 0.88rem;
        border: 2px solid rgba(255,255,255,0.3);
        cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.25s;
        text-decoration: none;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .back-header-btn:hover {
        background: rgba(255,255,255,0.32);
        color: white;
        transform: translateY(-2px);
    }

    /* ========== BODY ========== */
    .eu-body { padding: 0 1.5rem 2rem; }

    /* ========== FORM CARD ========== */
    .form-card {
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

    .form-card-header {
        background: var(--header-grad);
        padding: 1.1rem 1.6rem;
        display: flex; align-items: center; gap: 10px;
    }
    .form-card-header span { color: white; font-weight: 700; font-size: 0.95rem; }
    .form-card-header i { color: white; font-size: 1.15rem; }

    .form-body { padding: 1.8rem 2rem; }

    /* ========== ALERT ========== */
    .eu-alert {
        background: var(--c-danger-soft);
        border: 1px solid var(--c-danger);
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 1.4rem;
        color: var(--c-danger);
        font-size: 0.88rem; font-weight: 600;
    }
    .eu-alert div { display: flex; align-items: center; gap: 7px; margin-bottom: 3px; }
    .eu-alert div:last-child { margin-bottom: 0; }

    /* ========== INFO NOTICE ========== */
    .pw-notice {
        display: flex; align-items: center; gap: 8px;
        background: var(--c-accent-soft);
        border: 1px solid var(--c-accent);
        border-radius: 10px;
        padding: 9px 14px;
        margin-top: 7px;
        font-size: 0.8rem; font-weight: 600;
        color: var(--c-accent);
    }

    /* ========== FIELDS ========== */
    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
    }
    @media(max-width:600px){ .field-row { grid-template-columns: 1fr; } }

    .field-group { display: flex; flex-direction: column; }

    .field-label {
        font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.08em;
        color: var(--text-muted);
        margin-bottom: 7px;
        display: flex; align-items: center; gap: 5px;
    }
    .field-label .req { color: var(--c-danger); }

    .field-input {
        width: 100%;
        padding: 11px 14px;
        border-radius: 12px;
        border: 1.5px solid var(--input-border);
        font-size: 0.92rem;
        color: var(--text-primary);
        background: var(--input-bg);
        font-family: var(--font-main);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .field-input::placeholder { color: var(--text-muted); }
    .field-input:focus {
        border-color: var(--c-accent);
        box-shadow: 0 0 0 3px var(--c-accent-soft);
        background: var(--card-bg);
    }

    /* ========== ROLE CARDS ========== */
    .role-section { margin-bottom: 1.5rem; }
    .role-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 8px;
    }
    @media(max-width:600px){ .role-grid { grid-template-columns: 1fr; } }

    .role-option { position: relative; }
    .role-option input[type="radio"] {
        position: absolute; opacity: 0; width: 0; height: 0;
    }
    .role-label {
        display: flex; flex-direction: column; align-items: center;
        padding: 1.2rem 0.8rem;
        border-radius: 16px;
        border: 1.5px solid var(--border-color);
        background: var(--input-bg);
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
        gap: 10px; text-align: center;
    }
    .role-label:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-hover-shadow);
    }
    .role-icon {
        width: 44px; height: 44px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem;
        transition: transform 0.2s;
    }
    .role-label:hover .role-icon { transform: scale(1.1); }
    .role-name { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }
    .role-desc { font-size: 0.73rem; color: var(--text-muted); line-height: 1.4; }

    /* Admin */
    .opt-admin .role-icon { background: var(--c-purple-soft); color: var(--c-purple); }
    .opt-admin input:checked + .role-label {
        border-color: var(--c-purple);
        background: var(--c-purple-soft);
        box-shadow: 0 0 0 3px var(--c-purple-soft);
    }
    /* Staff */
    .opt-staff .role-icon { background: var(--c-success-soft); color: var(--c-success); }
    .opt-staff input:checked + .role-label {
        border-color: var(--c-success);
        background: var(--c-success-soft);
        box-shadow: 0 0 0 3px var(--c-success-soft);
    }
    /* Customer */
    .opt-cust .role-icon { background: var(--c-accent-soft); color: var(--c-accent); }
    .opt-cust input:checked + .role-label {
        border-color: var(--c-accent);
        background: var(--c-accent-soft);
        box-shadow: 0 0 0 3px var(--c-accent-soft);
    }

    /* ========== DIVIDER ========== */
    .form-divider { height: 1px; background: var(--divider); margin: 1.6rem 0; }

    /* ========== ACTION BUTTONS ========== */
    .form-actions { display: flex; justify-content: space-between; align-items: center; }

    .btn-back-form {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 22px; border-radius: 12px;
        border: 1.5px solid var(--border-color);
        background: transparent; color: var(--text-secondary);
        font-size: 0.88rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s; text-decoration: none;
        font-family: var(--font-main); letter-spacing: 0.3px;
    }
    .btn-back-form:hover {
        background: var(--section-bg);
        color: var(--text-primary);
        border-color: var(--text-muted);
    }

    .btn-update {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 28px; border-radius: 12px; border: none;
        background: var(--header-grad);
        color: white; font-size: 0.88rem; font-weight: 700;
        cursor: pointer; transition: all 0.25s;
        text-transform: uppercase; letter-spacing: 0.5px;
        box-shadow: 0 4px 14px rgba(245,158,11,0.4);
        font-family: var(--font-main);
    }
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(245,158,11,0.5);
    }
    .btn-update:active { transform: translateY(0); }

    /* ========== RESPONSIVE ========== */
    @media(max-width:768px){
        .eu-header { padding: 1.5rem; }
        .eu-header h1 { font-size: 1.5rem; }
        .eu-body { padding: 0 1rem 1.5rem; }
        .form-body { padding: 1.3rem 1.2rem; }
        .eu-user-pill { display: none; }
    }
</style>
@endpush

@section('content')
<div class="edituser-wrapper">

    {{-- ── Page Header ── --}}
    <div class="eu-header">
        <div class="eu-header-inner">
            <div class="eu-header-left">
                <div class="eu-header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h1>Edit User</h1>
                    <p>Update account details &amp; permissions</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <div class="eu-user-pill">
                    <div class="eu-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <span>{{ $user->name }}</span>
                </div>
                <a href="{{ route('admin.users.index') }}" class="back-header-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>All Users</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Form Body ── --}}
    <div class="eu-body">
        <div class="form-card">

            <div class="form-card-header">
                <i class="fas fa-user-edit"></i>
                <span>Edit: {{ $user->name }}</span>
            </div>

            <div class="form-body">

                @if($errors->any())
                <div class="eu-alert">
                    @foreach($errors->all() as $e)
                    <div><i class="fas fa-exclamation-circle"></i>{{ $e }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    {{-- Row 1: Name + Email --}}
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-user fa-sm"></i>
                                Full Name <span class="req">*</span>
                            </label>
                            <input type="text" name="name"
                                   class="field-input"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                        </div>
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-envelope fa-sm"></i>
                                Email <span class="req">*</span>
                            </label>
                            <input type="email" name="email"
                                   class="field-input"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                        </div>
                    </div>

                    {{-- Row 2: Phone + Password --}}
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-phone fa-sm"></i>
                                Phone
                            </label>
                            <input type="text" name="phone"
                                   class="field-input"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="+92 300 1234567">
                        </div>
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-lock fa-sm"></i>
                                New Password
                            </label>
                            <input type="password" name="password"
                                   class="field-input"
                                   placeholder="Enter new password">
                            <div class="pw-notice">
                                <i class="fas fa-info-circle"></i>
                                Leave empty to keep current password
                            </div>
                        </div>
                    </div>

                    {{-- Role Selection --}}
                    <div class="role-section">
                        <div class="field-label">
                            <i class="fas fa-id-badge fa-sm"></i>
                            Role <span class="req">*</span>
                        </div>
                        <div class="role-grid">

                            <div class="role-option opt-admin">
                                <input type="radio" name="role" id="role-admin" value="admin"
                                    {{ (old('role', $user->role) === 'admin') ? 'checked' : '' }} required>
                                <label for="role-admin" class="role-label">
                                    <div class="role-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <span class="role-name">Admin</span>
                                    <span class="role-desc">Full system access &amp; control</span>
                                </label>
                            </div>

                            <div class="role-option opt-staff">
                                <input type="radio" name="role" id="role-staff" value="staff"
                                    {{ (old('role', $user->role) === 'staff') ? 'checked' : '' }}>
                                <label for="role-staff" class="role-label">
                                    <div class="role-icon">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                    <span class="role-name">Staff / Chef</span>
                                    <span class="role-desc">Kitchen &amp; order management</span>
                                </label>
                            </div>

                            <div class="role-option opt-cust">
                                <input type="radio" name="role" id="role-customer" value="customer"
                                    {{ (old('role', $user->role) === 'customer') ? 'checked' : '' }}>
                                <label for="role-customer" class="role-label">
                                    <div class="role-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="role-name">Customer</span>
                                    <span class="role-desc">Ordering &amp; reservations only</span>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-actions">
                        <a href="{{ route('admin.users.index') }}" class="btn-back-form">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </a>
                        <button type="submit" class="btn-update">
                            <i class="fas fa-save"></i>
                            Update User
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
@endsection