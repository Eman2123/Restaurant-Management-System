@extends('layouts.admin')
@section('title', 'Reservation Details')
@section('page-title', 'Reservation Details')

@push('styles')
<style>
    /* ========== THEME VARIABLES ========== */
    .reservation-details-wrapper {
        --card-bg: #ffffff;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.15);
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --text-muted: #858796;
        --gradient-blue: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --gradient-purple: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        --gradient-pink: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        --section-bg: #f8f9fc;
        --border-color: #e3e6f0;
        --info-bg: #e0f2fe;
    }

    /* Dark Theme */
    body.dark-mode .reservation-details-wrapper,
    body.sidebar-dark-primary .reservation-details-wrapper,
    [data-theme="dark"] .reservation-details-wrapper,
    [data-bs-theme="dark"] .reservation-details-wrapper {
        --card-bg: #1e2936;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.6);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.9);
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --gradient-blue: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --gradient-purple: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);
        --gradient-pink: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        --section-bg: #141A21;
        --border-color: #3d4954;
        --info-bg: #1e3a5f;
    }

    .reservation-details-wrapper {
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

    /* ========== HEADER ========== */
    .page-header {
        background: var(--gradient-blue);
        padding: 3rem 3rem;
        position: relative;
        overflow: hidden;
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header::before,
    .page-header::after {
        content: '';
        position: absolute;
        border-radius: 50%;
    }

    .page-header::before {
        width: 400px;
        height: 400px;
        top: -150px;
        right: -100px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        animation: float1 15s ease-in-out infinite;
    }

    .page-header::after {
        width: 300px;
        height: 300px;
        bottom: -100px;
        left: -50px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float2 20s ease-in-out infinite;
    }

    @keyframes float1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(30px, 30px) rotate(180deg); }
    }

    @keyframes float2 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-30px, -30px) rotate(-180deg); }
    }

    .page-header-content {
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

    .header-left {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .page-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
        animation: pulse 3s ease-in-out infinite;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .page-title {
        color: white;
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0;
        text-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.95);
        margin: 0.5rem 0 0 0;
        font-size: 1.1rem;
    }

    .reservation-id {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        padding: 10px 24px;
        border-radius: 30px;
        color: white;
        font-weight: 800;
        font-size: 1.1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    /* ========== CONTENT SECTION ========== */
    .content-section {
        padding: 3rem 3rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ========== DETAILS CARD ========== */
    .details-card {
        background: var(--card-bg);
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 2px solid var(--border-color);
        animation: scaleIn 0.6s ease-out;
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(30px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .details-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-5px);
        transition: all 0.3s;
    }

    .card-header-custom {
        background: var(--gradient-blue);
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .card-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .status-badge-large {
        padding: 12px 28px;
        border-radius: 30px;
        font-weight: 900;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        animation: pulse 2s infinite;
    }

    .status-badge-large.confirmed {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .status-badge-large.pending {
        background: rgba(245, 158, 11, 0.95);
        color: white;
    }

    .status-badge-large.completed {
        background: rgba(6, 182, 212, 0.95);
        color: white;
    }

    .status-badge-large.cancelled {
        background: rgba(239, 68, 68, 0.95);
        color: white;
    }

    .card-body-custom {
        padding: 2.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }

    /* ========== INFO BOXES ========== */
    .info-section {
        animation: slideIn 0.6s ease-out backwards;
    }

    .info-section:nth-child(1) { animation-delay: 0.1s; }
    .info-section:nth-child(2) { animation-delay: 0.2s; }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .section-title {
        font-size: 1.1rem;
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

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-blue);
    }

    .section-title i {
        font-size: 1.3rem;
        color: #3b82f6;
    }

    .info-item {
        display: flex;
        align-items: start;
        gap: 1.5rem;
        padding: 1.2rem;
        margin-bottom: 1rem;
        background: var(--section-bg);
        border-radius: 16px;
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .info-item:hover {
        background: var(--card-bg);
        border-color: var(--border-color);
        transform: translateX(8px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .info-item:nth-child(1) .info-icon { background: var(--gradient-purple); }
    .info-item:nth-child(2) .info-icon { background: var(--gradient-pink); }
    .info-item:nth-child(3) .info-icon { background: var(--gradient-success); }
    .info-item:nth-child(4) .info-icon { background: var(--gradient-warning); }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    /* ========== NOTES BOX ========== */
    .notes-box {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        border-left: 5px solid #3b82f6;
        padding: 1.8rem;
        border-radius: 16px;
        margin-top: 2rem;
        animation: fadeInUp 0.6s ease-out 0.3s backwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notes-title {
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1rem;
    }

    .notes-title i {
        color: #3b82f6;
        font-size: 1.3rem;
    }

    .notes-content {
        color: var(--text-secondary);
        line-height: 1.7;
        font-size: 1rem;
    }

    /* ========== UPDATE STATUS CARD ========== */
    .update-card {
        background: var(--card-bg);
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 2px solid var(--border-color);
        animation: scaleIn 0.6s ease-out 0.2s backwards;
    }

    .update-header {
        background: var(--gradient-warning);
        padding: 1.8rem 2rem;
    }

    .update-title {
        color: white;
        font-size: 1.3rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .update-body {
        padding: 2.5rem;
    }

    .status-select {
        background: var(--section-bg);
        border: 2px solid var(--border-color);
        border-radius: 14px;
        padding: 14px 20px;
        font-size: 1rem;
        color: var(--text-primary);
        font-weight: 700;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s;
    }

    .status-select:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        transform: translateY(-2px);
    }

    .btn-update {
        background: var(--gradient-warning);
        color: white;
        border: none;
        padding: 14px 0;
        border-radius: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        font-size: 0.95rem;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-update:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.5);
    }

    /* ========== BACK BUTTON ========== */
    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        border: none;
        padding: 16px 40px;
        border-radius: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        animation: fadeInUp 0.6s ease-out 0.4s backwards;
    }

    .btn-back:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(108, 117, 125, 0.4);
        color: white;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .page-header {
            padding: 2rem 1.5rem;
        }

        .page-title {
            font-size: 1.8rem;
        }

        .content-section {
            padding: 2rem 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .card-header-custom,
        .update-header,
        .card-body-custom,
        .update-body {
            padding: 1.5rem;
        }

        .info-item {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="reservation-details-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="header-left">
                <div class="page-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h1 class="page-title">Reservation Details</h1>
                    <p class="page-subtitle">Complete booking information</p>
                </div>
            </div>
            <div class="reservation-id">
                <i class="fas fa-hashtag"></i>
                ID: {{ $reservation->id }}
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <!-- Details Card -->
        <div class="details-card">
            <div class="card-header-custom">
                <h2 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Booking Information
                </h2>
                <span class="status-badge-large {{ $reservation->status }}">
                    <i class="fas fa-{{ 
                        $reservation->status === 'confirmed' ? 'check-circle' : 
                        ($reservation->status === 'pending' ? 'clock' : 
                        ($reservation->status === 'completed' ? 'clipboard-check' : 'ban'))
                    }}"></i>
                    {{ ucfirst($reservation->status) }}
                </span>
            </div>

            <div class="card-body-custom">
                <div class="info-grid">
                    <!-- Guest Information -->
                    <div class="info-section">
                        <h3 class="section-title">
                            <i class="fas fa-user"></i>
                            Guest Information
                        </h3>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Guest Name</div>
                                <div class="info-value">{{ $reservation->guest_name }}</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Phone Number</div>
                                <div class="info-value">{{ $reservation->guest_phone }}</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Email Address</div>
                                <div class="info-value">{{ $reservation->guest_email ?? 'Not provided' }}</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Number of Guests</div>
                                <div class="info-value">{{ $reservation->guests_count }} Persons</div>
                            </div>
                        </div>
                    </div>

                    <!-- Reservation Details -->
                    <div class="info-section">
                        <h3 class="section-title">
                            <i class="fas fa-calendar-check"></i>
                            Reservation Details
                        </h3>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-chair"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Table Number</div>
                                <div class="info-value">
                                    Table #{{ $reservation->table->table_number }}
                                    <span style="font-size: 0.9rem; color: var(--text-muted);">
                                        (Capacity: {{ $reservation->table->capacity }} persons)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Reservation Date</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('l, d F Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Reservation Time</div>
                                <div class="info-value">{{ $reservation->reservation_time }}</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Booked On</div>
                                <div class="info-value">
                                    {{ $reservation->created_at->format('d M Y, h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if($reservation->notes)
                <div class="notes-box">
                    <div class="notes-title">
                        <i class="fas fa-sticky-note"></i>
                        Special Notes
                    </div>
                    <div class="notes-content">
                        {{ $reservation->notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Update Status Card -->
        <div class="update-card">
            <div class="update-header">
                <h3 class="update-title">
                    <i class="fas fa-sync-alt"></i>
                    Update Reservation Status
                </h3>
            </div>
            <div class="update-body">
                <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <select name="status" class="status-select" required>
                                @foreach(['pending', 'confirmed', 'cancelled', 'completed'] as $s)
                                <option value="{{ $s }}" {{ $reservation->status === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn-update">
                                <i class="fas fa-check-circle"></i>
                                <span>Update Status</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Back Button -->
        <a href="{{ route('admin.reservations.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Reservations</span>
        </a>
    </div>
</div>
@endsection