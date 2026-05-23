@extends('layouts.admin')
@section('title', 'Add Table')
@section('page-title', 'Add Table')

@push('styles')
<style>
    /* ========== THEME VARIABLES ========== */
    .table-form-wrapper {
        --card-bg: #ffffff;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.12);
        --input-bg: #ffffff;
        --input-border: #e3e6f0;
        --input-focus-border: #36b9cc;
        --input-focus-shadow: rgba(54, 185, 204, 0.15);
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --text-muted: #858796;
        --gradient-info: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        --gradient-success: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        --section-bg: #f8f9fc;
        --border-color: #e3e6f0;
        --preview-bg: #f8f9fc;
        --status-card-bg: #f8f9fc;
    }

    /* Dark Theme with Custom Color #141A21 */
    body.dark-mode .table-form-wrapper,
    body.sidebar-dark-primary .table-form-wrapper,
    [data-theme="dark"] .table-form-wrapper,
    [data-bs-theme="dark"] .table-form-wrapper {
        --card-bg: #1e2936;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.8);
        --card-hover-shadow: 0 20px 60px rgba(0,0,0,0.9);
        --input-bg: #2a3441;
        --input-border: #3d4954;
        --input-focus-border: #06b6d4;
        --input-focus-shadow: rgba(6, 182, 212, 0.2);
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --gradient-info: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --section-bg: #141A21;
        --border-color: #3d4954;
        --preview-bg: #1a2129;
        --status-card-bg: #1a2129;
    }

    /* ========== FULL SCREEN LAYOUT ========== */
    .table-form-wrapper {
        background: var(--section-bg);
        min-height: 100vh;
        padding: 0;
        margin: 0;
        animation: fadeIn 0.6s ease-out;
        transition: background 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .container-full {
        width: 100%;
        max-width: 100%;
        padding: 0;
        margin: 0;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: 0;
        box-shadow: none;
        border: none;
        overflow: hidden;
        min-height: 100vh;
        transition: background 0.3s ease;
    }

    /* ========== ANIMATED HEADER ========== */
    .form-header {
        background: var(--gradient-info);
        padding: 2.5rem 3rem;
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

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: movePattern 20s linear infinite;
    }

    @keyframes movePattern {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    .form-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .header-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .header-text h1 {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .header-text p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0.5rem 0 0 0;
        font-size: 1.05rem;
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

    /* ========== FORM CONTENT ========== */
    .form-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        padding: 3rem;
        max-width: 1400px;
        margin: 0 auto;
        animation: fadeInUp 0.7s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-section-left,
    .form-section-right {
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

    /* ========== SECTION HEADERS ========== */
    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2.5rem;
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
        background: var(--gradient-info);
        animation: expandWidth 1s ease-out;
    }

    @keyframes expandWidth {
        from { width: 0; }
        to { width: 80px; }
    }

    .section-icon {
        width: 55px;
        height: 55px;
        background: var(--gradient-info);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 6px 18px rgba(54, 185, 204, 0.3);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        transition: color 0.3s ease;
    }

    /* ========== FORM GROUPS ========== */
    .form-group {
        margin-bottom: 2.5rem;
    }

    .form-label {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.05rem;
        transition: color 0.3s ease;
    }

    .form-label i {
        color: #36b9cc;
        font-size: 1.2rem;
        transition: transform 0.3s, color 0.3s;
    }

    body.dark-mode .form-label i,
    [data-theme="dark"] .form-label i,
    [data-bs-theme="dark"] .form-label i {
        color: #06b6d4;
    }

    .form-group:hover .form-label i {
        transform: scale(1.2) rotate(10deg);
    }

    .required {
        color: #e74a3b;
        margin-left: 5px;
        font-size: 1.2rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* ========== INPUTS ========== */
    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 1.2rem;
        z-index: 1;
        pointer-events: none;
        transition: all 0.3s;
    }

    .modern-input,
    .modern-select {
        background: var(--input-bg);
        border: 2px solid var(--input-border);
        border-radius: 16px;
        padding: 16px 22px 16px 55px;
        font-size: 1.05rem;
        color: var(--text-primary);
        width: 100%;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 2;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }

    .modern-select {
        appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 14 14'%3E%3Cpath fill='%2336b9cc' d='M7 10L2 5h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 22px center;
    }

    body.dark-mode .modern-select,
    [data-theme="dark"] .modern-select,
    [data-bs-theme="dark"] .modern-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 14 14'%3E%3Cpath fill='%2306b6d4' d='M7 10L2 5h10z'/%3E%3C/svg%3E");
    }

    .modern-input:focus,
    .modern-select:focus {
        border-color: var(--input-focus-border);
        box-shadow: 0 0 0 6px var(--input-focus-shadow);
        outline: none;
        transform: translateY(-2px);
        background: var(--input-bg);
        color: var(--text-primary);
    }

    .modern-input:focus ~ .input-icon,
    .modern-select:focus ~ .input-icon {
        color: var(--input-focus-border);
        transform: translateY(-50%) scale(1.2);
    }

    .modern-input::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }

    /* ========== STATUS INFO CARD ========== */
    .status-info {
        background: var(--status-card-bg);
        border-radius: 16px;
        padding: 1.8rem;
        margin-top: 1rem;
        border: 2px solid var(--border-color);
        transition: all 0.3s;
    }

    .status-info:hover {
        border-color: var(--input-focus-border);
        box-shadow: 0 8px 20px var(--input-focus-shadow);
        transform: translateY(-3px);
    }

    .status-info-title {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1rem;
    }

    .status-info-title i {
        color: var(--input-focus-border);
    }

    .status-option {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin-bottom: 1rem;
        padding: 0.8rem;
        background: var(--input-bg);
        border-radius: 10px;
        transition: all 0.3s;
    }

    .status-option:last-child {
        margin-bottom: 0;
    }

    .status-option:hover {
        background: var(--preview-bg);
        transform: translateX(5px);
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
        box-shadow: 0 0 10px currentColor;
    }

    .status-dot.available { 
        background: #1cc88a;
        color: #1cc88a;
    }
    .status-dot.occupied { 
        background: #e74a3b;
        color: #e74a3b;
    }
    .status-dot.reserved { 
        background: #f6c23e;
        color: #f6c23e;
    }

    /* ========== TIPS CARD ========== */
    .tips-card {
        background: var(--status-card-bg);
        border-radius: 16px;
        padding: 1.8rem;
        border-left: 5px solid var(--input-focus-border);
        transition: all 0.3s;
    }

    .tips-card:hover {
        box-shadow: 0 8px 20px var(--input-focus-shadow);
        transform: translateY(-3px);
    }

    .tips-title {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.05rem;
    }

    .tips-title i {
        color: #f6c23e;
        font-size: 1.3rem;
    }

    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tips-list li {
        color: var(--text-secondary);
        padding: 0.6rem 0;
        padding-left: 1.8rem;
        position: relative;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .tips-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #1cc88a;
        font-weight: 700;
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
        padding: 16px 45px;
        border-radius: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 1rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-modern:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    .btn-modern:active {
        transform: translateY(-2px);
    }

    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
    }

    .btn-save {
        background: var(--gradient-info);
        color: white;
        box-shadow: 0 8px 20px rgba(54, 185, 204, 0.4);
    }

    .btn-save:hover {
        box-shadow: 0 12px 30px rgba(54, 185, 204, 0.5);
    }

    /* ========== ALERT ========== */
    .alert {
        border-radius: 16px;
        border: none;
        padding: 1.5rem;
        animation: slideDown 0.5s ease-out;
        margin-bottom: 2rem;
    }

    .alert-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
        color: white;
    }

    .alert ul {
        list-style: none;
        padding-left: 1.5rem;
        margin-bottom: 0;
    }

    .alert ul li::before {
        content: '⚠';
        margin-right: 10px;
        font-size: 1.1rem;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 1200px) {
        .form-content {
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .form-header {
            padding: 1.5rem 1.5rem;
        }

        .header-icon {
            width: 55px;
            height: 55px;
            font-size: 1.6rem;
        }

        .header-text h1 {
            font-size: 1.5rem;
        }

        .breadcrumb-custom {
            width: 100%;
            justify-content: center;
        }

        .form-content {
            padding: 2rem 1.5rem;
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
            width: 100%;
            justify-content: center;
        }

        .form-actions {
            flex-direction: column;
        }
    }

    /* ========== SCROLLBAR ========== */
    ::-webkit-scrollbar {
        width: 12px;
        height: 12px;
    }

    ::-webkit-scrollbar-track {
        background: var(--section-bg);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--gradient-info);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--gradient-success);
    }
</style>
@endpush

@section('content')
<div class="table-form-wrapper">
    <div class="container-full">
        <div class="form-card">
            <!-- Animated Header -->
            <div class="form-header">
                <div class="form-header-content">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="header-text">
                            <h1>Add New Table</h1>
                            <p>Create a new table for restaurant seating</p>
                        </div>
                    </div>
                    <div class="breadcrumb-custom">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                        <i class="fas fa-chevron-right"></i>
                        <span>Tables</span>
                        <i class="fas fa-chevron-right"></i>
                        <span>Add New</span>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form method="POST" action="{{ route('admin.tables.store') }}" id="tableForm">
                @csrf
                
                <div class="form-content">
                    <!-- LEFT SECTION: Basic Information -->
                    <div class="form-section-left">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h2 class="section-title">Basic Information</h2>
                        </div>

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Please fix the errors:</strong>
                            <ul class="mt-2">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Table Number -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-hashtag"></i>
                                Table Number
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <input type="number" 
                                       name="table_number" 
                                       class="modern-input"
                                       value="{{ old('table_number') }}"
                                       placeholder="e.g., 1, 2, 3..."
                                       min="1"
                                       required
                                       autocomplete="off">
                                <i class="fas fa-list-ol input-icon"></i>
                            </div>
                        </div>

                        <!-- Capacity -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-users"></i>
                                Capacity (Persons)
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <input type="number" 
                                       name="capacity" 
                                       class="modern-input"
                                       value="{{ old('capacity', 4) }}"
                                       placeholder="Number of persons"
                                       min="1"
                                       max="20"
                                       required
                                       autocomplete="off">
                                <i class="fas fa-user-friends input-icon"></i>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-toggle-on"></i>
                                Status
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <select name="status" class="modern-select" required>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                    <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                </select>
                                <i class="fas fa-info-circle input-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SECTION: Status Information & Tips -->
                    <div class="form-section-right">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h2 class="section-title">Status Guide</h2>
                        </div>

                        <!-- Status Info Card -->
                        <div class="status-info">
                            <div class="status-info-title">
                                <i class="fas fa-traffic-light"></i>
                                Table Status Options
                            </div>
                            <div class="status-option">
                                <span class="status-dot available"></span>
                                <div>
                                    <strong style="color: var(--text-primary);">Available</strong>
                                    <div style="font-size: 0.85rem; color: var(--text-muted);">Ready for new bookings and walk-ins</div>
                                </div>
                            </div>
                            <div class="status-option">
                                <span class="status-dot occupied"></span>
                                <div>
                                    <strong style="color: var(--text-primary);">Occupied</strong>
                                    <div style="font-size: 0.85rem; color: var(--text-muted);">Currently being used by customers</div>
                                </div>
                            </div>
                            <div class="status-option">
                                <span class="status-dot reserved"></span>
                                <div>
                                    <strong style="color: var(--text-primary);">Reserved</strong>
                                    <div style="font-size: 0.85rem; color: var(--text-muted);">Booked for future reservation</div>
                                </div>
                            </div>
                        </div>

                        <!-- Tips Card -->
                        <div class="tips-card mt-4">
                            <div class="tips-title">
                                <i class="fas fa-lightbulb"></i>
                                Quick Tips
                            </div>
                            <ul class="tips-list">
                                <li>Use unique table numbers to avoid confusion</li>
                                <li>Set capacity based on actual seating arrangement</li>
                                <li>Most tables are set as "Available" by default</li>
                                <li>You can update status anytime from table list</li>
                                <li>Consider VIP areas or outdoor sections separately</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <a href="{{ route('admin.tables.index') }}" class="btn-modern btn-back">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to Tables</span>
                        </a>
                        <button type="submit" class="btn-modern btn-save" id="submitBtn">
                            <i class="fas fa-save"></i>
                            <span>Save Table</span>
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
// Loading State
document.getElementById('tableForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    btn.disabled = true;
});

// Ensure inputs work properly
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.modern-input, .modern-select');
    
    inputs.forEach(input => {
        input.style.pointerEvents = 'auto';
        
        // Log for debugging
        input.addEventListener('focus', function() {
            console.log('Focused:', this.name);
        });
    });
});
</script>
@endpush