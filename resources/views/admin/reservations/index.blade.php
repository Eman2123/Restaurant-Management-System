@extends('layouts.admin')
@section('title', 'Reservations')
@section('page-title', 'All Reservations')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    /* ========== LIGHT THEME ========== */
    .reservations-wrapper {
        --card-bg:          #ffffff;
        --card-shadow:      0 2px 12px rgba(0,0,0,0.06);
        --card-hover-shadow:0 12px 40px rgba(0,0,0,0.13);
        --text-primary:     #1a2535;
        --text-secondary:   #4a5568;
        --text-muted:       #94a3b8;
        --section-bg:       #f4f6f9;
        --border-color:     rgba(0,0,0,0.08);
        --table-hover:      #f8fafc;
        --font-main:        'DM Sans', sans-serif;
        --font-mono:        'DM Mono', monospace;
        --c-success:        #059669;
        --c-success-soft:   rgba(5,150,105,0.12);
        --c-warning:        #d97706;
        --c-warning-soft:   rgba(217,119,6,0.12);
        --c-info:           #0891b2;
        --c-info-soft:      rgba(8,145,178,0.12);
        --c-danger:         #dc2626;
        --c-danger-soft:    rgba(220,38,38,0.12);
        --c-purple:         #7c3aed;
        --c-purple-soft:    rgba(124,58,237,0.12);
        --c-pink:           #db2777;
        --c-pink-soft:      rgba(219,39,119,0.12);
        --c-accent:         #2563eb;
        --c-accent-soft:    rgba(37,99,235,0.12);
        --header-grad:      linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    }

    /* ========== DARK THEME ========== */
    body.dark-mode .reservations-wrapper,
    body.sidebar-dark-primary .reservations-wrapper,
    [data-theme="dark"] .reservations-wrapper,
    [data-bs-theme="dark"] .reservations-wrapper {
        --card-bg:          #1e2733;
        --card-shadow:      0 2px 12px rgba(0,0,0,0.4);
        --card-hover-shadow:0 12px 40px rgba(0,0,0,0.6);
        --text-primary:     #e4eef8;
        --text-secondary:   #7a9ab8;
        --text-muted:       #4a6278;
        --section-bg:       #141A21;
        --border-color:     rgba(255,255,255,0.07);
        --table-hover:      #243040;
        --c-success:        #10d97f;
        --c-success-soft:   rgba(16,217,127,0.13);
        --c-warning:        #fbbf24;
        --c-warning-soft:   rgba(251,191,36,0.13);
        --c-info:           #22d3ee;
        --c-info-soft:      rgba(34,211,238,0.13);
        --c-danger:         #f87171;
        --c-danger-soft:    rgba(248,113,113,0.13);
        --c-purple:         #a78bfa;
        --c-purple-soft:    rgba(167,139,250,0.13);
        --c-pink:           #f472b6;
        --c-pink-soft:      rgba(244,114,182,0.13);
        --c-accent:         #4d84ff;
        --c-accent-soft:    rgba(77,132,255,0.14);
    }

    /* ========== BASE ========== */
    .reservations-wrapper * { box-sizing: border-box; font-family: var(--font-main); }
    .reservations-wrapper { background: transparent; padding: 0; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    /* ========== PAGE HEADER ========== */
    .res-header {
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
    .res-header::before {
        content:'';
        position:absolute; top:-120px; right:-80px;
        width:360px; height:360px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 18s ease-in-out infinite;
    }
    .res-header::after {
        content:'';
        position:absolute; bottom:-120px; left:-60px;
        width:300px; height:300px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,0.10) 0%, transparent 70%);
        animation: float2 14s ease-in-out infinite;
    }
    @keyframes float1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,20px);} }
    @keyframes float2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-20px,-20px);} }

    .res-header-inner {
        position: relative; z-index: 2;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .res-header-left { display:flex; align-items:center; gap:1.2rem; }
    .res-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.25);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .res-header h1 {
        color: white; font-size: 1.9rem; font-weight: 800;
        margin: 0; letter-spacing: -0.5px;
    }
    .res-header p {
        color: rgba(255,255,255,0.88); font-size: 0.92rem;
        margin: 3px 0 0; font-weight: 500;
    }
    .export-btn {
        background: white; color: #ff6b6b;
        padding: 11px 24px; border-radius: 12px;
        font-weight: 700; font-size: 0.88rem;
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        transition: all 0.25s; text-transform: uppercase; letter-spacing: 0.5px;
        position: relative;
    }
    .export-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.25); }
    body.dark-mode .export-btn { background: rgba(255,255,255,0.18); color: white; }
    [data-bs-theme="dark"] .export-btn { background: rgba(255,255,255,0.18); color: white; }

    .dropdown-menu-custom {
        background: var(--card-bg);
        border-radius: 14px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.2);
        border: 1px solid var(--border-color);
        padding: 0.6rem; min-width: 200px;
    }
    .dropdown-item-custom {
        padding: 11px 16px; border-radius: 10px;
        color: var(--text-primary); font-weight: 600;
        display: flex; align-items: center; gap: 10px;
        transition: all 0.2s; font-size: 0.9rem;
        text-decoration: none;
    }
    .dropdown-item-custom:hover { background: var(--section-bg); transform: translateX(4px); }

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
        position: relative;
        overflow: hidden;
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

    /* Top accent line */
    .stat-card::before {
        content:''; position:absolute;
        top:0; left:0; right:0; height:3px; border-radius:18px 18px 0 0;
    }
    .stat-card.success::before { background: var(--c-success); }
    .stat-card.warning::before { background: var(--c-warning); }
    .stat-card.info::before    { background: var(--c-info); }
    .stat-card.danger::before  { background: var(--c-danger); }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    /* ── Stat card inner layout ── */
    .stat-head {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
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
    .stat-card.success .stat-icon-pill { background: var(--c-success-soft); color: var(--c-success); }
    .stat-card.warning .stat-icon-pill { background: var(--c-warning-soft); color: var(--c-warning); }
    .stat-card.info    .stat-icon-pill { background: var(--c-info-soft);    color: var(--c-info); }
    .stat-card.danger  .stat-icon-pill { background: var(--c-danger-soft);  color: var(--c-danger); }

    .stat-value {
        font-size: 2.6rem; font-weight: 800;
        line-height: 1; margin-bottom: 0.35rem;
        font-family: var(--font-mono);
    }
    .stat-card.success .stat-value { color: var(--c-success); }
    .stat-card.warning .stat-value { color: var(--c-warning); }
    .stat-card.info    .stat-value { color: var(--c-info); }
    .stat-card.danger  .stat-value { color: var(--c-danger); }

    .stat-sub {
        font-size: 0.78rem; font-weight: 600;
        display: flex; align-items: center; gap: 5px;
    }
    .stat-card.success .stat-sub { color: var(--c-success); }
    .stat-card.warning .stat-sub { color: var(--c-warning); }
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
    .modern-table thead {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    }
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

    /* Row number */
    .row-number {
        width: 32px; height: 32px; border-radius: 10px;
        background: var(--c-purple-soft); color: var(--c-purple);
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem;
        font-family: var(--font-mono);
    }

    /* Guest info */
    .guest-info { display:flex; align-items:center; gap:12px; }
    .guest-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: var(--c-pink-soft); color: var(--c-pink);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem; flex-shrink: 0;
        border: 2px solid var(--c-pink-soft);
    }
    .guest-name { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); }
    .guest-email {
        color: var(--text-muted); font-size: 0.78rem;
        display: flex; align-items: center; gap: 4px; margin-top: 2px;
    }

    /* Inline badges */
    .info-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 10px;
        font-weight: 600; font-size: 0.82rem;
        border: 1px solid; white-space: nowrap;
    }
    .badge-phone   { background:var(--c-danger-soft);  color:var(--c-danger);  border-color:var(--c-danger-soft); }
    .badge-table   { background:var(--c-accent-soft);  color:var(--c-accent);  border-color:var(--c-accent-soft); font-family:var(--font-mono); }
    .badge-date    { background:var(--c-success-soft); color:var(--c-success); border-color:var(--c-success-soft); }
    .badge-time    { background:var(--c-info-soft);    color:var(--c-info);    border-color:var(--c-info-soft); font-family:var(--font-mono); }
    .badge-guests  { background:var(--c-purple-soft);  color:var(--c-purple);  border-color:var(--c-purple-soft); font-family:var(--font-mono); }

    /* Status */
    .status-badge {
        padding: 5px 14px; border-radius: 20px;
        font-weight: 700; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.06em;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .status-dot { width:6px; height:6px; border-radius:50%; }
    .status-badge.confirmed { background:var(--c-success-soft); color:var(--c-success); }
    .status-badge.confirmed .status-dot { background:var(--c-success); }
    .status-badge.pending   { background:var(--c-warning-soft); color:var(--c-warning); animation: pendingPulse 2s infinite; }
    .status-badge.pending   .status-dot { background:var(--c-warning); animation: dotPulse 1.4s infinite; }
    .status-badge.completed { background:var(--c-info-soft);    color:var(--c-info); }
    .status-badge.completed .status-dot { background:var(--c-info); }
    .status-badge.cancelled { background:var(--c-danger-soft);  color:var(--c-danger); }
    .status-badge.cancelled .status-dot { background:var(--c-danger); }
    @keyframes pendingPulse { 0%,100%{opacity:1;} 50%{opacity:0.75;} }
    @keyframes dotPulse { 0%,100%{transform:scale(1);opacity:1;} 50%{transform:scale(1.6);opacity:0.5;} }

    /* Action buttons */
    .action-buttons { display:flex; gap:6px; }
    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 9px;
        border: 1px solid var(--border-color);
        background: transparent; cursor: pointer;
        color: var(--text-secondary); font-size: 0.8rem;
        transition: all 0.15s; text-decoration: none;
    }
    .action-btn.view:hover   { background:var(--c-info-soft);    color:var(--c-info);    border-color:var(--c-info); }
    .action-btn.delete:hover { background:var(--c-danger-soft);  color:var(--c-danger);  border-color:var(--c-danger); }
    .action-btn:hover { transform: translateY(-2px); }

    /* Empty state */
    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-state i { font-size: 3.5rem; color: var(--text-muted); margin-bottom: 1rem; display:block; }
    .empty-state h3 { color: var(--text-secondary); font-size: 1.1rem; font-weight: 600; }
    .empty-state p  { color: var(--text-muted); font-size: 0.9rem; margin-top: 5px; }

    /* Responsive */
    @media(max-width:768px){
        .res-header { padding:1.5rem; }
        .res-header h1 { font-size:1.5rem; }
        .stats-section { padding: 0 1rem 1rem; }
        .modern-table thead th,
        .modern-table tbody td { padding: 0.75rem 0.8rem; }
    }
</style>
@endpush

@section('content')
<div class="reservations-wrapper">

    {{-- ── Header ── --}}
    <div class="res-header">
        <div class="res-header-inner">
            <div class="res-header-left">
                <div class="res-header-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <h1>Reservations</h1>
                    <p>Manage all table bookings &amp; reservations</p>
                </div>
            </div>
            <div class="dropdown">
                <button class="export-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-file-download"></i>
                    <span>Export Data</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-custom">
                    <li>
                        <a class="dropdown-item dropdown-item-custom"
                           href="{{ route('admin.export.reservations.excel') }}">
                            <i class="fas fa-file-excel" style="color:#10b981;font-size:1.1rem;"></i>
                            Export as Excel
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-custom"
                           href="{{ route('admin.export.reservations.pdf') }}">
                            <i class="fas fa-file-pdf" style="color:#ef4444;font-size:1.1rem;"></i>
                            Export as PDF
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ── Stats + Table ── --}}
    <div class="stats-section">

        {{-- Stats Grid --}}
        <div class="stats-grid">

            <div class="stat-card success">
                <div class="stat-head">
                    <span class="stat-label">Confirmed</span>
                    <span class="stat-icon-pill"><i class="fas fa-check-circle"></i></span>
                </div>
                <div class="stat-value">{{ $reservations->where('status','confirmed')->count() }}</div>
                <div class="stat-sub"><i class="fas fa-arrow-up"></i> Active</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-head">
                    <span class="stat-label">Pending</span>
                    <span class="stat-icon-pill"><i class="fas fa-clock"></i></span>
                </div>
                <div class="stat-value">{{ $reservations->where('status','pending')->count() }}</div>
                <div class="stat-sub"><i class="fas fa-hourglass-half"></i> Waiting</div>
            </div>

            <div class="stat-card info">
                <div class="stat-head">
                    <span class="stat-label">Completed</span>
                    <span class="stat-icon-pill"><i class="fas fa-clipboard-check"></i></span>
                </div>
                <div class="stat-value">{{ $reservations->where('status','completed')->count() }}</div>
                <div class="stat-sub"><i class="fas fa-check"></i> Done</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-head">
                    <span class="stat-label">Cancelled</span>
                    <span class="stat-icon-pill"><i class="fas fa-ban"></i></span>
                </div>
                <div class="stat-value">{{ $reservations->where('status','cancelled')->count() }}</div>
                <div class="stat-sub"><i class="fas fa-times"></i> Declined</div>
            </div>

        </div>

        {{-- Table --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guest</th>
                            <th>Contact</th>
                            <th>Table</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $res)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <div class="guest-info">
                                    <div class="guest-avatar">
                                        {{ strtoupper(substr($res->guest_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="guest-name">{{ $res->guest_name }}</div>
                                        @if($res->user)
                                        <div class="guest-email">
                                            <i class="fas fa-envelope"></i>
                                            {{ $res->user->email }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="info-badge badge-phone">
                                    <i class="fas fa-phone-alt"></i>
                                    {{ $res->guest_phone }}
                                </span>
                            </td>
                            <td>
                                <span class="info-badge badge-table">
                                    <i class="fas fa-chair"></i>
                                    #{{ $res->table->table_number }}
                                </span>
                            </td>
                            <td>
                                <span class="info-badge badge-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="info-badge badge-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $res->reservation_time }}
                                </span>
                            </td>
                            <td>
                                <span class="info-badge badge-guests">
                                    <i class="fas fa-users"></i>
                                    {{ $res->guests_count }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $res->status }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($res->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.reservations.show', $res) }}"
                                       class="action-btn view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('admin.reservations.destroy', $res) }}"
                                          style="display:inline"
                                          onsubmit="return confirm('Delete this reservation?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h3>No reservations found</h3>
                                    <p>No bookings have been made yet</p>
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
@endsection