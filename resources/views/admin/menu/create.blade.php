@extends('layouts.admin')
@section('title', 'Add Menu Item')
@section('page-title', 'Add Menu Item')

@push('styles')
<style>
    /* ========== UNIVERSAL THEME DETECTION ========== */
    /* Supports: AdminLTE, SB Admin, CoreUI, Bootstrap 5, Custom themes */
    
    /* Light Theme (Default) */
    .menu-form-wrapper {
        --card-bg: #ffffff;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.12);
        --input-bg: #ffffff;
        --input-border: #e3e6f0;
        --input-focus-border: #667eea;
        --input-focus-shadow: rgba(102, 126, 234, 0.12);
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --text-muted: #858796;
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        --gradient-info: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
        --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --preview-bg: #f8f9fc;
        --label-color: #5a5c69;
        --section-bg: #f8f9fc;
        --border-color: #e3e6f0;
        --white: #ffffff;
        --overlay-bg: rgba(0, 0, 0, 0.7);
        --tips-bg: #e7f3ff;
        --tips-border: #667eea;
    }

    /* Dark Theme - Multiple Detection Methods */
    body.dark-mode .menu-form-wrapper,
    body.sidebar-dark-primary .menu-form-wrapper,
    [data-theme="dark"] .menu-form-wrapper,
    [data-bs-theme="dark"] .menu-form-wrapper,
    .dark .menu-form-wrapper,
    html[data-color-mode="dark"] .menu-form-wrapper {
        --card-bg: #1e293b;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.6);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.8);
        --input-bg: #334155;
        --input-border: #475569;
        --input-focus-border: #8b5cf6;
        --input-focus-shadow: rgba(139, 92, 246, 0.15);
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --gradient-primary: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --gradient-info: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        --preview-bg: #0f172a;
        --label-color: #e2e8f0;
        --section-bg: #0f172a;
        --border-color: #475569;
        --white: #f8fafc;
        --overlay-bg: rgba(15, 23, 42, 0.85);
        --tips-bg: #1e293b;
        --tips-border: #8b5cf6;
    }

    /* ========== FULL SCREEN LAYOUT ========== */
    .menu-form-wrapper {
        min-height: 100vh;
        padding: 0;
        margin: 0;
        animation: fadeInPage 0.6s ease-out;
        background: var(--section-bg);
        transition: background 0.3s ease;
    }

    @keyframes fadeInPage {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .menu-form-container {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    /* ========== MODERN CARD ========== */
    .modern-card {
        background: var(--card-bg);
        border-radius: 0;
        box-shadow: none;
        border: none;
        overflow: hidden;
        transition: background 0.3s ease;
    }

    /* ========== ANIMATED HEADER ========== */
    .card-header-gradient {
        background: var(--gradient-primary);
        padding: 2rem 2.5rem;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .card-header-gradient::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: moveBackground 20s linear infinite;
    }

    @keyframes moveBackground {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }

    .header-icon {
        width: 65px;
        height: 65px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        animation: float 3s ease-in-out infinite;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
    }

    .header-text h6 {
        color: white;
        font-size: 1.8rem;
        margin: 0;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .header-text p {
        color: rgba(255, 255, 255, 0.95);
        margin: 0.5rem 0 0 0;
        font-size: 1rem;
    }

    .breadcrumb-custom {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.7rem 1.5rem;
        border-radius: 30px;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        color: white;
        font-size: 0.95rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .breadcrumb-custom i {
        font-size: 0.85rem;
    }

    /* ========== FORM CONTENT GRID ========== */
    .form-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        padding: 3rem 2.5rem;
        background: var(--section-bg);
        transition: background 0.3s ease;
    }

    /* ========== LEFT & RIGHT SECTIONS ========== */
    .form-section-left {
        animation: slideInLeft 0.7s ease-out;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-40px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .form-section-right {
        animation: slideInRight 0.7s ease-out;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(40px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* ========== SECTION HEADERS ========== */
    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1.2rem;
        border-bottom: 3px solid var(--border-color);
        position: relative;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 80px;
        height: 3px;
        background: var(--gradient-primary);
        animation: expandWidth 1s ease-out;
    }

    @keyframes expandWidth {
        from { width: 0; }
        to { width: 80px; }
    }

    .section-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-info);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.4rem;
        box-shadow: 0 6px 18px rgba(102, 126, 234, 0.3);
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        transition: color 0.3s ease;
    }

    /* ========== FORM GROUPS ========== */
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .modern-label {
        font-weight: 600;
        color: var(--label-color);
        font-size: 1rem;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: color 0.3s ease;
    }

    .modern-label i {
        color: #667eea;
        font-size: 1.1rem;
        transition: transform 0.3s, color 0.3s;
    }

    body.dark-mode .modern-label i,
    body.sidebar-dark-primary .modern-label i,
    [data-theme="dark"] .modern-label i,
    [data-bs-theme="dark"] .modern-label i {
        color: #8b5cf6;
    }

    .form-group:hover .modern-label i {
        transform: scale(1.2) rotate(10deg);
    }

    /* ========== INPUT WRAPPER ========== */
    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 1.15rem;
        z-index: 2;
        transition: all 0.3s;
        pointer-events: none;
    }

    /* ========== INPUTS ========== */
    .modern-input,
    .modern-select,
    .modern-textarea {
        background: var(--input-bg);
        border: 2px solid var(--input-border);
        border-radius: 15px;
        padding: 15px 22px 15px 55px;
        font-size: 1rem;
        color: var(--text-primary);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }

    .modern-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 14 14'%3E%3Cpath fill='%23667eea' d='M7 10L2 5h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 22px center;
    }

    body.dark-mode .modern-select,
    body.sidebar-dark-primary .modern-select,
    [data-theme="dark"] .modern-select,
    [data-bs-theme="dark"] .modern-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 14 14'%3E%3Cpath fill='%238b5cf6' d='M7 10L2 5h10z'/%3E%3C/svg%3E");
    }

    .modern-input:focus,
    .modern-select:focus,
    .modern-textarea:focus {
        border-color: var(--input-focus-border);
        box-shadow: 0 0 0 6px var(--input-focus-shadow);
        transform: translateY(-2px);
        outline: none;
        background: var(--input-bg);
        color: var(--text-primary);
    }

    .modern-input:focus ~ .input-icon,
    .modern-select:focus ~ .input-icon {
        color: var(--input-focus-border);
        transform: translateY(-50%) scale(1.2);
    }

    .modern-textarea {
        resize: vertical;
        min-height: 130px;
        padding: 15px 22px;
    }

    .modern-input::placeholder,
    .modern-textarea::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }

    /* ========== CHARACTER COUNTER ========== */
    .char-counter {
        position: absolute;
        right: 12px;
        bottom: -28px;
        font-size: 0.85rem;
        color: var(--text-secondary);
        transition: color 0.3s;
        font-weight: 500;
    }

    .char-counter.warning {
        color: #f6c23e;
    }

    .char-counter.danger {
        color: #e74a3b;
    }

    /* ========== FILE UPLOAD ZONE ========== */
    .file-upload-zone {
        border: 3px dashed var(--input-border);
        border-radius: 20px;
        padding: 3.5rem 2.5rem;
        text-align: center;
        background: var(--preview-bg);
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .file-upload-zone::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, var(--input-focus-shadow), transparent);
        transition: left 0.6s;
    }

    .file-upload-zone:hover::before {
        left: 100%;
    }

    .file-upload-zone:hover {
        border-color: var(--input-focus-border);
        background: var(--input-bg);
        transform: scale(1.02);
        box-shadow: 0 12px 35px var(--input-focus-shadow);
    }

    .file-upload-zone.dragover {
        border-color: #1cc88a;
        background: rgba(28, 200, 138, 0.08);
        transform: scale(1.05);
    }

    .file-upload-zone input[type="file"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }

    .upload-icon-wrapper {
        width: 110px;
        height: 110px;
        margin: 0 auto 1.8rem;
        background: var(--gradient-info);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        animation: pulse 2.5s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 var(--input-focus-shadow);
        }
        50% {
            box-shadow: 0 0 0 25px rgba(102, 126, 234, 0);
        }
    }

    .upload-icon-wrapper i {
        font-size: 2.8rem;
        color: white;
        animation: bounce 2.5s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-18px); }
    }

    .upload-text h5 {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.7rem;
        font-size: 1.3rem;
        transition: color 0.3s ease;
    }

    .upload-text p {
        color: var(--text-secondary);
        margin: 0;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .upload-formats {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .format-badge {
        background: var(--gradient-primary);
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.35);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ========== IMAGE PREVIEW ========== */
    #imagePreview {
        margin-top: 2.5rem;
        animation: zoomIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.3) rotate(-10deg);
        }
        to {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }
    }

    .preview-container {
        position: relative;
        display: inline-block;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(0,0,0,0.35);
        transition: all 0.4s;
        border: 3px solid var(--border-color);
    }

    .preview-container:hover {
        transform: scale(1.05) rotate(2deg);
        box-shadow: 0 25px 60px rgba(0,0,0,0.45);
    }

    .preview-container img {
        display: block;
        width: 100%;
        max-width: 100%;
        height: auto;
        min-height: 280px;
        object-fit: cover;
    }

    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--overlay-bg);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .preview-container:hover .preview-overlay {
        opacity: 1;
    }

    .preview-badge {
        position: absolute;
        top: 18px;
        right: 18px;
        background: var(--gradient-success);
        color: white;
        padding: 10px 20px;
        border-radius: 28px;
        font-size: 0.9rem;
        font-weight: 700;
        box-shadow: 0 6px 18px rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-info {
        position: absolute;
        bottom: 18px;
        left: 18px;
        right: 18px;
        background: var(--overlay-bg);
        backdrop-filter: blur(12px);
        padding: 14px 18px;
        border-radius: 14px;
        color: white;
        font-size: 0.9rem;
        transform: translateY(100%);
        transition: transform 0.3s;
    }

    .preview-container:hover .preview-info {
        transform: translateY(0);
    }

    .remove-image {
        position: absolute;
        top: 18px;
        left: 18px;
        background: rgba(220, 53, 69, 0.95);
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 18px rgba(220, 53, 69, 0.5);
        z-index: 10;
        font-size: 1.2rem;
    }

    .remove-image:hover {
        background: #dc3545;
        transform: rotate(90deg) scale(1.15);
        box-shadow: 0 10px 25px rgba(220, 53, 69, 0.7);
    }

    /* ========== SETTINGS CARDS ========== */
    .settings-card {
        background: var(--preview-bg);
        border-radius: 18px;
        padding: 1.8rem;
        border: 2px solid var(--border-color);
        transition: all 0.3s;
        margin-bottom: 1.5rem;
    }

    .settings-card:hover {
        border-color: var(--input-focus-border);
        box-shadow: 0 10px 25px var(--input-focus-shadow);
        transform: translateX(8px);
    }

    .custom-switch-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .switch-label-content {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }

    .switch-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        transition: all 0.3s;
        flex-shrink: 0;
    }

    .settings-card:hover .switch-icon {
        transform: rotate(360deg);
    }

    .switch-text h6 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        transition: color 0.3s ease;
    }

    .switch-text p {
        margin: 0.3rem 0 0 0;
        font-size: 0.9rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        background: var(--gradient-success);
        border-color: #1cc88a;
    }

    .custom-switch .custom-control-label::before {
        border-radius: 50px;
        width: 3.8rem;
        height: 1.9rem;
        transition: all 0.3s;
        background: var(--input-border);
    }

    .custom-switch .custom-control-label::after {
        width: 1.4rem;
        height: 1.4rem;
        border-radius: 50%;
        transition: all 0.3s;
        background: white;
    }

    .custom-switch .custom-control-input:checked ~ .custom-control-label::after {
        transform: translateX(1.9rem);
    }

    /* ========== ACTION BUTTONS ========== */
    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2.5rem;
        margin-top: 2.5rem;
        border-top: 3px solid var(--border-color);
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 16px 40px;
        border-radius: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 1rem;
        cursor: pointer;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.35);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-modern:hover::before {
        width: 450px;
        height: 450px;
    }

    .btn-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.35);
    }

    .btn-modern:active {
        transform: translateY(-2px);
    }

    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
    }

    .btn-save {
        background: var(--gradient-success);
        color: white;
        box-shadow: 0 10px 25px rgba(28, 200, 138, 0.45);
    }

    .btn-save:hover {
        box-shadow: 0 15px 35px rgba(28, 200, 138, 0.55);
    }

    /* ========== LOADING STATE ========== */
    .btn-modern.loading {
        pointer-events: none;
        opacity: 0.75;
    }

    .btn-modern.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.75s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ========== ALERT STYLING ========== */
    .alert {
        animation: slideDown 0.6s ease-out;
        border-radius: 18px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        padding: 1.8rem;
        margin: 2.5rem 2.5rem 0 2.5rem;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-35px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
        color: white;
    }

    .alert ul {
        list-style: none;
        padding-left: 2rem;
        margin-bottom: 0;
    }

    .alert ul li::before {
        content: '⚠';
        margin-right: 12px;
        font-size: 1.1rem;
    }

    /* ========== REQUIRED ASTERISK ========== */
    .required-asterisk {
        color: #e74a3b;
        margin-left: 5px;
        font-size: 1.2rem;
        animation: pulseAsterisk 2.5s infinite;
    }

    @keyframes pulseAsterisk {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* ========== TIPS BOX ========== */
    .tips-box {
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--tips-bg);
        border-radius: 15px;
        border-left: 5px solid var(--tips-border);
        transition: all 0.3s ease;
    }

    .tips-box h6 {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: color 0.3s ease;
    }

    .tips-box ul {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
        padding-left: 1.8rem;
        line-height: 1.8;
    }

    .tips-box ul li {
        transition: color 0.3s ease;
    }

    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 1200px) {
        .form-content {
            grid-template-columns: 1fr;
            gap: 2.5rem;
            padding: 2.5rem 2rem;
        }
    }

    @media (max-width: 768px) {
        .menu-form-wrapper {
            padding: 0;
        }

        .form-content {
            padding: 2rem 1.5rem;
            gap: 2rem;
        }

        .card-header-gradient {
            padding: 1.5rem 1.5rem;
        }

        .header-icon {
            width: 55px;
            height: 55px;
            font-size: 1.6rem;
        }

        .header-text h6 {
            font-size: 1.4rem;
        }

        .header-text p {
            font-size: 0.9rem;
        }

        .breadcrumb-custom {
            width: 100%;
            justify-content: center;
            font-size: 0.85rem;
        }

        .section-icon {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .btn-modern {
            padding: 14px 30px;
            font-size: 0.9rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn-modern {
            width: 100%;
            justify-content: center;
        }

        .alert {
            margin: 1.5rem 1.5rem 0 1.5rem;
            padding: 1.3rem;
        }
    }

    /* ========== SCROLLBAR STYLING ========== */
    ::-webkit-scrollbar {
        width: 12px;
        height: 12px;
    }

    ::-webkit-scrollbar-track {
        background: var(--preview-bg);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--gradient-primary);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--gradient-info);
    }
</style>
@endpush

@section('content')
<div class="menu-form-wrapper">
    <div class="menu-form-container">
        <div class="modern-card">
            <!-- Animated Header -->
            <div class="card-header-gradient">
                <div class="header-content">
                    <div class="header-title">
                        <div class="header-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="header-text">
                            <h6>Create New Menu Item</h6>
                            <p>Add a delicious item to your restaurant menu</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Oops! Please fix the following errors:</strong>
                <ul class="mt-2">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form Content -->
            <form method="POST"
                  action="{{ route('admin.menu.store') }}"
                  enctype="multipart/form-data"
                  id="menuForm">
                @csrf

                <div class="form-content">
                    <!-- LEFT SECTION: Basic Information -->
                    <div class="form-section-left">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h5 class="section-title">Basic Information</h5>
                        </div>

                        <!-- Item Name -->
                        <div class="form-group">
                            <label class="modern-label">
                                <i class="fas fa-signature"></i>
                                Item Name
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fas fa-pencil-alt input-icon"></i>
                                <input type="text" 
                                       name="name"
                                       class="modern-input"
                                       value="{{ old('name') }}"
                                       placeholder="e.g., Grilled Chicken Supreme"
                                       maxlength="100"
                                       required>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label class="modern-label">
                                <i class="fas fa-th-large"></i>
                                Category
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fas fa-layer-group input-icon"></i>
                                <select name="category_id"
                                        class="modern-select" 
                                        required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label class="modern-label">
                                <i class="fas fa-rupee-sign"></i>
                                Price (Rs.)
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fas fa-dollar-sign input-icon"></i>
                                <input type="number" 
                                       name="price"
                                       class="modern-input"
                                       value="{{ old('price') }}"
                                       placeholder="e.g., 450.00"
                                       step="0.01" 
                                       min="0" 
                                       required>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label class="modern-label">
                                <i class="fas fa-align-left"></i>
                                Description
                            </label>
                            <textarea name="description" 
                                      class="modern-textarea"
                                      placeholder="Describe the dish ingredients, taste, and special features..."
                                      maxlength="500"
                                      id="descriptionArea">{{ old('description') }}</textarea>
                            <span class="char-counter" id="charCounter">0 / 500</span>
                        </div>

                        <!-- Settings -->
                        <div class="section-header mt-5">
                            <div class="section-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <h5 class="section-title">Settings</h5>
                        </div>

                        <!-- Availability -->
                        <div class="settings-card">
                            <div class="custom-switch-modern">
                                <div class="switch-label-content">
                                    <div class="switch-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="switch-text">
                                        <h6>Available on Menu</h6>
                                        <p>Customers can order this item</p>
                                    </div>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" 
                                           name="is_available"
                                           class="custom-control-input"
                                           id="is_available" 
                                           value="1" 
                                           checked>
                                    <label class="custom-control-label" for="is_available"></label>
                                </div>
                            </div>
                        </div>

                        <!-- Featured -->
                        <div class="settings-card">
                            <div class="custom-switch-modern">
                                <div class="switch-label-content">
                                    <div class="switch-icon" style="background: var(--gradient-warning);">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="switch-text">
                                        <h6>Featured on Homepage</h6>
                                        <p>Showcase this item prominently</p>
                                    </div>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" 
                                           name="is_featured"
                                           class="custom-control-input"
                                           id="is_featured" 
                                           value="1">
                                    <label class="custom-control-label" for="is_featured"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SECTION: Image Upload -->
                    <div class="form-section-right">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            <h5 class="section-title">Menu Item Image</h5>
                        </div>

                        <!-- File Upload Zone -->
                        <div class="file-upload-zone" id="uploadZone">
                            <input type="file" 
                                   name="image"
                                   accept="image/*"
                                   id="imageInput">
                            <div class="upload-icon-wrapper">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">
                                <h5>Drag & Drop or Click to Upload</h5>
                                <p>Upload a high-quality image of your menu item</p>
                            </div>
                            <div class="upload-formats">
                                <span class="format-badge">JPG</span>
                                <span class="format-badge">PNG</span>
                                <span class="format-badge">WEBP</span>
                                <span class="format-badge">Max 2MB</span>
                            </div>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview"></div>

                        <!-- Upload Tips -->
                        <div class="tips-box">
                            <h6>
                                <i class="fas fa-lightbulb text-warning"></i>
                                Image Tips
                            </h6>
                            <ul>
                                <li>Use high-resolution images (min 800x800px)</li>
                                <li>Show the dish from an appetizing angle</li>
                                <li>Ensure good lighting and focus</li>
                                <li>Avoid watermarks or text overlays</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <a href="{{ route('admin.menu.index') }}"
                           class="btn btn-modern btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Back to Menu
                        </a>
                        <button type="submit" class="btn btn-modern btn-save" id="submitBtn">
                            <i class="fas fa-save"></i>
                            Save Menu Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ========== CHARACTER COUNTER ==========
const descriptionArea = document.getElementById('descriptionArea');
const charCounter = document.getElementById('charCounter');

if (descriptionArea && charCounter) {
    descriptionArea.addEventListener('input', function() {
        const length = this.value.length;
        const maxLength = 500;
        charCounter.textContent = `${length} / ${maxLength}`;
        
        if (length > maxLength * 0.9) {
            charCounter.classList.add('danger');
            charCounter.classList.remove('warning');
        } else if (length > maxLength * 0.7) {
            charCounter.classList.add('warning');
            charCounter.classList.remove('danger');
        } else {
            charCounter.classList.remove('warning', 'danger');
        }
    });
}

// ========== DRAG & DROP IMAGE UPLOAD ==========
const uploadZone = document.getElementById('uploadZone');
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadZone.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Highlight drop zone
['dragenter', 'dragover'].forEach(eventName => {
    uploadZone.addEventListener(eventName, () => {
        uploadZone.classList.add('dragover');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadZone.addEventListener(eventName, () => {
        uploadZone.classList.remove('dragover');
    }, false);
});

// Handle dropped files
uploadZone.addEventListener('drop', function(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length) {
        imageInput.files = files;
        handleImagePreview(files[0]);
    }
}, false);

// Handle file input change
imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        handleImagePreview(file);
    }
});

// ========== IMAGE PREVIEW HANDLER ==========
function handleImagePreview(file) {
    // File type validation
    if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file (JPG, PNG, WEBP)');
        imageInput.value = '';
        return;
    }
    
    // File size validation (2MB)
    if (file.size > 2048000) {
        alert('Image size must be less than 2MB');
        imageInput.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const fileSize = (file.size / 1024).toFixed(2);
        imagePreview.innerHTML = `
            <div class="preview-container">
                <button type="button" class="remove-image" onclick="removeImage()">
                    <i class="fas fa-times"></i>
                </button>
                <img src="${e.target.result}" alt="Preview">
                <div class="preview-overlay"></div>
                <span class="preview-badge">
                    <i class="fas fa-check"></i> Preview
                </span>
                <div class="preview-info">
                    <div><i class="fas fa-file-image mr-2"></i>${file.name}</div>
                    <div><i class="fas fa-database mr-2"></i>${fileSize} KB</div>
                </div>
            </div>
        `;
        
        // Hide upload zone
        uploadZone.style.display = 'none';
    }
    reader.readAsDataURL(file);
}

// ========== REMOVE IMAGE ==========
function removeImage() {
    imageInput.value = '';
    imagePreview.innerHTML = '';
    uploadZone.style.display = 'block';
}

// ========== FORM SUBMIT WITH LOADING ==========
document.getElementById('menuForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<span style="visibility:hidden;">Saving...</span>';
    submitBtn.disabled = true;
});

// ========== INPUT ANIMATION ON FOCUS ==========
document.querySelectorAll('.modern-input, .modern-select, .modern-textarea').forEach(input => {
    input.addEventListener('focus', function() {
        const formGroup = this.closest('.form-group');
        if (formGroup) {
            formGroup.classList.add('focused');
        }
    });
    
    input.addEventListener('blur', function() {
        const formGroup = this.closest('.form-group');
        if (formGroup) {
            formGroup.classList.remove('focused');
        }
    });
});
</script>
@endpush