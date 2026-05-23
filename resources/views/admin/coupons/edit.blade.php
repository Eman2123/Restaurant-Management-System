@extends('layouts.admin')
@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@push('styles')
<style>
    /* ========== THEME VARIABLES ========== */
    .ecpn-wrapper {
        --card-bg: #ffffff;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.15);
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --text-muted: #858796;
        --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --gradient-purple: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        --gradient-info: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --gradient-teal: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
        --section-bg: #f8f9fc;
        --border-color: #e3e6f0;
        --accent-warning: #f59e0b;
        --accent-success: #10b981;
        --accent-danger: #ef4444;
        --accent-purple: #8b5cf6;
        --accent-info: #3b82f6;
        --accent-teal: #14b8a6;
    }

    [data-bs-theme="dark"] .ecpn-wrapper {
        --card-bg: #1e2936;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.6);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.9);
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --section-bg: #141A21;
        --border-color: #3d4954;
    }

    .ecpn-wrapper {
        background: var(--section-bg);
        min-height: 100vh;
        padding: 0;
        margin: 0;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* ========== PAGE HEADER ========== */
    .ecpn-page-header {
        background: var(--gradient-warning);
        padding: 3rem;
        position: relative;
        overflow: hidden;
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ecpn-page-header::before,
    .ecpn-page-header::after {
        content: '';
        position: absolute;
        border-radius: 50%;
    }

    .ecpn-page-header::before {
        width: 400px; height: 400px;
        top: -150px; right: -100px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 15s ease-in-out infinite;
    }

    .ecpn-page-header::after {
        width: 300px; height: 300px;
        bottom: -100px; left: -50px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float2 20s ease-in-out infinite;
    }

    @keyframes float1 {
        0%,100% { transform: translate(0,0) rotate(0deg); }
        50%      { transform: translate(30px,30px) rotate(180deg); }
    }
    @keyframes float2 {
        0%,100% { transform: translate(0,0) rotate(0deg); }
        50%      { transform: translate(-30px,-30px) rotate(-180deg); }
    }

    .ecpn-header-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .ecpn-header-left {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .ecpn-page-icon {
        width: 80px; height: 80px;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
        animation: pulse 3s ease-in-out infinite;
        border: 3px solid rgba(255,255,255,0.3);
    }

    @keyframes pulse {
        0%,100% { transform: scale(1); }
        50%      { transform: scale(1.05); }
    }

    .ecpn-page-title {
        color: white;
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0;
        text-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }

    .ecpn-page-subtitle {
        color: rgba(255,255,255,0.95);
        margin: 0.5rem 0 0;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .ecpn-code-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.75rem;
        background: rgba(0,0,0,0.35);
        border: 1.5px solid rgba(245,158,11,0.5);
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        font-weight: 900;
        color: #fde68a;
        letter-spacing: 0.1em;
    }

    .ecpn-breadcrumb-pill {
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        padding: 10px 24px;
        border-radius: 30px;
        color: white;
        font-weight: 800;
        font-size: 1rem;
        border: 2px solid rgba(255,255,255,0.3);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.3s;
    }

    .ecpn-breadcrumb-pill:hover {
        background: rgba(255,255,255,0.35);
        color: white;
        transform: translateY(-2px);
    }

    /* ========== CONTENT ========== */
    .ecpn-content {
        padding: 3rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .ecpn-page-header { padding: 2rem 1.5rem; }
        .ecpn-page-title  { font-size: 1.8rem; }
        .ecpn-content     { padding: 2rem 1.5rem; }
    }

    /* ========== LAYOUT ========== */
    .ecpn-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 2rem;
        align-items: start;
    }

    @media (max-width: 991px) {
        .ecpn-layout { grid-template-columns: 1fr; }
    }

    /* ========== CARDS ========== */
    .ecpn-card {
        background: var(--card-bg);
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 2px solid var(--border-color);
        animation: scaleIn 0.6s ease-out backwards;
        transition: all 0.3s;
    }

    .ecpn-card:nth-child(1) { animation-delay: 0.15s; }
    .ecpn-card:nth-child(2) { animation-delay: 0.25s; }
    .ecpn-card:nth-child(3) { animation-delay: 0.35s; }

    .ecpn-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-4px);
    }

    .ecpn-card:last-child { margin-bottom: 0; }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95) translateY(20px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .ecpn-card-header {
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .ecpn-card-header--warning { background: var(--gradient-warning); }
    .ecpn-card-header--purple  { background: var(--gradient-purple); }
    .ecpn-card-header--info    { background: var(--gradient-info); }

    .ecpn-card-title {
        color: white;
        font-size: 1.3rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .ecpn-card-title i { font-size: 1.4rem; }

    .ecpn-card-body { padding: 2.5rem; }

    /* ========== SECTION LABEL ========== */
    .ecpn-section-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--border-color);
        position: relative;
    }

    .ecpn-section-title::after {
        content: '';
        position: absolute;
        bottom: -3px; left: 0;
        width: 50px; height: 3px;
        background: var(--gradient-warning);
    }

    .ecpn-section-title i {
        font-size: 1.2rem;
        color: var(--accent-warning);
    }

    /* ========== LABELS ========== */
    .ecpn-label {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .ecpn-label i          { font-size: 0.9rem; }
    .ecpn-label-required   { color: var(--accent-danger); }

    .ecpn-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* ========== INPUTS ========== */
    .ecpn-input,
    .ecpn-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--section-bg);
        border: 2px solid var(--border-color);
        border-radius: 14px;
        color: var(--text-primary);
        font-size: 0.9rem;
        transition: all 0.3s;
        outline: none;
        -webkit-appearance: none;
        appearance: none;
    }

    .ecpn-input:focus,
    .ecpn-select:focus {
        border-color: var(--accent-warning);
        background: var(--card-bg);
        box-shadow: 0 0 0 4px rgba(245,158,11,0.1);
        transform: translateY(-2px);
    }

    .ecpn-input::placeholder { color: var(--text-muted); opacity: 0.7; }

    .ecpn-input.is-invalid,
    .ecpn-select.is-invalid {
        border-color: var(--accent-danger);
        box-shadow: 0 0 0 4px rgba(239,68,68,0.12);
    }

    .ecpn-input--code {
        font-family: 'Courier New', monospace;
        font-size: 1.05rem;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    .ecpn-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .ecpn-input-prefix {
        position: absolute;
        left: 1rem;
        color: var(--text-muted);
        font-size: 1rem;
        pointer-events: none;
        display: flex;
        align-items: center;
        z-index: 1;
    }

    .ecpn-input-prefix-text {
        position: absolute;
        left: 1rem;
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 700;
        pointer-events: none;
        z-index: 1;
    }

    .ecpn-input-group .ecpn-input { padding-left: 2.8rem; }

    .ecpn-input-suffix {
        position: absolute;
        right: 1rem;
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        background: var(--card-bg);
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        border: 1.5px solid var(--border-color);
        pointer-events: none;
    }

    /* ========== TYPE CARDS ========== */
    .ecpn-type-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .ecpn-type-option { display: none; }

    .ecpn-type-option-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.65rem;
        padding: 1.25rem 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: 18px;
        cursor: pointer;
        transition: all 0.3s;
        background: var(--section-bg);
        text-align: center;
        position: relative;
    }

    .ecpn-type-option-label:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }

    .ecpn-type-option-label--pct:hover,
    .ecpn-type-option:checked + .ecpn-type-option-label--pct {
        border-color: var(--accent-purple);
        background: rgba(139,92,246,0.06);
        box-shadow: 0 0 0 4px rgba(139,92,246,0.1);
    }

    .ecpn-type-option-label--fixed:hover,
    .ecpn-type-option:checked + .ecpn-type-option-label--fixed {
        border-color: var(--accent-info);
        background: rgba(59,130,246,0.06);
        box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
    }

    .ecpn-type-check {
        position: absolute;
        top: 10px; right: 12px;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: transparent;
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        color: transparent;
        transition: all 0.3s;
    }

    .ecpn-type-option:checked + .ecpn-type-option-label--pct .ecpn-type-check {
        background: var(--accent-purple);
        border-color: var(--accent-purple);
        color: #fff;
    }

    .ecpn-type-option:checked + .ecpn-type-option-label--fixed .ecpn-type-check {
        background: var(--accent-info);
        border-color: var(--accent-info);
        color: #fff;
    }

    .ecpn-type-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .ecpn-type-icon--pct   { background: var(--gradient-purple); color: #fff; }
    .ecpn-type-icon--fixed { background: var(--gradient-info); color: #fff; }

    .ecpn-type-name { font-size: 0.88rem; font-weight: 800; color: var(--text-primary); }
    .ecpn-type-sub  { font-size: 0.72rem; color: var(--text-muted); }

    /* ========== TOGGLE ========== */
    .ecpn-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.2rem 1.5rem;
        background: var(--section-bg);
        border: 2px solid var(--border-color);
        border-radius: 16px;
        gap: 1rem;
        transition: all 0.3s;
    }

    .ecpn-toggle-row:hover {
        border-color: var(--accent-success);
        box-shadow: 0 0 0 4px rgba(16,185,129,0.08);
    }

    .ecpn-toggle-info { flex: 1; }

    .ecpn-toggle-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .ecpn-toggle-desc {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }

    .ecpn-switch { position: relative; width: 48px; height: 26px; flex-shrink: 0; }
    .ecpn-switch input { opacity: 0; width: 0; height: 0; }

    .ecpn-switch-slider {
        position: absolute;
        inset: 0;
        background: var(--border-color);
        border-radius: 26px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .ecpn-switch-slider::before {
        content: '';
        position: absolute;
        left: 3px; top: 3px;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: #fff;
        transition: all 0.3s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .ecpn-switch input:checked + .ecpn-switch-slider { background: var(--accent-success); }
    .ecpn-switch input:checked + .ecpn-switch-slider::before { transform: translateX(22px); }

    /* ========== ERROR BOX ========== */
    .ecpn-error-box {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        padding: 1.2rem 1.5rem;
        background: rgba(239,68,68,0.07);
        border: 2px solid rgba(239,68,68,0.2);
        border-radius: 16px;
        margin-bottom: 2rem;
        animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ecpn-error-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: rgba(239,68,68,0.12);
        border: 1.5px solid rgba(239,68,68,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .ecpn-error-title {
        font-size: 0.88rem;
        font-weight: 800;
        color: #ef4444;
        margin-bottom: 0.4rem;
    }

    .ecpn-error-list { list-style: none; padding: 0; margin: 0; }

    .ecpn-error-list li {
        font-size: 0.82rem;
        color: var(--text-secondary);
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        padding: 0.15rem 0;
    }

    .ecpn-error-list li::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: #ef4444;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ========== FORM ACTIONS ========== */
    .ecpn-form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.75rem 2.5rem;
        border-top: 2px solid var(--border-color);
        background: var(--section-bg);
        gap: 1rem;
        flex-wrap: wrap;
    }

    .ecpn-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 14px 36px;
        border-radius: 16px;
        font-size: 0.9rem;
        font-weight: 800;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .ecpn-btn i { font-size: 1.1rem; }

    .ecpn-btn--back {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(108,117,125,0.3);
    }

    .ecpn-btn--back:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(108,117,125,0.4);
        color: white;
    }

    .ecpn-btn--save {
        background: var(--gradient-warning);
        color: #fff;
        box-shadow: 0 6px 20px rgba(245,158,11,0.4);
    }

    .ecpn-btn--save:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(245,158,11,0.5);
        color: white;
    }

    .ecpn-btn--save:active  { transform: translateY(0); }
    .ecpn-btn--save:disabled { opacity: 0.65; pointer-events: none; }

    .ecpn-btn-spinner {
        display: none;
        width: 16px; height: 16px;
        border: 2.5px solid rgba(255,255,255,0.4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: ecpn-spin 0.6s linear infinite;
    }

    @keyframes ecpn-spin { to { transform: rotate(360deg); } }

    .ecpn-btn--save.is-loading .ecpn-btn-spinner { display: block; }
    .ecpn-btn--save.is-loading .ecpn-btn-text    { opacity: 0.7; }

    /* ========== SIDEBAR ========== */
    .ecpn-sidebar { display: flex; flex-direction: column; gap: 2rem; }

    .ecpn-sidebar-card {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s;
        animation: scaleIn 0.6s ease-out 0.4s backwards;
    }

    .ecpn-sidebar-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-4px);
    }

    .ecpn-sidebar-card-header {
        padding: 1.5rem 1.75rem;
        border-bottom: 2px solid var(--border-color);
        background: var(--section-bg);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .ecpn-sidebar-card-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    .ecpn-sidebar-card-body { padding: 1.75rem; }

    /* Live dot */
    .ecpn-live-dot {
        width: 9px; height: 9px;
        border-radius: 50%;
        background: var(--accent-success);
        animation: livepulse 2s infinite;
    }

    @keyframes livepulse {
        0%,100% { opacity: 1; transform: scale(1); }
        50%      { opacity: 0.5; transform: scale(0.8); }
    }

    /* Coupon ticket */
    .ecpn-coupon-ticket {
        background: linear-gradient(135deg, #1a2535 0%, #0d1117 100%);
        border: 2px dashed rgba(245,158,11,0.35);
        border-radius: 18px;
        padding: 1.75rem 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    }

    .ecpn-coupon-ticket::before,
    .ecpn-coupon-ticket::after {
        content: '';
        position: absolute;
        width: 24px; height: 24px;
        border-radius: 50%;
        background: var(--card-bg);
        top: 50%; transform: translateY(-50%);
    }

    .ecpn-coupon-ticket::before { left: -12px; }
    .ecpn-coupon-ticket::after  { right: -12px; }

    .ecpn-ticket-label {
        font-size: 0.62rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: rgba(245,158,11,0.55);
        margin-bottom: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
    }

    .ecpn-ticket-code {
        font-family: 'Courier New', monospace;
        font-size: 1.3rem;
        font-weight: 900;
        color: #f59e0b;
        letter-spacing: 0.18em;
        margin-bottom: 0.75rem;
        word-break: break-all;
        transition: all 0.3s;
    }

    .ecpn-ticket-value {
        font-size: 2.3rem;
        font-weight: 900;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 0.3rem;
        min-height: 2.7rem;
        transition: all 0.3s;
    }

    .ecpn-ticket-type {
        font-size: 0.67rem;
        color: rgba(255,255,255,0.45);
        text-transform: uppercase;
        letter-spacing: 0.12em;
        margin-bottom: 1rem;
    }

    .ecpn-ticket-divider {
        border: none;
        border-top: 1px dashed rgba(245,158,11,0.2);
        margin: 0 0 1rem;
    }

    .ecpn-ticket-meta {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.35rem;
    }

    .ecpn-ticket-meta-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.2rem;
    }

    .ecpn-ticket-meta-val {
        font-size: 0.75rem;
        font-weight: 900;
        color: rgba(255,255,255,0.8);
    }

    .ecpn-ticket-meta-key {
        font-size: 0.58rem;
        color: rgba(255,255,255,0.3);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    /* Usage stats */
    .ecpn-usage-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 0;
        border-bottom: 2px solid var(--border-color);
        transition: all 0.3s;
    }

    .ecpn-usage-row:last-child { border-bottom: none; }
    .ecpn-usage-row:hover { transform: translateX(5px); }

    .ecpn-usage-key {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .ecpn-usage-key i {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .ecpn-usage-val {
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    .ecpn-usage-bar-wrap { margin-top: 1.25rem; }

    .ecpn-usage-bar-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .ecpn-usage-track {
        height: 8px;
        background: var(--border-color);
        border-radius: 99px;
        overflow: hidden;
    }

    .ecpn-usage-fill {
        height: 100%;
        border-radius: 99px;
        background: var(--gradient-info);
        transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
    }
</style>
@endpush

@section('content')
<div class="ecpn-wrapper">

    {{-- ══ PAGE HEADER ══ --}}
    <div class="ecpn-page-header">
        <div class="ecpn-header-content">
            <div class="ecpn-header-left">
                <div class="ecpn-page-icon">
                    <i class="ti ti-edit"></i>
                </div>
                <div>
                    <h1 class="ecpn-page-title">Edit Coupon</h1>
                    <p class="ecpn-page-subtitle">
                        Editing
                        <span class="ecpn-code-pill">
                            <i class="ti ti-ticket"></i>
                            {{ $coupon->code }}
                        </span>
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.coupons.index') }}" class="ecpn-breadcrumb-pill">
                <i class="ti ti-arrow-left"></i>
                Back to Coupons
            </a>
        </div>
    </div>

    {{-- ══ CONTENT ══ --}}
    <div class="ecpn-content">

        <form method="POST"
              action="{{ route('admin.coupons.update', $coupon) }}"
              id="ecpnEditForm">
            @csrf
            @method('PUT')

            <div class="ecpn-layout">

                {{-- ═══ LEFT COLUMN ═══ --}}
                <div>

                    {{-- Validation Errors --}}
                    @if($errors->any())
                    <div class="ecpn-error-box">
                        <div class="ecpn-error-icon">
                            <i class="ti ti-alert-triangle"></i>
                        </div>
                        <div>
                            <div class="ecpn-error-title">Please fix the following errors</div>
                            <ul class="ecpn-error-list">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    {{-- ── Card 1: Coupon Identity ── --}}
                    <div class="ecpn-card">
                        <div class="ecpn-card-header ecpn-card-header--warning">
                            <h2 class="ecpn-card-title">
                                <i class="ti ti-ticket"></i>
                                Coupon Identity
                            </h2>
                        </div>
                        <div class="ecpn-card-body">

                            <div class="ecpn-section-title">
                                <i class="ti ti-code"></i>
                                Code &amp; Type
                            </div>

                            <div class="row g-3">

                                {{-- Coupon Code --}}
                                <div class="col-12">
                                    <label class="ecpn-label" for="ecpnCode">
                                        <i class="ti ti-barcode"></i>
                                        Coupon Code
                                        <span class="ecpn-label-required">*</span>
                                    </label>
                                    <div class="ecpn-input-group">
                                        <span class="ecpn-input-prefix">
                                            <i class="ti ti-hash"></i>
                                        </span>
                                        <input type="text"
                                               id="ecpnCode"
                                               name="code"
                                               class="ecpn-input ecpn-input--code {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                               value="{{ old('code', $coupon->code) }}"
                                               maxlength="20"
                                               required
                                               autocomplete="off"
                                               oninput="ecpnSyncPreview()"
                                               placeholder="e.g. SAVE20">
                                    </div>
                                    <div class="ecpn-hint">
                                        <i class="ti ti-info-circle"></i>
                                        Max 20 characters — automatically uppercased
                                    </div>
                                </div>

                                {{-- Discount Type --}}
                                <div class="col-12">
                                    <label class="ecpn-label">
                                        <i class="ti ti-adjustments"></i>
                                        Discount Type
                                        <span class="ecpn-label-required">*</span>
                                    </label>
                                    <div class="ecpn-type-options">

                                        <div>
                                            <input type="radio"
                                                   class="ecpn-type-option"
                                                   name="type"
                                                   id="typePercentage"
                                                   value="percentage"
                                                   onchange="ecpnSyncPreview()"
                                                   {{ old('type', $coupon->type) === 'percentage' ? 'checked' : '' }}>
                                            <label for="typePercentage"
                                                   class="ecpn-type-option-label ecpn-type-option-label--pct">
                                                <span class="ecpn-type-check"><i class="ti ti-check"></i></span>
                                                <div class="ecpn-type-icon ecpn-type-icon--pct">
                                                    <i class="ti ti-percentage"></i>
                                                </div>
                                                <span class="ecpn-type-name">Percentage</span>
                                                <span class="ecpn-type-sub">e.g. 20% OFF</span>
                                            </label>
                                        </div>

                                        <div>
                                            <input type="radio"
                                                   class="ecpn-type-option"
                                                   name="type"
                                                   id="typeFixed"
                                                   value="fixed"
                                                   onchange="ecpnSyncPreview()"
                                                   {{ old('type', $coupon->type) === 'fixed' ? 'checked' : '' }}>
                                            <label for="typeFixed"
                                                   class="ecpn-type-option-label ecpn-type-option-label--fixed">
                                                <span class="ecpn-type-check"><i class="ti ti-check"></i></span>
                                                <div class="ecpn-type-icon ecpn-type-icon--fixed">
                                                    <i class="ti ti-currency-rupee"></i>
                                                </div>
                                                <span class="ecpn-type-name">Fixed Amount</span>
                                                <span class="ecpn-type-sub">e.g. Rs.100 OFF</span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ── Card 2: Discount Settings ── --}}
                    <div class="ecpn-card">
                        <div class="ecpn-card-header ecpn-card-header--purple">
                            <h2 class="ecpn-card-title">
                                <i class="ti ti-discount-2"></i>
                                Discount Settings
                            </h2>
                        </div>
                        <div class="ecpn-card-body">

                            <div class="ecpn-section-title">
                                <i class="ti ti-sliders"></i>
                                Value &amp; Limits
                            </div>

                            <div class="row g-3">

                                {{-- Discount Value --}}
                                <div class="col-md-6">
                                    <label class="ecpn-label" for="ecpnValue">
                                        <i class="ti ti-discount"></i>
                                        <span id="ecpnValueLabel">Discount Value</span>
                                        <span class="ecpn-label-required">*</span>
                                    </label>
                                    <div class="ecpn-input-group">
                                        <span class="ecpn-input-prefix" id="ecpnValuePrefix">
                                            <i class="ti ti-percentage"></i>
                                        </span>
                                        <input type="number"
                                               id="ecpnValue"
                                               name="value"
                                               class="ecpn-input {{ $errors->has('value') ? 'is-invalid' : '' }}"
                                               value="{{ old('value', $coupon->value) }}"
                                               min="1"
                                               step="0.01"
                                               required
                                               oninput="ecpnSyncPreview()"
                                               placeholder="0">
                                        <span class="ecpn-input-suffix" id="ecpnValueSuffix">%</span>
                                    </div>
                                    <div class="ecpn-hint">
                                        <i class="ti ti-info-circle"></i>
                                        <span id="ecpnValueHint">Enter percentage value (1–100)</span>
                                    </div>
                                </div>

                                {{-- Min Order --}}
                                <div class="col-md-6">
                                    <label class="ecpn-label" for="ecpnMinOrder">
                                        <i class="ti ti-shopping-cart"></i>
                                        Minimum Order
                                    </label>
                                    <div class="ecpn-input-group">
                                        <span class="ecpn-input-prefix-text">Rs.</span>
                                        <input type="number"
                                               id="ecpnMinOrder"
                                               name="min_order"
                                               class="ecpn-input {{ $errors->has('min_order') ? 'is-invalid' : '' }}"
                                               value="{{ old('min_order', $coupon->min_order) }}"
                                               min="0"
                                               oninput="ecpnSyncPreview()"
                                               placeholder="0">
                                    </div>
                                    <div class="ecpn-hint">
                                        <i class="ti ti-info-circle"></i>
                                        Set 0 for no minimum requirement
                                    </div>
                                </div>

                                {{-- Max Uses --}}
                                <div class="col-md-6">
                                    <label class="ecpn-label" for="ecpnMaxUses">
                                        <i class="ti ti-users"></i>
                                        Max Uses
                                    </label>
                                    <div class="ecpn-input-group">
                                        <span class="ecpn-input-prefix">
                                            <i class="ti ti-repeat"></i>
                                        </span>
                                        <input type="number"
                                               id="ecpnMaxUses"
                                               name="max_uses"
                                               class="ecpn-input {{ $errors->has('max_uses') ? 'is-invalid' : '' }}"
                                               value="{{ old('max_uses', $coupon->max_uses) }}"
                                               min="1"
                                               oninput="ecpnSyncPreview()"
                                               placeholder="Unlimited">
                                    </div>
                                    <div class="ecpn-hint">
                                        <i class="ti ti-info-circle"></i>
                                        Leave empty for unlimited uses
                                    </div>
                                </div>

                                {{-- Expires At --}}
                                <div class="col-md-6">
                                    <label class="ecpn-label" for="ecpnExpiresAt">
                                        <i class="ti ti-calendar-event"></i>
                                        Expiry Date
                                    </label>
                                    <div class="ecpn-input-group">
                                        <span class="ecpn-input-prefix">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                        <input type="date"
                                               id="ecpnExpiresAt"
                                               name="expires_at"
                                               class="ecpn-input {{ $errors->has('expires_at') ? 'is-invalid' : '' }}"
                                               value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}"
                                               min="{{ date('Y-m-d') }}"
                                               oninput="ecpnSyncPreview()">
                                    </div>
                                    <div class="ecpn-hint">
                                        <i class="ti ti-info-circle"></i>
                                        Leave empty — coupon never expires
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ── Card 3: Additional Info ── --}}
                    <div class="ecpn-card">
                        <div class="ecpn-card-header ecpn-card-header--info">
                            <h2 class="ecpn-card-title">
                                <i class="ti ti-notes"></i>
                                Additional Info
                            </h2>
                        </div>
                        <div class="ecpn-card-body">

                            <div class="ecpn-section-title">
                                <i class="ti ti-file-text"></i>
                                Description &amp; Status
                            </div>

                            <div class="row g-3">

                                {{-- Description --}}
                                <div class="col-12">
                                    <label class="ecpn-label" for="ecpnDescription">
                                        <i class="ti ti-file-description"></i>
                                        Description
                                    </label>
                                    <div class="ecpn-input-group">
                                        <span class="ecpn-input-prefix">
                                            <i class="ti ti-align-left"></i>
                                        </span>
                                        <input type="text"
                                               id="ecpnDescription"
                                               name="description"
                                               class="ecpn-input"
                                               value="{{ old('description', $coupon->description) }}"
                                               placeholder="e.g. Weekend special discount for loyal customers"
                                               maxlength="120">
                                    </div>
                                    <div class="ecpn-hint">
                                        <i class="ti ti-info-circle"></i>
                                        Internal note — not shown to customers
                                    </div>
                                </div>

                                {{-- Active Toggle --}}
                                <div class="col-12">
                                    <div class="ecpn-toggle-row">
                                        <div class="ecpn-toggle-info">
                                            <div class="ecpn-toggle-name">
                                                <i class="ti ti-toggle-right"
                                                   style="color:var(--accent-success)"></i>
                                                Active Status
                                            </div>
                                            <div class="ecpn-toggle-desc">
                                                When enabled, customers can apply this coupon at checkout
                                            </div>
                                        </div>
                                        <label class="ecpn-switch">
                                            <input type="checkbox"
                                                   name="is_active"
                                                   value="1"
                                                   id="ecpnIsActive"
                                                   {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                            <span class="ecpn-switch-slider"></span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="ecpn-form-actions">
                            <a href="{{ route('admin.coupons.index') }}"
                               class="ecpn-btn ecpn-btn--back">
                                <i class="ti ti-arrow-left"></i>
                                <span>Back to Coupons</span>
                            </a>
                            <button type="submit"
                                    class="ecpn-btn ecpn-btn--save"
                                    id="ecpnSaveBtn">
                                <span class="ecpn-btn-spinner"></span>
                                <i class="ti ti-device-floppy ecpn-btn-text"></i>
                                <span class="ecpn-btn-text">Update Coupon</span>
                            </button>
                        </div>

                    </div>{{-- /card 3 --}}

                </div>{{-- /left column --}}

                {{-- ═══ SIDEBAR ═══ --}}
                <div class="ecpn-sidebar">

                    {{-- Live Preview --}}
                    <div class="ecpn-sidebar-card">
                        <div class="ecpn-sidebar-card-header">
                            <h3 class="ecpn-sidebar-card-title">
                                <i class="ti ti-eye" style="color:var(--accent-warning)"></i>
                                Live Preview
                            </h3>
                            <span class="ecpn-live-dot" title="Updates as you type"></span>
                        </div>
                        <div class="ecpn-sidebar-card-body">
                            <div class="ecpn-coupon-ticket">
                                <div class="ecpn-ticket-label">
                                    <i class="ti ti-building-store" style="font-size:0.75rem;"></i>
                                    Coupon Code
                                </div>
                                <div class="ecpn-ticket-code" id="previewCode">{{ $coupon->code }}</div>
                                <div class="ecpn-ticket-value" id="previewValue">—</div>
                                <div class="ecpn-ticket-type" id="previewType">Discount</div>
                                <hr class="ecpn-ticket-divider">
                                <div class="ecpn-ticket-meta">
                                    <div class="ecpn-ticket-meta-item">
                                        <span class="ecpn-ticket-meta-val" id="previewMinOrder">
                                            Rs.{{ number_format($coupon->min_order, 0) }}
                                        </span>
                                        <span class="ecpn-ticket-meta-key">Min Order</span>
                                    </div>
                                    <div class="ecpn-ticket-meta-item">
                                        <span class="ecpn-ticket-meta-val" id="previewMaxUses">
                                            {{ $coupon->max_uses ?? '∞' }}
                                        </span>
                                        <span class="ecpn-ticket-meta-key">Max Uses</span>
                                    </div>
                                    <div class="ecpn-ticket-meta-item">
                                        <span class="ecpn-ticket-meta-val" id="previewExpiry">
                                            {{ $coupon->expires_at ? $coupon->expires_at->format('d M') : '∞' }}
                                        </span>
                                        <span class="ecpn-ticket-meta-key">Expires</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Usage Statistics --}}
                    <div class="ecpn-sidebar-card">
                        <div class="ecpn-sidebar-card-header">
                            <h3 class="ecpn-sidebar-card-title">
                                <i class="ti ti-chart-bar" style="color:var(--accent-info)"></i>
                                Usage Statistics
                            </h3>
                        </div>
                        <div class="ecpn-sidebar-card-body">

                            @php
                                $usedPct = ($coupon->max_uses && $coupon->max_uses > 0)
                                    ? min(100, round(($coupon->used_count / $coupon->max_uses) * 100))
                                    : 0;
                            @endphp

                            <div class="ecpn-usage-row">
                                <span class="ecpn-usage-key">
                                    <i class="ti ti-repeat"
                                       style="background:rgba(59,130,246,0.12);color:var(--accent-info);border-radius:8px;width:30px;height:30px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;"></i>
                                    Times Used
                                </span>
                                <span class="ecpn-usage-val">{{ $coupon->used_count }}</span>
                            </div>

                            <div class="ecpn-usage-row">
                                <span class="ecpn-usage-key">
                                    <i class="ti ti-users"
                                       style="background:rgba(139,92,246,0.12);color:var(--accent-purple);border-radius:8px;width:30px;height:30px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;"></i>
                                    Max Uses
                                </span>
                                <span class="ecpn-usage-val">{{ $coupon->max_uses ?? 'Unlimited' }}</span>
                            </div>

                            <div class="ecpn-usage-row">
                                <span class="ecpn-usage-key">
                                    <i class="ti ti-calendar"
                                       style="background:rgba(245,158,11,0.12);color:var(--accent-warning);border-radius:8px;width:30px;height:30px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;"></i>
                                    Created
                                </span>
                                <span class="ecpn-usage-val">{{ $coupon->created_at->format('d M Y') }}</span>
                            </div>

                            <div class="ecpn-usage-row">
                                <span class="ecpn-usage-key">
                                    <i class="ti ti-clock-edit"
                                       style="background:rgba(16,185,129,0.12);color:var(--accent-success);border-radius:8px;width:30px;height:30px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;"></i>
                                    Last Updated
                                </span>
                                <span class="ecpn-usage-val">{{ $coupon->updated_at->diffForHumans() }}</span>
                            </div>

                            @if($coupon->max_uses)
                            <div class="ecpn-usage-bar-wrap">
                                <div class="ecpn-usage-bar-label">
                                    <span>Usage Rate</span>
                                    <span>{{ $usedPct }}%</span>
                                </div>
                                <div class="ecpn-usage-track">
                                    <div class="ecpn-usage-fill"
                                         style="width:{{ $usedPct }}%;
                                         {{ $usedPct >= 90 ? 'background:var(--gradient-danger);' : '' }}">
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                </div>{{-- /sidebar --}}

            </div>{{-- /ecpn-layout --}}
        </form>

    </div>{{-- /ecpn-content --}}
</div>{{-- /ecpn-wrapper --}}
@endsection

@push('scripts')
<script>
function ecpnSyncPreview() {
    const code    = document.getElementById('ecpnCode').value.toUpperCase() || '—';
    const value   = parseFloat(document.getElementById('ecpnValue').value) || 0;
    const minOrd  = parseFloat(document.getElementById('ecpnMinOrder').value) || 0;
    const maxUses = document.getElementById('ecpnMaxUses').value;
    const expiry  = document.getElementById('ecpnExpiresAt').value;
    const isPct   = document.getElementById('typePercentage').checked;

    document.getElementById('previewCode').textContent = code;

    const valEl = document.getElementById('previewValue');
    valEl.textContent = value > 0
        ? (isPct ? value + '% OFF' : 'Rs.' + Math.round(value) + ' OFF')
        : '—';

    document.getElementById('previewType').textContent = isPct ? 'Percentage Discount' : 'Fixed Discount';
    document.getElementById('previewMinOrder').textContent = minOrd > 0 ? 'Rs.' + minOrd.toLocaleString() : 'None';
    document.getElementById('previewMaxUses').textContent  = maxUses ? maxUses : '\u221E';

    if (expiry) {
        const d = new Date(expiry);
        document.getElementById('previewExpiry').textContent = d.toLocaleDateString('en-GB', { day:'2-digit', month:'short' });
    } else {
        document.getElementById('previewExpiry').textContent = '\u221E';
    }

    ecpnUpdateValueField(isPct);
}

function ecpnUpdateValueField(isPct) {
    const prefix = document.getElementById('ecpnValuePrefix');
    const suffix = document.getElementById('ecpnValueSuffix');
    const label  = document.getElementById('ecpnValueLabel');
    const hint   = document.getElementById('ecpnValueHint');
    const input  = document.getElementById('ecpnValue');

    if (isPct) {
        prefix.innerHTML   = '<i class="ti ti-percentage"></i>';
        suffix.textContent = '%';
        label.textContent  = 'Discount Value (%)';
        hint.textContent   = 'Enter percentage value (1–100)';
        input.max = 100;
    } else {
        prefix.innerHTML   = '<span style="font-size:0.8rem;font-weight:700;">Rs.</span>';
        suffix.textContent = 'Rs.';
        label.textContent  = 'Discount Value (Rs.)';
        hint.textContent   = 'Enter fixed rupee amount to discount';
        input.removeAttribute('max');
    }
}

document.getElementById('ecpnCode').addEventListener('input', function () {
    const pos = this.selectionStart;
    this.value = this.value.toUpperCase();
    this.setSelectionRange(pos, pos);
});

document.getElementById('ecpnEditForm').addEventListener('submit', function () {
    const btn = document.getElementById('ecpnSaveBtn');
    btn.classList.add('is-loading');
    btn.disabled = true;
});

document.addEventListener('DOMContentLoaded', ecpnSyncPreview);
</script>
@endpush