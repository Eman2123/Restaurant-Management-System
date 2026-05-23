<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders Report — {{ now()->format('d M Y') }}</title>
    <style>

        /* ══════════════════════════════════════════════════════════
           RESET & BASE
        ══════════════════════════════════════════════════════════ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #2d3748;
            background: #ffffff;
            line-height: 1.5;
        }

        /* ══════════════════════════════════════════════════════════
           PAGE WRAPPER
        ══════════════════════════════════════════════════════════ */
        .rpt-page {
            width: 100%;
            max-width: 100%;
            padding: 0;
        }

        /* ══════════════════════════════════════════════════════════
           HEADER BAND
        ══════════════════════════════════════════════════════════ */
        .rpt-header {
            background: linear-gradient(135deg, #1a1f2e 0%, #0f1319 100%);
            padding: 28px 32px 22px;
            margin-bottom: 0;
            position: relative;
            overflow: hidden;
        }

        /* Subtle geometric accent */
        .rpt-header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(200, 169, 81, 0.07);
        }

        .rpt-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: 80px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(200, 169, 81, 0.05);
        }

        .rpt-header-inner {
            position: relative;
            z-index: 1;
        }

        /* Gold accent bar */
        .rpt-header-bar {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #c8a951, #e8c96a);
            border-radius: 2px;
            margin-bottom: 12px;
        }

        .rpt-brand {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: rgba(200, 169, 81, 0.7);
            margin-bottom: 6px;
        }

        .rpt-title {
            font-size: 22px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: -0.3px;
            margin-bottom: 4px;
        }

        .rpt-title span {
            color: #c8a951;
        }

        .rpt-subtitle {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 0.02em;
        }

        /* Header right — meta info */
        .rpt-header-table {
            width: 100%;
        }

        .rpt-header-left  { width: 60%; vertical-align: top; }
        .rpt-header-right {
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        .rpt-meta-block {
            display: inline-block;
            text-align: right;
            margin-top: 6px;
        }

        .rpt-meta-item {
            font-size: 9px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 3px;
        }

        .rpt-meta-item strong {
            color: rgba(255,255,255,0.75);
            font-size: 10px;
        }

        /* Gold bottom border */
        .rpt-header-border {
            height: 4px;
            background: linear-gradient(90deg,
                #c8a951 0%,
                #e8c96a 40%,
                #c8a951 70%,
                rgba(200,169,81,0.2) 100%);
        }

        /* ══════════════════════════════════════════════════════════
           PERIOD BANNER (conditional)
        ══════════════════════════════════════════════════════════ */
        .rpt-period-banner {
            background: rgba(200, 169, 81, 0.08);
            border-left: 3px solid #c8a951;
            padding: 8px 32px;
            font-size: 10px;
            color: #6b7280;
            border-bottom: 1px solid rgba(200,169,81,0.15);
        }

        .rpt-period-banner strong { color: #c8a951; }

        /* ══════════════════════════════════════════════════════════
           BODY CONTENT AREA
        ══════════════════════════════════════════════════════════ */
        .rpt-body {
            padding: 24px 32px 20px;
        }

        /* ══════════════════════════════════════════════════════════
           SECTION HEADING
        ══════════════════════════════════════════════════════════ */
        .rpt-section-heading {
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #9ca3af;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f3f4f6;
            display: table;
            width: 100%;
        }

        .rpt-section-heading td {
            padding: 0 0 6px 0;
            border: none;
            vertical-align: middle;
        }

        .rpt-section-heading .sh-line {
            width: 100%;
            height: 1px;
            background: #f3f4f6;
        }

        /* ══════════════════════════════════════════════════════════
           SUMMARY STAT CARDS
        ══════════════════════════════════════════════════════════ */
        .rpt-stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 24px;
        }

        .rpt-stats-table td {
            padding: 0;
            border: none;
            width: 25%;
        }

        .rpt-stat-card {
            border-radius: 8px;
            padding: 14px 12px 12px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Top accent line via border-top */
        .rpt-stat-card--gold {
            background: #fffbf0;
            border: 1px solid rgba(200,169,81,0.25);
            border-top: 3px solid #c8a951;
        }

        .rpt-stat-card--green {
            background: #f0fdf4;
            border: 1px solid rgba(25,135,84,0.2);
            border-top: 3px solid #198754;
        }

        .rpt-stat-card--orange {
            background: #fff7f0;
            border: 1px solid rgba(253,126,20,0.2);
            border-top: 3px solid #fd7e14;
        }

        .rpt-stat-card--red {
            background: #fff5f5;
            border: 1px solid rgba(220,53,69,0.2);
            border-top: 3px solid #dc3545;
        }

        .rpt-stat-icon {
            font-size: 16px;
            margin-bottom: 6px;
            display: block;
            opacity: 0.7;
        }

        .rpt-stat-num {
            font-size: 20px;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 5px;
            display: block;
        }

        .rpt-stat-card--gold   .rpt-stat-num { color: #c8a951; }
        .rpt-stat-card--green  .rpt-stat-num { color: #198754; }
        .rpt-stat-card--orange .rpt-stat-num { color: #fd7e14; }
        .rpt-stat-card--red    .rpt-stat-num { color: #dc3545; }

        .rpt-stat-label {
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            display: block;
        }

        .rpt-stat-sub {
            font-size: 8px;
            color: #d1d5db;
            margin-top: 3px;
            display: block;
        }

        /* ══════════════════════════════════════════════════════════
           QUICK BREAKDOWN BAR
        ══════════════════════════════════════════════════════════ */
        .rpt-breakdown {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 22px;
        }

        .rpt-breakdown-title {
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        .rpt-breakdown-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rpt-breakdown-table td {
            padding: 4px 8px 4px 0;
            border: none;
            vertical-align: middle;
            font-size: 10px;
        }

        .rpt-breakdown-table .bd-key {
            width: 90px;
            color: #6b7280;
            font-weight: bold;
            white-space: nowrap;
        }

        .rpt-breakdown-table .bd-bar-wrap {
            width: 100%;
        }

        .rpt-bar-track {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 99px;
            overflow: hidden;
        }

        .rpt-bar-fill {
            height: 100%;
            border-radius: 99px;
        }

        .rpt-bar-fill--gold   { background: #c8a951; }
        .rpt-bar-fill--green  { background: #198754; }
        .rpt-bar-fill--orange { background: #fd7e14; }
        .rpt-bar-fill--red    { background: #dc3545; }
        .rpt-bar-fill--blue   { background: #3b82f6; }

        .rpt-breakdown-table .bd-count {
            width: 60px;
            text-align: right;
            color: #374151;
            font-weight: bold;
            white-space: nowrap;
        }

        /* ══════════════════════════════════════════════════════════
           ORDERS TABLE
        ══════════════════════════════════════════════════════════ */
        .rpt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        /* Column widths */
        .rpt-table .col-id     { width: 5%; }
        .rpt-table .col-cust   { width: 18%; }
        .rpt-table .col-table  { width: 8%; }
        .rpt-table .col-type   { width: 11%; }
        .rpt-table .col-items  { width: 6%; }
        .rpt-table .col-total  { width: 11%; }
        .rpt-table .col-pay    { width: 10%; }
        .rpt-table .col-status { width: 10%; }
        .rpt-table .col-date   { width: 12%; }
        .rpt-table .col-disc   { width: 9%; }

        /* Head */
        .rpt-table thead tr {
            background: #1a1f2e;
        }

        .rpt-table thead th {
            padding: 9px 10px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.75);
            text-align: left;
            border: none;
            white-space: nowrap;
        }

        .rpt-table thead th:first-child {
            border-radius: 6px 0 0 0;
        }

        .rpt-table thead th:last-child {
            border-radius: 0 6px 0 0;
        }

        /* Gold underline on thead */
        .rpt-table thead tr.rpt-thead-accent td {
            height: 2px;
            background: linear-gradient(90deg, #c8a951, rgba(200,169,81,0.2));
            padding: 0;
            border: none;
        }

        /* Body rows */
        .rpt-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }

        .rpt-table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .rpt-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        /* Subtle left border on hover alternative — every 5th row accent */
        .rpt-table tbody tr.rpt-row-accent {
            background: #fffbf0;
        }

        .rpt-table tbody td {
            padding: 7px 10px;
            font-size: 10.5px;
            color: #374151;
            border: none;
            vertical-align: middle;
        }

        /* Order number */
        .rpt-order-id {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            font-weight: bold;
            color: #c8a951;
            background: rgba(200,169,81,0.08);
            border: 1px solid rgba(200,169,81,0.2);
            border-radius: 4px;
            padding: 2px 5px;
            white-space: nowrap;
        }

        /* Customer name */
        .rpt-customer-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 10.5px;
        }

        .rpt-customer-guest {
            font-style: italic;
            color: #9ca3af;
        }

        /* Table / Takeaway */
        .rpt-table-num {
            font-weight: bold;
            color: #374151;
        }

        .rpt-takeaway {
            color: #6b7280;
            font-style: italic;
        }

        /* Order type pill */
        .rpt-type-pill {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .rpt-type-pill--dine {
            background: rgba(59,130,246,0.1);
            color: #2563eb;
            border: 1px solid rgba(59,130,246,0.2);
        }

        .rpt-type-pill--takeaway {
            background: rgba(139,92,246,0.1);
            color: #7c3aed;
            border: 1px solid rgba(139,92,246,0.2);
        }

        .rpt-type-pill--delivery {
            background: rgba(20,184,166,0.1);
            color: #0d9488;
            border: 1px solid rgba(20,184,166,0.2);
        }

        /* Amount */
        .rpt-amount {
            font-weight: bold;
            color: #1f2937;
            font-size: 11px;
            white-space: nowrap;
        }

        .rpt-amount-prefix {
            font-size: 8.5px;
            color: #9ca3af;
            font-weight: normal;
        }

        /* Discount */
        .rpt-discount {
            font-size: 10px;
            color: #dc3545;
        }

        .rpt-discount-none {
            color: #d1d5db;
        }

        /* Payment status badges */
        .rpt-pay-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .rpt-pay-badge--paid {
            background: rgba(25,135,84,0.1);
            color: #198754;
            border: 1px solid rgba(25,135,84,0.25);
        }

        .rpt-pay-badge--unpaid {
            background: rgba(253,126,20,0.1);
            color: #fd7e14;
            border: 1px solid rgba(253,126,20,0.25);
        }

        .rpt-pay-badge--partial {
            background: rgba(255,193,7,0.1);
            color: #d97706;
            border: 1px solid rgba(255,193,7,0.3);
        }

        .rpt-pay-badge--refunded {
            background: rgba(220,53,69,0.1);
            color: #dc3545;
            border: 1px solid rgba(220,53,69,0.2);
        }

        /* Order status badges */
        .rpt-status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .rpt-status-badge--served,
        .rpt-status-badge--completed {
            background: rgba(25,135,84,0.1);
            color: #198754;
            border: 1px solid rgba(25,135,84,0.2);
        }

        .rpt-status-badge--pending {
            background: rgba(255,193,7,0.12);
            color: #b45309;
            border: 1px solid rgba(255,193,7,0.35);
        }

        .rpt-status-badge--cooking,
        .rpt-status-badge--preparing {
            background: rgba(253,126,20,0.1);
            color: #fd7e14;
            border: 1px solid rgba(253,126,20,0.25);
        }

        .rpt-status-badge--cancelled {
            background: rgba(220,53,69,0.08);
            color: #dc3545;
            border: 1px solid rgba(220,53,69,0.2);
        }

        .rpt-status-badge--ready {
            background: rgba(59,130,246,0.1);
            color: #2563eb;
            border: 1px solid rgba(59,130,246,0.2);
        }

        /* Date cell */
        .rpt-date-primary {
            font-weight: 600;
            color: #374151;
            font-size: 10.5px;
        }

        .rpt-date-time {
            font-size: 8.5px;
            color: #9ca3af;
            margin-top: 1px;
        }

        /* Empty state row */
        .rpt-empty-row td {
            text-align: center;
            padding: 32px 0;
            color: #9ca3af;
            font-style: italic;
            border: none;
        }

        /* ══════════════════════════════════════════════════════════
           TABLE TOTALS ROW
        ══════════════════════════════════════════════════════════ */
        .rpt-totals-row {
            background: #1a1f2e !important;
            border: none !important;
        }

        .rpt-totals-row td {
            padding: 9px 10px !important;
            color: rgba(255,255,255,0.6) !important;
            font-size: 9px !important;
            font-weight: bold !important;
            text-transform: uppercase !important;
            letter-spacing: 0.06em !important;
            border: none !important;
        }

        .rpt-totals-row .rpt-total-val {
            color: #c8a951 !important;
            font-size: 12px !important;
        }

        /* ══════════════════════════════════════════════════════════
           PAYMENT METHOD BREAKDOWN (bottom)
        ══════════════════════════════════════════════════════════ */
        .rpt-summary-section {
            margin-top: 20px;
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px 0;
        }

        .rpt-summary-section > tbody > tr > td {
            padding: 0;
            vertical-align: top;
            border: none;
            width: 50%;
        }

        .rpt-summary-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .rpt-summary-box-header {
            background: #f1f5f9;
            padding: 8px 12px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .rpt-summary-box-body { padding: 10px 12px; }

        .rpt-summary-row {
            width: 100%;
            border-collapse: collapse;
        }

        .rpt-summary-row td {
            padding: 5px 0;
            font-size: 10px;
            border: none;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
            color: #374151;
        }

        .rpt-summary-row tr:last-child td { border-bottom: none; }

        .rpt-summary-key {
            color: #6b7280;
            width: 55%;
        }

        .rpt-summary-val {
            text-align: right;
            font-weight: bold;
            width: 45%;
            color: #1f2937;
        }

        .rpt-summary-val--gold   { color: #c8a951; }
        .rpt-summary-val--green  { color: #198754; }
        .rpt-summary-val--red    { color: #dc3545; }
        .rpt-summary-val--orange { color: #fd7e14; }

        /* ══════════════════════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════════════════════ */
        .rpt-footer {
            margin-top: 28px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            width: 100%;
            border-collapse: collapse;
        }

        .rpt-footer td {
            padding: 0;
            border: none;
            vertical-align: top;
        }

        .rpt-footer-left {
            font-size: 8.5px;
            color: #9ca3af;
        }

        .rpt-footer-left strong {
            color: #c8a951;
            font-size: 9px;
        }

        .rpt-footer-right {
            text-align: right;
            font-size: 8px;
            color: #d1d5db;
        }

        .rpt-footer-right strong {
            color: #9ca3af;
        }

        /* ══════════════════════════════════════════════════════════
           WATERMARK (light bg text)
        ══════════════════════════════════════════════════════════ */
        .rpt-confidential {
            display: inline-block;
            padding: 2px 8px;
            border: 1px solid #e5e7eb;
            border-radius: 3px;
            font-size: 7.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #d1d5db;
            margin-top: 4px;
        }

        /* ══════════════════════════════════════════════════════════
           PRINT UTILITIES
        ══════════════════════════════════════════════════════════ */
        @media print {
            body    { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .rpt-page { padding: 0; }
        }

    </style>
</head>
<body>
<div class="rpt-page">

    {{-- ══════════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════════ --}}
    <div class="rpt-header">
        <table class="rpt-header-table">
            <tbody>
                <tr>
                    <td class="rpt-header-left">
                        <div class="rpt-header-inner">
                            <div class="rpt-header-bar"></div>
                            <div class="rpt-brand">Restaurant Management System</div>
                            <div class="rpt-title">
                                Orders <span>Report</span>
                            </div>
                            <div class="rpt-subtitle">
                                Detailed transaction log with financial summary
                            </div>
                        </div>
                    </td>
                    <td class="rpt-header-right">
                        <div class="rpt-meta-block">
                            <div class="rpt-meta-item">
                                Generated on<br>
                                <strong>{{ now()->format('d M Y, h:i A') }}</strong>
                            </div>
                            <div class="rpt-meta-item" style="margin-top:6px;">
                                Total Records<br>
                                <strong>{{ $orders->count() }} Orders</strong>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Gold gradient border --}}
    <div class="rpt-header-border"></div>

    {{-- ══════════════════════════════════════════════
         PERIOD BANNER (only if filters set)
    ══════════════════════════════════════════════ --}}
    @if(!empty($filters['date_from']) || !empty($filters['date_to']))
    <div class="rpt-period-banner">
        <strong>Filtered Period:</strong>
        &nbsp;
        {{ !empty($filters['date_from']) ? \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') : 'Beginning' }}
        &nbsp;&mdash;&nbsp;
        {{ !empty($filters['date_to'])   ? \Carbon\Carbon::parse($filters['date_to'])->format('d M Y')   : 'Today' }}
        @if(!empty($filters['status']))
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Status:</strong> {{ ucfirst($filters['status']) }}
        @endif
        @if(!empty($filters['payment_status']))
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Payment:</strong> {{ ucfirst($filters['payment_status']) }}
        @endif
    </div>
    @endif

    {{-- ══════════════════════════════════════════════
         BODY
    ══════════════════════════════════════════════ --}}
    <div class="rpt-body">

        @php
            /* ── Pre-compute all aggregates once ── */
            $totalOrders     = $orders->count();
            $totalRevenue    = $orders->where('payment_status', 'paid')->sum('total_amount');
            $unpaidCount     = $orders->where('payment_status', 'unpaid')->count();
            $cancelledCount  = $orders->where('status', 'cancelled')->count();
            $servedCount     = $orders->whereIn('status', ['served','completed'])->count();
            $pendingCount    = $orders->where('status', 'pending')->count();
            $cookingCount    = $orders->whereIn('status', ['cooking','preparing'])->count();
            $avgOrder        = $totalOrders > 0
                                ? $orders->where('payment_status','paid')->avg('total_amount')
                                : 0;
            $discountTotal   = $orders->sum('discount_amount');

            /* Bar widths (avoid div-by-zero) */
            $paidCount       = $orders->where('payment_status','paid')->count();
            $maxBar          = max($paidCount, $unpaidCount, $servedCount,
                                   $cancelledCount, $pendingCount, 1);
        @endphp

        {{-- ── SUMMARY STAT CARDS ── --}}
        <table class="rpt-stats-table">
            <tbody>
                <tr>
                    {{-- Total Orders --}}
                    <td>
                        <div class="rpt-stat-card rpt-stat-card--gold">
                            <span class="rpt-stat-num">{{ $totalOrders }}</span>
                            <span class="rpt-stat-label">Total Orders</span>
                            <span class="rpt-stat-sub">All statuses included</span>
                        </div>
                    </td>

                    {{-- Revenue --}}
                    <td>
                        <div class="rpt-stat-card rpt-stat-card--green">
                            <span class="rpt-stat-num">
                                Rs.{{ number_format($totalRevenue, 0) }}
                            </span>
                            <span class="rpt-stat-label">Total Revenue</span>
                            <span class="rpt-stat-sub">
                                Avg Rs.{{ number_format($avgOrder, 0) }} / order
                            </span>
                        </div>
                    </td>

                    {{-- Unpaid --}}
                    <td>
                        <div class="rpt-stat-card rpt-stat-card--orange">
                            <span class="rpt-stat-num">{{ $unpaidCount }}</span>
                            <span class="rpt-stat-label">Unpaid Orders</span>
                            <span class="rpt-stat-sub">
                                {{ $totalOrders > 0 ? round(($unpaidCount / $totalOrders) * 100) : 0 }}%
                                of total
                            </span>
                        </div>
                    </td>

                    {{-- Cancelled --}}
                    <td>
                        <div class="rpt-stat-card rpt-stat-card--red">
                            <span class="rpt-stat-num">{{ $cancelledCount }}</span>
                            <span class="rpt-stat-label">Cancelled</span>
                            <span class="rpt-stat-sub">
                                {{ $totalOrders > 0 ? round(($cancelledCount / $totalOrders) * 100) : 0 }}%
                                of total
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- ── STATUS BREAKDOWN BARS ── --}}
        <div class="rpt-breakdown">
            <div class="rpt-breakdown-title">Order Status Breakdown</div>
            <table class="rpt-breakdown-table">
                <tbody>
                    <tr>
                        <td class="bd-key">Paid</td>
                        <td class="bd-bar-wrap">
                            <div class="rpt-bar-track">
                                <div class="rpt-bar-fill rpt-bar-fill--green"
                                     style="width:{{ $maxBar > 0 ? round(($paidCount / $maxBar)*100) : 0 }}%">
                                </div>
                            </div>
                        </td>
                        <td class="bd-count">{{ $paidCount }} orders</td>
                    </tr>
                    <tr>
                        <td class="bd-key">Served / Done</td>
                        <td class="bd-bar-wrap">
                            <div class="rpt-bar-track">
                                <div class="rpt-bar-fill rpt-bar-fill--gold"
                                     style="width:{{ $maxBar > 0 ? round(($servedCount / $maxBar)*100) : 0 }}%">
                                </div>
                            </div>
                        </td>
                        <td class="bd-count">{{ $servedCount }} orders</td>
                    </tr>
                    <tr>
                        <td class="bd-key">Pending</td>
                        <td class="bd-bar-wrap">
                            <div class="rpt-bar-track">
                                <div class="rpt-bar-fill rpt-bar-fill--orange"
                                     style="width:{{ $maxBar > 0 ? round(($pendingCount / $maxBar)*100) : 0 }}%">
                                </div>
                            </div>
                        </td>
                        <td class="bd-count">{{ $pendingCount }} orders</td>
                    </tr>
                    <tr>
                        <td class="bd-key">Cooking</td>
                        <td class="bd-bar-wrap">
                            <div class="rpt-bar-track">
                                <div class="rpt-bar-fill rpt-bar-fill--blue"
                                     style="width:{{ $maxBar > 0 ? round(($cookingCount / $maxBar)*100) : 0 }}%">
                                </div>
                            </div>
                        </td>
                        <td class="bd-count">{{ $cookingCount }} orders</td>
                    </tr>
                    <tr>
                        <td class="bd-key">Cancelled</td>
                        <td class="bd-bar-wrap">
                            <div class="rpt-bar-track">
                                <div class="rpt-bar-fill rpt-bar-fill--red"
                                     style="width:{{ $maxBar > 0 ? round(($cancelledCount / $maxBar)*100) : 0 }}%">
                                </div>
                            </div>
                        </td>
                        <td class="bd-count">{{ $cancelledCount }} orders</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ── ORDERS TABLE ── --}}
        <table class="rpt-table">
            <thead>
                <tr>
                    <th class="col-id">Order</th>
                    <th class="col-cust">Customer</th>
                    <th class="col-table">Table</th>
                    <th class="col-type">Type</th>
                    <th class="col-total">Amount</th>
                    <th class="col-disc">Discount</th>
                    <th class="col-pay">Payment</th>
                    <th class="col-status">Status</th>
                    <th class="col-date">Date</th>
                </tr>
                {{-- Gold accent line under header --}}
                <tr class="rpt-thead-accent">
                    <td colspan="9"
                        style="height:2px;
                               background:linear-gradient(90deg,#c8a951,rgba(200,169,81,0.2));
                               padding:0;
                               border:none;">
                    </td>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                @php
                    $typeKey = strtolower(str_replace(' ','_', $order->order_type ?? ''));
                    $typePill = match($typeKey) {
                        'dine_in','dine in' => ['class' => 'rpt-type-pill--dine',     'label' => 'Dine In'],
                        'takeaway'          => ['class' => 'rpt-type-pill--takeaway', 'label' => 'Takeaway'],
                        'delivery'          => ['class' => 'rpt-type-pill--delivery', 'label' => 'Delivery'],
                        default             => ['class' => 'rpt-type-pill--dine',     'label' => ucfirst(str_replace('_',' ', $order->order_type ?? '—'))],
                    };

                    $payBadge = match($order->payment_status ?? '') {
                        'paid'     => 'rpt-pay-badge--paid',
                        'unpaid'   => 'rpt-pay-badge--unpaid',
                        'partial'  => 'rpt-pay-badge--partial',
                        'refunded' => 'rpt-pay-badge--refunded',
                        default    => 'rpt-pay-badge--unpaid',
                    };

                    $statusBadge = match($order->status ?? '') {
                        'served','completed' => 'rpt-status-badge--served',
                        'pending'            => 'rpt-status-badge--pending',
                        'cooking','preparing'=> 'rpt-status-badge--cooking',
                        'cancelled'          => 'rpt-status-badge--cancelled',
                        'ready'              => 'rpt-status-badge--ready',
                        default              => 'rpt-status-badge--pending',
                    };

                    $isAccent = ($index + 1) % 5 === 0;
                @endphp
                <tr class="{{ $isAccent ? 'rpt-row-accent' : '' }}">

                    {{-- Order ID --}}
                    <td>
                        <span class="rpt-order-id">
                            #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>

                    {{-- Customer --}}
                    <td>
                        @if($order->user)
                            <span class="rpt-customer-name">
                                {{ $order->user->name }}
                            </span>
                        @else
                            <span class="rpt-customer-guest">Guest</span>
                        @endif
                    </td>

                    {{-- Table --}}
                    <td>
                        @if($order->table)
                            <span class="rpt-table-num">
                                T&nbsp;#{{ $order->table->table_number }}
                            </span>
                        @else
                            <span class="rpt-takeaway">—</span>
                        @endif
                    </td>

                    {{-- Order Type --}}
                    <td>
                        <span class="rpt-type-pill {{ $typePill['class'] }}">
                            {{ $typePill['label'] }}
                        </span>
                    </td>

                    {{-- Total Amount --}}
                    <td>
                        <span class="rpt-amount">
                            <span class="rpt-amount-prefix">Rs.</span>{{ number_format($order->total_amount, 0) }}
                        </span>
                    </td>

                    {{-- Discount --}}
                    <td>
                        @if(!empty($order->discount_amount) && $order->discount_amount > 0)
                            <span class="rpt-discount">
                                - Rs.{{ number_format($order->discount_amount, 0) }}
                            </span>
                        @else
                            <span class="rpt-discount-none">—</span>
                        @endif
                    </td>

                    {{-- Payment Status --}}
                    <td>
                        <span class="rpt-pay-badge {{ $payBadge }}">
                            {{ ucfirst($order->payment_status ?? 'unpaid') }}
                        </span>
                    </td>

                    {{-- Order Status --}}
                    <td>
                        <span class="rpt-status-badge {{ $statusBadge }}">
                            {{ ucfirst($order->status ?? '—') }}
                        </span>
                    </td>

                    {{-- Date --}}
                    <td>
                        <div class="rpt-date-primary">
                            {{ $order->created_at->format('d M Y') }}
                        </div>
                        <div class="rpt-date-time">
                            {{ $order->created_at->format('h:i A') }}
                        </div>
                    </td>

                </tr>
                @empty
                <tr class="rpt-empty-row">
                    <td colspan="9">
                        No orders found for the selected period.
                    </td>
                </tr>
                @endforelse

                {{-- Totals row --}}
                @if($orders->count() > 0)
                <tr class="rpt-totals-row">
                    <td colspan="4"
                        style="text-align:right;
                               padding-right:12px !important;
                               color:rgba(255,255,255,0.4) !important;
                               font-size:9px !important;
                               text-transform:uppercase !important;
                               letter-spacing:0.08em !important;">
                        Totals
                    </td>
                    <td>
                        <span class="rpt-total-val">
                            Rs.{{ number_format($orders->sum('total_amount'), 0) }}
                        </span>
                    </td>
                    <td>
                        @if($discountTotal > 0)
                        <span style="color:#ef4444 !important;
                                     font-size:11px !important;">
                            - Rs.{{ number_format($discountTotal, 0) }}
                        </span>
                        @else
                        <span style="color:rgba(255,255,255,0.2) !important;">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="color:rgba(255,255,255,0.5) !important;
                                     font-size:9px !important;">
                            {{ $paidCount }} paid
                        </span>
                    </td>
                    <td>
                        <span style="color:rgba(255,255,255,0.5) !important;
                                     font-size:9px !important;">
                            {{ $servedCount }} done
                        </span>
                    </td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>

        {{-- ── BOTTOM SUMMARY BOXES ── --}}
        @if($orders->count() > 0)
        <table class="rpt-summary-section">
            <tbody>
                <tr>

                    {{-- Financial Summary --}}
                    <td>
                        <div class="rpt-summary-box">
                            <div class="rpt-summary-box-header">
                                Financial Summary
                            </div>
                            <div class="rpt-summary-box-body">
                                <table class="rpt-summary-row">
                                    <tr>
                                        <td class="rpt-summary-key">Gross Revenue</td>
                                        <td class="rpt-summary-val rpt-summary-val--gold">
                                            Rs.{{ number_format($orders->sum('total_amount'), 0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Paid Revenue</td>
                                        <td class="rpt-summary-val rpt-summary-val--green">
                                            Rs.{{ number_format($totalRevenue, 0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Total Discounts Given</td>
                                        <td class="rpt-summary-val rpt-summary-val--red">
                                            @if($discountTotal > 0)
                                                - Rs.{{ number_format($discountTotal, 0) }}
                                            @else
                                                Rs.0
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Avg Order Value</td>
                                        <td class="rpt-summary-val">
                                            Rs.{{ number_format($avgOrder, 0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Unpaid Outstanding</td>
                                        <td class="rpt-summary-val rpt-summary-val--orange">
                                            Rs.{{ number_format(
                                                $orders->where('payment_status','unpaid')->sum('total_amount'),
                                            0) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>

                    {{-- Order Summary --}}
                    <td>
                        <div class="rpt-summary-box">
                            <div class="rpt-summary-box-header">
                                Order Summary
                            </div>
                            <div class="rpt-summary-box-body">
                                <table class="rpt-summary-row">
                                    <tr>
                                        <td class="rpt-summary-key">Total Orders</td>
                                        <td class="rpt-summary-val rpt-summary-val--gold">
                                            {{ $totalOrders }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Served / Completed</td>
                                        <td class="rpt-summary-val rpt-summary-val--green">
                                            {{ $servedCount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Still Pending</td>
                                        <td class="rpt-summary-val rpt-summary-val--orange">
                                            {{ $pendingCount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Cancelled Orders</td>
                                        <td class="rpt-summary-val rpt-summary-val--red">
                                            {{ $cancelledCount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rpt-summary-key">Completion Rate</td>
                                        <td class="rpt-summary-val">
                                            {{ $totalOrders > 0
                                                ? round(($servedCount / $totalOrders) * 100)
                                                : 0 }}%
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>
        @endif

        {{-- ── FOOTER ── --}}
        <table class="rpt-footer">
            <tbody>
                <tr>
                    <td class="rpt-footer-left" style="width:60%;">
                        <strong>The Restaurant</strong>
                        &nbsp;&mdash;&nbsp;
                        Restaurant Management System
                        &nbsp;&copy;&nbsp;{{ date('Y') }}
                        <br>
                        <span class="rpt-confidential">Confidential</span>
                    </td>
                    <td class="rpt-footer-right" style="width:40%;">
                        <strong>Report ID:</strong>
                        RPT-{{ strtoupper(substr(md5(now()), 0, 8)) }}
                        <br>
                        Printed: {{ now()->format('d M Y h:i A') }}
                    </td>
                </tr>
            </tbody>
        </table>

    </div>{{-- /rpt-body --}}

</div>{{-- /rpt-page --}}
</body>
</html>