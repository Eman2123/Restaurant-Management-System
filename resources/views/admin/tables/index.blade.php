@extends('layouts.admin')
@section('title', 'Tables')
@section('page-title', 'Restaurant Tables')

@push('styles')
<style>
    /* ========== THEME VARIABLES ========== */
    .tables-wrapper {
        --card-bg: #ffffff;
        --card-shadow: 0 8px 30px rgba(0,0,0,0.08);
        --card-hover-shadow: 0 20px 50px rgba(0,0,0,0.18);
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --text-muted: #858796;
        --gradient-purple: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --gradient-info: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        --gradient-pink: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        --section-bg: #f8f9fc;
        --border-color: #e3e6f0;
        --table-card-bg: #ffffff;
        --overlay-dark: rgba(0, 0, 0, 0.6);
    }

    /* Dark Theme */
    body.dark-mode .tables-wrapper,
    body.sidebar-dark-primary .tables-wrapper,
    [data-theme="dark"] .tables-wrapper,
    [data-bs-theme="dark"] .tables-wrapper {
        --card-bg: #1e2936;
        --card-shadow: 0 8px 30px rgba(0,0,0,0.6);
        --card-hover-shadow: 0 20px 50px rgba(0,0,0,0.9);
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --gradient-purple: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --gradient-info: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        --gradient-pink: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        --section-bg: #141A21;
        --border-color: #3d4954;
        --table-card-bg: #1a2129;
        --overlay-dark: rgba(10, 13, 18, 0.85);
    }

    .tables-wrapper {
        background: var(--section-bg);
        min-height: 100vh;
        padding: 0;
        margin: 0;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ========== MEGA HEADER ========== */
    .page-header {
        background: var(--gradient-purple);
        padding: 3rem 3rem;
        position: relative;
        overflow: hidden;
        animation: slideDown 0.6s ease-out;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    .page-header::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 15s linear infinite reverse;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .page-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 2rem;
        max-width: 1600px;
        margin: 0 auto;
    }

    .page-title-wrapper {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .page-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-10px) scale(1.05); }
    }

    .page-title {
        color: white;
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.95);
        margin: 0.5rem 0 0 0;
        font-size: 1.1rem;
    }

    .btn-add-table {
        background: white;
        color: #a855f7;
        padding: 16px 40px;
        border-radius: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        transition: all 0.4s;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }

    body.dark-mode .btn-add-table {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        backdrop-filter: blur(10px);
    }

    .btn-add-table:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }

    /* ========== ANIMATED STATS BOXES ========== */
    .stats-section {
        padding: 3rem 3rem 2rem 3rem;
        max-width: 1600px;
        margin: 0 auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-box {
        position: relative;
        padding: 2.5rem 2rem;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        animation: scaleIn 0.6s ease-out backwards;
        cursor: pointer;
    }

    .stat-box:nth-child(1) { animation-delay: 0.1s; }
    .stat-box:nth-child(2) { animation-delay: 0.2s; }
    .stat-box:nth-child(3) { animation-delay: 0.3s; }
    .stat-box:nth-child(4) { animation-delay: 0.4s; }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(30px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .stat-box.total {
        background: var(--gradient-purple);
    }

    .stat-box.available {
        background: var(--gradient-success);
    }

    .stat-box.occupied {
        background: var(--gradient-danger);
    }

    .stat-box.reserved {
        background: var(--gradient-warning);
    }

    .stat-box::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        transition: all 0.8s;
    }

    .stat-box:hover::before {
        transform: scale(1.2) rotate(45deg);
    }

    .stat-box:hover {
        transform: translateY(-15px) scale(1.03);
        box-shadow: 0 25px 60px rgba(0,0,0,0.25);
    }

    .stat-box-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        transition: all 0.3s;
    }

    .stat-box:hover .stat-box-icon {
        transform: rotate(360deg) scale(1.2);
    }

    .stat-box-content {
        position: relative;
        z-index: 2;
    }

    .stat-box-value {
        font-size: 3rem;
        font-weight: 900;
        color: white;
        line-height: 1;
        margin-bottom: 0.5rem;
        text-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .stat-box-label {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-box-trend {
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* ========== CREATIVE TABLE CARDS ========== */
    .tables-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2.5rem;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .table-card {
        position: relative;
        background: var(--table-card-bg);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        animation: scaleIn 0.7s ease-out backwards;
    }

    .table-card:nth-child(1) { animation-delay: 0.1s; }
    .table-card:nth-child(2) { animation-delay: 0.15s; }
    .table-card:nth-child(3) { animation-delay: 0.2s; }
    .table-card:nth-child(4) { animation-delay: 0.25s; }
    .table-card:nth-child(5) { animation-delay: 0.3s; }
    .table-card:nth-child(6) { animation-delay: 0.35s; }

    .table-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        transition: height 0.3s;
    }

    .table-card.available::before { background: var(--gradient-success); }
    .table-card.occupied::before { background: var(--gradient-danger); }
    .table-card.reserved::before { background: var(--gradient-warning); }

    .table-card:hover {
        transform: translateY(-20px) scale(1.03);
        box-shadow: var(--card-hover-shadow);
    }

    .table-card:hover::before {
        height: 100%;
        opacity: 0.05;
    }

    /* Image Section with 3D Effect */
    .table-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .table-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .table-card:hover .table-image {
        transform: scale(1.2) rotate(3deg);
    }

    .table-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.6) 0%, rgba(124, 58, 237, 0.8) 100%);
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .table-card:hover .table-image-overlay {
        opacity: 0.9;
    }

    /* Floating Elements on Image */
    .table-number-floating {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 5rem;
        font-weight: 900;
        color: white;
        text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        z-index: 3;
        transition: all 0.3s;
    }

    .table-card:hover .table-number-floating {
        transform: translate(-50%, -50%) scale(1.2) rotate(-5deg);
    }

    .status-badge-floating {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 3;
        backdrop-filter: blur(20px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .status-badge-floating.available {
        background: rgba(16, 185, 129, 0.95);
        color: white;
        box-shadow: 0 0 30px rgba(16, 185, 129, 0.6);
    }

    .status-badge-floating.occupied {
        background: rgba(239, 68, 68, 0.95);
        color: white;
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.6);
    }

    .status-badge-floating.reserved {
        background: rgba(245, 158, 11, 0.95);
        color: white;
        box-shadow: 0 0 30px rgba(245, 158, 11, 0.6);
    }

    .capacity-badge {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 12px 20px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #a855f7;
        z-index: 3;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    .capacity-badge i {
        font-size: 1.2rem;
    }

    /* Card Body with Cool Design */
    .table-card-body {
        padding: 2rem;
        background: var(--table-card-bg);
    }

    .info-boxes {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-box {
        padding: 1.2rem;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.1) 0%, rgba(124, 58, 237, 0.05) 100%);
        border: 2px solid transparent;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .info-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(168, 85, 247, 0.2), transparent);
        transition: left 0.5s;
    }

    .info-box:hover::before {
        left: 100%;
    }

    .info-box:hover {
        border-color: #a855f7;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(168, 85, 247, 0.2);
    }

    .info-box-icon {
        width: 45px;
        height: 45px;
        background: var(--gradient-purple);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-bottom: 0.8rem;
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
    }

    .info-box-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.3rem;
    }

    .info-box-value {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    .timeline-box {
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--section-bg) 0%, var(--table-card-bg) 100%);
        border-radius: 16px;
        border: 2px dashed var(--border-color);
        margin-bottom: 1.5rem;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.8rem 0;
    }

    .timeline-item:not(:last-child) {
        border-bottom: 1px solid var(--border-color);
    }

    .timeline-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--gradient-purple);
        flex-shrink: 0;
        box-shadow: 0 0 15px rgba(168, 85, 247, 0.6);
        animation: glow 2s infinite;
    }

    @keyframes glow {
        0%, 100% { box-shadow: 0 0 15px rgba(168, 85, 247, 0.6); }
        50% { box-shadow: 0 0 25px rgba(168, 85, 247, 1); }
    }

    .timeline-text {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .timeline-text strong {
        color: var(--text-primary);
        font-weight: 700;
    }

    /* Action Buttons - Glassmorphism */
    .table-card-footer {
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.05) 0%, transparent 100%);
        backdrop-filter: blur(10px);
        border-top: 2px solid var(--border-color);
        display: flex;
        gap: 12px;
    }

    .action-btn {
        flex: 1;
        padding: 14px 0;
        border-radius: 14px;
        font-weight: 800;
        font-size: 0.9rem;
        border: none;
        transition: all 0.4s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: white;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .action-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .action-btn.edit {
        background: var(--gradient-warning);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }

    .action-btn.edit:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.5);
    }

    .action-btn.delete {
        background: var(--gradient-danger);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .action-btn.delete:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.5);
    }

    /* QR Button Style (New) */
    .action-btn.qr {
        background: var(--gradient-info);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
    }

    .action-btn.qr:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(6, 182, 212, 0.5);
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        grid-column: 1 / -1;
        background: var(--card-bg);
        border-radius: 28px;
        padding: 6rem 3rem;
        text-align: center;
        box-shadow: var(--card-shadow);
        border: 3px dashed var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .empty-state::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.05) 0%, transparent 70%);
        animation: rotate 30s linear infinite;
    }

    .empty-icon {
        font-size: 7rem;
        background: var(--gradient-purple);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 2rem;
        animation: bounce 2s infinite;
        display: inline-block;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-30px); }
    }

    .empty-text {
        color: var(--text-primary);
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .empty-subtext {
        color: var(--text-muted);
        font-size: 1.2rem;
        margin-bottom: 2.5rem;
    }

    .empty-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: var(--gradient-purple);
        color: white;
        padding: 18px 45px;
        border-radius: 16px;
        font-weight: 800;
        text-decoration: none;
        font-size: 1.1rem;
        transition: all 0.3s;
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.4);
        position: relative;
        z-index: 2;
    }

    .empty-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(168, 85, 247, 0.5);
        color: white;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .page-header {
            padding: 2rem 1.5rem;
        }

        .stats-section {
            padding: 2rem 1.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-box {
            padding: 1.5rem 1rem;
        }

        .stat-box-value {
            font-size: 2rem;
        }

        .tables-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .table-number-floating {
            font-size: 3.5rem;
        }

        .info-boxes {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="tables-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-wrapper">
                <div class="page-icon">
                    <i class="fas fa-chair"></i>
                </div>
                <div>
                    <h1 class="page-title">Restaurant Tables</h1>
                    <p class="page-subtitle">Manage your dining area seating</p>
                </div>
            </div>
            <a href="{{ route('admin.tables.create') }}" class="btn-add-table">
                <i class="fas fa-plus"></i>
                <span>Add New Table</span>
            </a>
        </div>
    </div>

    <!-- Stats & Tables Section -->
    <div class="stats-section">
        <!-- Animated Stats Boxes -->
        <div class="stats-grid">
            <div class="stat-box total">
                <div class="stat-box-icon">
                    <i class="fas fa-chair"></i>
                </div>
                <div class="stat-box-content">
                    <div class="stat-box-value">{{ $tables->count() }}</div>
                    <div class="stat-box-label">Total Tables</div>
                    <div class="stat-box-trend">
                        <i class="fas fa-chart-line"></i>
                        <span>Active System</span>
                    </div>
                </div>
            </div>

            <div class="stat-box available">
                <div class="stat-box-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-box-content">
                    <div class="stat-box-value">{{ $tables->where('status', 'available')->count() }}</div>
                    <div class="stat-box-label">Available Now</div>
                    <div class="stat-box-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ round(($tables->where('status', 'available')->count() / max($tables->count(), 1)) * 100) }}% Ready</span>
                    </div>
                </div>
            </div>

            <div class="stat-box occupied">
                <div class="stat-box-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="stat-box-content">
                    <div class="stat-box-value">{{ $tables->where('status', 'occupied')->count() }}</div>
                    <div class="stat-box-label">Occupied</div>
                    <div class="stat-box-trend">
                        <i class="fas fa-users"></i>
                        <span>In Service</span>
                    </div>
                </div>
            </div>

            <div class="stat-box reserved">
                <div class="stat-box-icon">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div class="stat-box-content">
                    <div class="stat-box-value">{{ $tables->where('status', 'reserved')->count() }}</div>
                    <div class="stat-box-label">Reserved</div>
                    <div class="stat-box-trend">
                        <i class="fas fa-calendar-check"></i>
                        <span>Pre-booked</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Creative Table Cards -->
        <div class="tables-grid">
            @forelse($tables as $table)
            <div class="table-card {{ $table->status }}">
                <!-- 3D Image Section -->
                <div class="table-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop" 
                         alt="Table {{ $table->table_number }}" 
                         class="table-image">
                    <div class="table-image-overlay"></div>
                    
                    <div class="table-number-floating">
                        #{{ $table->table_number }}
                    </div>
                    
                    <span class="status-badge-floating {{ $table->status }}">
                        <i class="fas fa-{{ $table->status === 'available' ? 'check' : ($table->status === 'occupied' ? 'user' : 'bookmark') }}"></i>
                        {{ ucfirst($table->status) }}
                    </span>
                    
                    <div class="capacity-badge">
                        <i class="fas fa-users"></i>
                        <span>{{ $table->capacity }} Seats</span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="table-card-body">
                    <!-- Info Boxes -->
                    <div class="info-boxes">
                        <div class="info-box">
                            <div class="info-box-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="info-box-label">Total Orders</div>
                            <div class="info-box-value">{{ $table->orders_count }}</div>
                        </div>
                        <div class="info-box">
                            <div class="info-box-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="info-box-label">Rating</div>
                            <div class="info-box-value">4.8★</div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline-box">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-text">
                                Added <strong>{{ $table->created_at->diffForHumans() }}</strong>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-text">
                                Updated <strong>{{ $table->updated_at->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="table-card-footer">
                    <!-- ADDED QR BUTTON HERE -->
                    <a href="{{ route('admin.tables.qrcode', $table) }}" class="action-btn qr">
                        <i class="fas fa-qrcode"></i>
                        <span>QR</span>
                    </a>
                    <!-- END ADDED BUTTON -->

                    <a href="{{ route('admin.tables.edit', $table) }}" class="action-btn edit">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                    <form method="POST"
                          action="{{ route('admin.tables.destroy', $table) }}"
                          style="flex: 1;"
                          onsubmit="return confirm('Delete Table #{{ $table->table_number }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete" style="width: 100%;">
                            <i class="fas fa-trash-alt"></i>
                            <span>Delete</span>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-chair"></i>
                </div>
                <div class="empty-text">No Tables Available</div>
                <div class="empty-subtext">Start managing your restaurant seating</div>
                <a href="{{ route('admin.tables.create') }}" class="empty-link">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Your First Table</span>
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection