<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservations Report — {{ now()->format('d M Y') }}</title>
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
        .rsv-page {
            width: 100%;
            max-width: 100%;
        }

        /* ══════════════════════════════════════════════════════════
           HEADER BAND
        ══════════════════════════════════════════════════════════ */
        .rsv-header {
            background: linear-gradient(135deg, #1a1f2e 0%, #0f1319 100%);
            padding: 28px 32px 22px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        .rsv-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -30px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(200,169,81,0.06);
        }

        .rsv-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: 100px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(200,169,81,0.04);
        }

        .rsv-header-table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            z-index: 1;
        }

        .rsv-header-table td {
            padding: 0;
            border: none;
            vertical-align: top;
        }

        .rsv-header-left  { width: 62%; }
        .rsv-header-right { width: 38%; text-align: right; }

        /* Gold accent bar */
        .rsv-gold-bar {
            width: 44px;
            height: 3px;
            background: linear-gradient(90deg, #c8a951, #e8c96a);
            border-radius: 2px;
            margin-bottom: 11px;
        }

        .rsv-brand {
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: rgba(200,169,81,0.65);
            margin-bottom: 6px;
        }

        .rsv-title {
            font-size: 21px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: -0.3px;
            margin-bottom: 4px;
        }

        .rsv-title span { color: #c8a951; }

        .rsv-subtitle {
            font-size: 9.5px;
            color: rgba(255,255,255,0.4);
        }

        /* Right meta block */
        .rsv-meta-item {
            font-size: 9px;
            color: rgba(255,255,255,0.38);
            margin-bottom: 5px;
            text-align: right;
        }

        .rsv-meta-item strong {
            display: block;
            color: rgba(255,255,255,0.72);
            font-size: 10px;
            margin-top: 1px;
        }

        /* Gold gradient border strip */
        .rsv-header-border {
            height: 4px;
            background: linear-gradient(90deg,
                #c8a951 0%,
                #e8c96a 40%,
                #c8a951 70%,
                rgba(200,169,81,0.15) 100%);
        }

        /* ══════════════════════════════════════════════════════════
           FILTER BANNER
        ══════════════════════════════════════════════════════════ */
        .rsv-filter-banner {
            background: rgba(200,169,81,0.07);
            border-left: 3px solid #c8a951;
            padding: 7px 32px;
            font-size: 9.5px;
            color: #6b7280;
            border-bottom: 1px solid rgba(200,169,81,0.15);
        }

        .rsv-filter-banner strong { color: #c8a951; }

        .rsv-filter-sep {
            color: #d1d5db;
            margin: 0 6px;
        }

        /* ══════════════════════════════════════════════════════════
           BODY
        ══════════════════════════════════════════════════════════ */
        .rsv-body {
            padding: 22px 32px 20px;
        }

        /* ══════════════════════════════════════════════════════════
           STAT CARDS
        ══════════════════════════════════════════════════════════ */
        .rsv-stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 20px;
        }

        .rsv-stats-table td {
            padding: 0;
            border: none;
            width: 20%;
            vertical-align: top;
        }

        .rsv-stat-card {
            border-radius: 8px;
            padding: 13px 11px 11px;
            text-align: center;
        }

        .rsv-stat-card--gold {
            background: #fffbf0;
            border: 1px solid rgba(200,169,81,0.25);
            border-top: 3px solid #c8a951;
        }

        .rsv-stat-card--green {
            background: #f0fdf4;
            border: 1px solid rgba(25,135,84,0.2);
            border-top: 3px solid #198754;
        }

        .rsv-stat-card--blue {
            background: #eff6ff;
            border: 1px solid rgba(37,99,235,0.2);
            border-top: 3px solid #2563eb;
        }

        .rsv-stat-card--orange {
            background: #fff7f0;
            border: 1px solid rgba(253,126,20,0.2);
            border-top: 3px solid #fd7e14;
        }

        .rsv-stat-card--red {
            background: #fff5f5;
            border: 1px solid rgba(220,53,69,0.2);
            border-top: 3px solid #dc3545;
        }

        .rsv-stat-num {
            font-size: 20px;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 5px;
            display: block;
        }

        .rsv-stat-card--gold   .rsv-stat-num { color: #c8a951; }
        .rsv-stat-card--green  .rsv-stat-num { color: #198754; }
        .rsv-stat-card--blue   .rsv-stat-num { color: #2563eb; }
        .rsv-stat-card--orange .rsv-stat-num { color: #fd7e14; }
        .rsv-stat-card--red    .rsv-stat-num { color: #dc3545; }

        .rsv-stat-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            display: block;
        }

        .rsv-stat-sub {
            font-size: 7.5px;
            color: #d1d5db;
            margin-top: 3px;
            display: block;
        }

        /* ══════════════════════════════════════════════════════════
           BREAKDOWN PANEL
        ══════════════════════════════════════════════════════════ */
        .rsv-breakdown {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-bottom: 20px;
        }

        .rsv-breakdown td {
            padding: 0;
            border: none;
            vertical-align: top;
        }

        .rsv-breakdown-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .rsv-breakdown-header {
            background: #f1f5f9;
            padding: 7px 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .rsv-breakdown-body { padding: 10px 12px; }

        /* Bar chart rows */
        .rsv-bar-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rsv-bar-table td {
            padding: 3px 0;
            border: none;
            vertical-align: middle;
            font-size: 9.5px;
        }

        .rsv-bar-key {
            width: 80px;
            color: #6b7280;
            font-weight: 600;
            white-space: nowrap;
        }

        .rsv-bar-wrap { width: 100%; padding: 0 8px; }

        .rsv-bar-track {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 99px;
            overflow: hidden;
        }

        .rsv-bar-fill { height: 100%; border-radius: 99px; }

        .rsv-bar-fill--gold   { background: #c8a951; }
        .rsv-bar-fill--green  { background: #198754; }
        .rsv-bar-fill--blue   { background: #2563eb; }
        .rsv-bar-fill--orange { background: #fd7e14; }
        .rsv-bar-fill--red    { background: #dc3545; }
        .rsv-bar-fill--gray   { background: #6c757d; }

        .rsv-bar-count {
            width: 55px;
            text-align: right;
            color: #374151;
            font-weight: bold;
            white-space: nowrap;
            font-size: 9px;
        }

        /* Time distribution mini-grid */
        .rsv-time-grid {
            display: table;
            width: 100%;
        }

        .rsv-time-slot {
            display: table-cell;
            text-align: center;
            padding: 4px 3px;
            border-right: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .rsv-time-slot:last-child { border-right: none; }

        .rsv-time-slot-time {
            font-size: 7.5px;
            color: #9ca3af;
            font-weight: bold;
            text-transform: uppercase;
            display: block;
            margin-bottom: 3px;
        }

        .rsv-time-slot-count {
            font-size: 12px;
            font-weight: bold;
            color: #c8a951;
            display: block;
        }

        .rsv-time-slot-bar {
            width: 100%;
            height: 3px;
            background: #e5e7eb;
            border-radius: 99px;
            margin-top: 4px;
            overflow: hidden;
        }

        .rsv-time-slot-fill {
            height: 100%;
            background: #c8a951;
            border-radius: 99px;
        }

        /* ══════════════════════════════════════════════════════════
           MAIN TABLE
        ══════════════════════════════════════════════════════════ */
        .rsv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        /* Column widths */
        .rsv-table .col-id    { width: 5%; }
        .rsv-table .col-name  { width: 16%; }
        .rsv-table .col-phone { width: 11%; }
        .rsv-table .col-table { width: 7%; }
        .rsv-table .col-date  { width: 11%; }
        .rsv-table .col-time  { width: 8%; }
        .rsv-table .col-dur   { width: 7%; }
        .rsv-table .col-pax   { width: 7%; }
        .rsv-table .col-dep   { width: 8%; }
        .rsv-table .col-stat  { width: 9%; }
        .rsv-table .col-notes { width: 11%; }

        /* Head */
        .rsv-table thead tr {
            background: #1a1f2e;
        }

        .rsv-table thead th {
            padding: 9px 9px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.7);
            text-align: left;
            border: none;
            white-space: nowrap;
        }

        .rsv-table thead th:first-child { border-radius: 5px 0 0 0; }
        .rsv-table thead th:last-child  { border-radius: 0 5px 0 0; }

        /* Gold accent strip under header */
        .rsv-thead-strip td {
            height: 2px;
            padding: 0 !important;
            border: none !important;
            background: linear-gradient(90deg,
                #c8a951 0%,
                rgba(200,169,81,0.25) 100%);
        }

        /* Body */
        .rsv-table tbody tr { border-bottom: 1px solid #f3f4f6; }
        .rsv-table tbody tr:nth-child(odd)  { background: #ffffff; }
        .rsv-table tbody tr:nth-child(even) { background: #f9fafb; }
        .rsv-table tbody tr.rsv-row--today  { background: #fffbf0; }

        .rsv-table tbody td {
            padding: 7px 9px;
            font-size: 10px;
            color: #374151;
            border: none;
            vertical-align: middle;
        }

        /* ID pill */
        .rsv-id-pill {
            font-family: 'Courier New', monospace;
            font-size: 9.5px;
            font-weight: bold;
            color: #c8a951;
            background: rgba(200,169,81,0.09);
            border: 1px solid rgba(200,169,81,0.22);
            border-radius: 4px;
            padding: 2px 5px;
            white-space: nowrap;
        }

        /* Guest name */
        .rsv-guest-name {
            font-weight: 700;
            color: #1f2937;
            font-size: 10.5px;
            display: block;
        }

        .rsv-guest-email {
            font-size: 8.5px;
            color: #9ca3af;
            margin-top: 1px;
            display: block;
        }

        /* Phone */
        .rsv-phone {
            font-size: 10px;
            color: #4b5563;
            white-space: nowrap;
        }

        /* Table number */
        .rsv-table-num {
            display: inline-block;
            padding: 2px 7px;
            background: rgba(37,99,235,0.08);
            border: 1px solid rgba(37,99,235,0.18);
            border-radius: 4px;
            font-weight: bold;
            font-size: 9.5px;
            color: #2563eb;
            white-space: nowrap;
        }

        .rsv-table-capacity {
            font-size: 8px;
            color: #9ca3af;
            margin-top: 1px;
            display: block;
            text-align: center;
        }

        /* Date cell */
        .rsv-date-primary {
            font-weight: 600;
            color: #1f2937;
            font-size: 10px;
            display: block;
        }

        .rsv-date-day {
            font-size: 8px;
            color: #9ca3af;
            margin-top: 1px;
            display: block;
        }

        .rsv-date-today {
            font-size: 7.5px;
            font-weight: bold;
            color: #c8a951;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* Time */
        .rsv-time-val {
            font-weight: 700;
            color: #1f2937;
            font-size: 10.5px;
            white-space: nowrap;
        }

        .rsv-time-period {
            font-size: 8px;
            color: #9ca3af;
        }

        /* Pax / guests */
        .rsv-pax {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-weight: bold;
            color: #374151;
            font-size: 10.5px;
        }

        .rsv-pax-icon {
            font-size: 9px;
            color: #9ca3af;
        }

        /* Deposit */
        .rsv-deposit-paid {
            color: #198754;
            font-weight: bold;
            font-size: 10px;
        }

        .rsv-deposit-none {
            color: #d1d5db;
            font-size: 10px;
        }

        /* Status badges */
        .rsv-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            white-space: nowrap;
        }

        .rsv-badge--confirmed {
            background: rgba(25,135,84,0.1);
            color: #198754;
            border: 1px solid rgba(25,135,84,0.25);
        }

        .rsv-badge--pending {
            background: rgba(255,193,7,0.12);
            color: #b45309;
            border: 1px solid rgba(255,193,7,0.35);
        }

        .rsv-badge--cancelled {
            background: rgba(220,53,69,0.08);
            color: #dc3545;
            border: 1px solid rgba(220,53,69,0.2);
        }

        .rsv-badge--completed {
            background: rgba(108,117,125,0.1);
            color: #6c757d;
            border: 1px solid rgba(108,117,125,0.2);
        }

        .rsv-badge--seated {
            background: rgba(37,99,235,0.1);
            color: #2563eb;
            border: 1px solid rgba(37,99,235,0.2);
        }

        .rsv-badge--no-show {
            background: rgba(239,68,68,0.07);
            color: #b91c1c;
            border: 1px solid rgba(239,68,68,0.18);
        }

        /* Notes */
        .rsv-notes {
            font-size: 9.5px;
            color: #6b7280;
            font-style: italic;
            max-width: 110px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rsv-notes-none {
            color: #e5e7eb;
            font-size: 9.5px;
        }

        /* Empty state */
        .rsv-empty td {
            text-align: center;
            padding: 32px 0;
            color: #9ca3af;
            font-style: italic;
            border: none;
        }

        /* ══════════════════════════════════════════════════════════
           TOTALS ROW
        ══════════════════════════════════════════════════════════ */
        .rsv-totals-row {
            background: #1a1f2e !important;
            border: none !important;
        }

        .rsv-totals-row td {
            padding: 8px 9px !important;
            border: none !important;
            font-size: 8.5px !important;
            font-weight: bold !important;
            color: rgba(255,255,255,0.45) !important;
            text-transform: uppercase !important;
            letter-spacing: 0.06em !important;
            vertical-align: middle !important;
        }

        .rsv-totals-gold {
            color: #c8a951 !important;
            font-size: 11px !important;
        }

        /* ══════════════════════════════════════════════════════════
           BOTTOM SUMMARY BOXES
        ══════════════════════════════════════════════════════════ */
        .rsv-summary-wrap {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-top: 18px;
        }

        .rsv-summary-wrap td {
            padding: 0;
            border: none;
            vertical-align: top;
        }

        .rsv-summary-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .rsv-summary-box-header {
            background: #f1f5f9;
            padding: 7px 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .rsv-summary-box-body { padding: 9px 12px; }

        .rsv-summary-rows {
            width: 100%;
            border-collapse: collapse;
        }

        .rsv-summary-rows td {
            padding: 4px 0;
            font-size: 9.5px;
            border: none;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .rsv-summary-rows tr:last-child td { border-bottom: none; }

        .rsv-sum-key {
            color: #6b7280;
            width: 58%;
        }

        .rsv-sum-val {
            text-align: right;
            font-weight: bold;
            color: #1f2937;
            width: 42%;
            white-space: nowrap;
        }

        .rsv-sum-val--gold   { color: #c8a951; }
        .rsv-sum-val--green  { color: #198754; }
        .rsv-sum-val--red    { color: #dc3545; }
        .rsv-sum-val--orange { color: #fd7e14; }
        .rsv-sum-val--blue   { color: #2563eb; }
        .rsv-sum-val--gray   { color: #6c757d; }

        /* ══════════════════════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════════════════════ */
        .rsv-footer {
            width: 100%;
            border-collapse: collapse;
            margin-top: 22px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }

        .rsv-footer td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .rsv-footer-left {
            font-size: 8.5px;
            color: #9ca3af;
            width: 60%;
        }

        .rsv-footer-left strong { color: #c8a951; }

        .rsv-footer-right {
            text-align: right;
            font-size: 8px;
            color: #d1d5db;
            width: 40%;
        }

        .rsv-footer-right strong { color: #9ca3af; }

        .rsv-confidential {
            display: inline-block;
            padding: 2px 7px;
            border: 1px solid #e5e7eb;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #d1d5db;
            margin-top: 3px;
        }

        /* ══════════════════════════════════════════════════════════
           PRINT
        ══════════════════════════════════════════════════════════ */
        @media print {
            body    { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .rsv-page { padding: 0; }
        }

    </style>
</head>
<body>
<div class="rsv-page">

    {{-- ══════════════════════════
         HEADER
    ══════════════════════════ --}}
    <div class="rsv-header">
        <table class="rsv-header-table">
            <tbody>
                <tr>
                    <td class="rsv-header-left">
                        <div class="rsv-gold-bar"></div>
                        <div class="rsv-brand">Restaurant Management System</div>
                        <div class="rsv-title">
                            Reservations <span>Report</span>
                        </div>
                        <div class="rsv-subtitle">
                            Guest booking log with status &amp; seating summary
                        </div>
                    </td>
                    <td class="rsv-header-right">
                        <div class="rsv-meta-item">
                            Generated on
                            <strong>{{ now()->format('d M Y, h:i A') }}</strong>
                        </div>
                        <div class="rsv-meta-item">
                            Total Reservations
                            <strong>{{ $reservations->count() }}</strong>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="rsv-header-border"></div>

    {{-- ══════════════════════════
         FILTER BANNER
    ══════════════════════════ --}}
    @if(!empty($filters['date_from']) || !empty($filters['date_to']) || !empty($filters['status']))
    <div class="rsv-filter-banner">
        <strong>Filters Applied:</strong>
        @if(!empty($filters['date_from']) || !empty($filters['date_to']))
            <span class="rsv-filter-sep">|</span>
            <strong>Period:</strong>
            {{ !empty($filters['date_from'])
                ? \Carbon\Carbon::parse($filters['date_from'])->format('d M Y')
                : 'Beginning' }}
            &mdash;
            {{ !empty($filters['date_to'])
                ? \Carbon\Carbon::parse($filters['date_to'])->format('d M Y')
                : 'Today' }}
        @endif
        @if(!empty($filters['status']))
            <span class="rsv-filter-sep">|</span>
            <strong>Status:</strong> {{ ucfirst($filters['status']) }}
        @endif
    </div>
    @endif

    {{-- ══════════════════════════
         BODY
    ══════════════════════════ --}}
    <div class="rsv-body">

        @php
            /* ── Aggregates ── */
            $total          = $reservations->count();
            $confirmed      = $reservations->where('status','confirmed')->count();
            $pending        = $reservations->where('status','pending')->count();
            $cancelled      = $reservations->where('status','cancelled')->count();
            $completed      = $reservations->where('status','completed')->count();
            $seated         = $reservations->where('status','seated')->count();
            $noShow         = $reservations->where('status','no_show')->count();
            $totalGuests    = $reservations->sum('guests_count');
            $avgGuests      = $total > 0 ? round($reservations->avg('guests_count'), 1) : 0;
            $todayStr       = now()->format('Y-m-d');
            $todayCount     = $reservations->filter(fn($r) =>
                                \Carbon\Carbon::parse($r->reservation_date)->format('Y-m-d') === $todayStr
                              )->count();
            $depositTotal   = $reservations->sum('deposit_amount');

            /* Bar scale */
            $maxBar = max($confirmed, $pending, $cancelled, $completed, $seated, $noShow, 1);

            /* Time-slot buckets */
            $slots = [
                'Morning'   => ['range' => '06–11', 'count' => 0],
                'Lunch'     => ['range' => '11–14', 'count' => 0],
                'Afternoon' => ['range' => '14–17', 'count' => 0],
                'Evening'   => ['range' => '17–20', 'count' => 0],
                'Night'     => ['range' => '20–24', 'count' => 0],
            ];

            foreach ($reservations as $r) {
                $h = (int) substr($r->reservation_time, 0, 2);
                if      ($h >= 6  && $h < 11) $slots['Morning']['count']++;
                elseif  ($h >= 11 && $h < 14) $slots['Lunch']['count']++;
                elseif  ($h >= 14 && $h < 17) $slots['Afternoon']['count']++;
                elseif  ($h >= 17 && $h < 20) $slots['Evening']['count']++;
                else                           $slots['Night']['count']++;
            }

            $maxSlot = max(array_column($slots, 'count') ?: [1]);
        @endphp

        {{-- ── STAT CARDS ── --}}
        <table class="rsv-stats-table">
            <tbody>
                <tr>
                    <td>
                        <div class="rsv-stat-card rsv-stat-card--gold">
                            <span class="rsv-stat-num">{{ $total }}</span>
                            <span class="rsv-stat-label">Total</span>
                            <span class="rsv-stat-sub">All reservations</span>
                        </div>
                    </td>
                    <td>
                        <div class="rsv-stat-card rsv-stat-card--green">
                            <span class="rsv-stat-num">{{ $confirmed }}</span>
                            <span class="rsv-stat-label">Confirmed</span>
                            <span class="rsv-stat-sub">
                                {{ $total > 0 ? round(($confirmed / $total) * 100) : 0 }}% of total
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="rsv-stat-card rsv-stat-card--blue">
                            <span class="rsv-stat-num">{{ $totalGuests }}</span>
                            <span class="rsv-stat-label">Total Guests</span>
                            <span class="rsv-stat-sub">Avg {{ $avgGuests }} / booking</span>
                        </div>
                    </td>
                    <td>
                        <div class="rsv-stat-card rsv-stat-card--orange">
                            <span class="rsv-stat-num">{{ $pending }}</span>
                            <span class="rsv-stat-label">Pending</span>
                            <span class="rsv-stat-sub">Awaiting confirmation</span>
                        </div>
                    </td>
                    <td>
                        <div class="rsv-stat-card rsv-stat-card--red">
                            <span class="rsv-stat-num">{{ $cancelled }}</span>
                            <span class="rsv-stat-label">Cancelled</span>
                            <span class="rsv-stat-sub">
                                {{ $total > 0 ? round(($cancelled / $total) * 100) : 0 }}% of total
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- ── BREAKDOWN PANEL ── --}}
        <table class="rsv-breakdown">
            <tbody>
                <tr>

                    {{-- Status bar chart --}}
                    <td style="width:50%;">
                        <div class="rsv-breakdown-box">
                            <div class="rsv-breakdown-header">
                                Status Breakdown
                            </div>
                            <div class="rsv-breakdown-body">
                                <table class="rsv-bar-table">
                                    <tbody>
                                        <tr>
                                            <td class="rsv-bar-key">Confirmed</td>
                                            <td class="rsv-bar-wrap">
                                                <div class="rsv-bar-track">
                                                    <div class="rsv-bar-fill rsv-bar-fill--green"
                                                         style="width:{{ $maxBar > 0 ? round(($confirmed/$maxBar)*100) : 0 }}%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="rsv-bar-count">{{ $confirmed }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rsv-bar-key">Completed</td>
                                            <td class="rsv-bar-wrap">
                                                <div class="rsv-bar-track">
                                                    <div class="rsv-bar-fill rsv-bar-fill--gold"
                                                         style="width:{{ $maxBar > 0 ? round(($completed/$maxBar)*100) : 0 }}%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="rsv-bar-count">{{ $completed }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rsv-bar-key">Seated</td>
                                            <td class="rsv-bar-wrap">
                                                <div class="rsv-bar-track">
                                                    <div class="rsv-bar-fill rsv-bar-fill--blue"
                                                         style="width:{{ $maxBar > 0 ? round(($seated/$maxBar)*100) : 0 }}%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="rsv-bar-count">{{ $seated }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rsv-bar-key">Pending</td>
                                            <td class="rsv-bar-wrap">
                                                <div class="rsv-bar-track">
                                                    <div class="rsv-bar-fill rsv-bar-fill--orange"
                                                         style="width:{{ $maxBar > 0 ? round(($pending/$maxBar)*100) : 0 }}%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="rsv-bar-count">{{ $pending }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rsv-bar-key">Cancelled</td>
                                            <td class="rsv-bar-wrap">
                                                <div class="rsv-bar-track">
                                                    <div class="rsv-bar-fill rsv-bar-fill--red"
                                                         style="width:{{ $maxBar > 0 ? round(($cancelled/$maxBar)*100) : 0 }}%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="rsv-bar-count">{{ $cancelled }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rsv-bar-key">No-Show</td>
                                            <td class="rsv-bar-wrap">
                                                <div class="rsv-bar-track">
                                                    <div class="rsv-bar-fill rsv-bar-fill--gray"
                                                         style="width:{{ $maxBar > 0 ? round(($noShow/$maxBar)*100) : 0 }}%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="rsv-bar-count">{{ $noShow }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>

                    {{-- Time-slot distribution --}}
                    <td style="width:50%;">
                        <div class="rsv-breakdown-box">
                            <div class="rsv-breakdown-header">
                                Bookings by Time of Day
                            </div>
                            <div class="rsv-breakdown-body">
                                <table style="width:100%;border-collapse:collapse;">
                                    <tbody>
                                        <tr>
                                            @foreach($slots as $slotName => $slot)
                                            <td style="text-align:center;
                                                       padding:4px 3px;
                                                       border-right:1px solid #e5e7eb;
                                                       vertical-align:bottom;
                                                       border-bottom:none;
                                                       {{ $loop->last ? 'border-right:none;' : '' }}">
                                                <span style="font-size:13px;
                                                             font-weight:bold;
                                                             color:#c8a951;
                                                             display:block;">
                                                    {{ $slot['count'] }}
                                                </span>
                                                <span style="font-size:7px;
                                                             color:#9ca3af;
                                                             font-weight:bold;
                                                             text-transform:uppercase;
                                                             letter-spacing:0.06em;
                                                             display:block;
                                                             margin-bottom:4px;">
                                                    {{ $slotName }}
                                                </span>
                                                <div style="width:100%;
                                                            height:4px;
                                                            background:#e5e7eb;
                                                            border-radius:99px;
                                                            overflow:hidden;">
                                                    <div style="width:{{ $maxSlot > 0 ? round(($slot['count']/$maxSlot)*100) : 0 }}%;
                                                                height:100%;
                                                                background:#c8a951;
                                                                border-radius:99px;">
                                                    </div>
                                                </div>
                                                <span style="font-size:7px;
                                                             color:#d1d5db;
                                                             display:block;
                                                             margin-top:3px;">
                                                    {{ $slot['range'] }}h
                                                </span>
                                            </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>

        {{-- ── MAIN RESERVATIONS TABLE ── --}}
        <table class="rsv-table">
            <thead>
                <tr>
                    <th class="col-id">Ref</th>
                    <th class="col-name">Guest</th>
                    <th class="col-phone">Phone</th>
                    <th class="col-table">Table</th>
                    <th class="col-date">Date</th>
                    <th class="col-time">Time</th>
                    <th class="col-pax">Guests</th>
                    <th class="col-dep">Deposit</th>
                    <th class="col-stat">Status</th>
                    <th class="col-notes">Notes</th>
                </tr>
                <tr class="rsv-thead-strip">
                    <td colspan="10"></td>
                </tr>
            </thead>
            <tbody>

                @forelse($reservations as $res)
                @php
                    $resDate  = \Carbon\Carbon::parse($res->reservation_date);
                    $isToday  = $resDate->isToday();
                    $isPast   = $resDate->isPast() && !$isToday;

                    $badgeClass = match($res->status) {
                        'confirmed' => 'rsv-badge--confirmed',
                        'pending'   => 'rsv-badge--pending',
                        'cancelled' => 'rsv-badge--cancelled',
                        'completed' => 'rsv-badge--completed',
                        'seated'    => 'rsv-badge--seated',
                        'no_show'   => 'rsv-badge--no-show',
                        default     => 'rsv-badge--pending',
                    };

                    $badgeLabel = match($res->status) {
                        'no_show'  => 'No-Show',
                        'seated'   => 'Seated',
                        default    => ucfirst($res->status),
                    };
                @endphp

                <tr class="{{ $isToday ? 'rsv-row--today' : '' }}">

                    {{-- Ref ID --}}
                    <td>
                        <span class="rsv-id-pill">
                            #{{ str_pad($res->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>

                    {{-- Guest --}}
                    <td>
                        <span class="rsv-guest-name">
                            {{ $res->guest_name }}
                        </span>
                        @if(!empty($res->guest_email))
                        <span class="rsv-guest-email">
                            {{ $res->guest_email }}
                        </span>
                        @endif
                    </td>

                    {{-- Phone --}}
                    <td>
                        <span class="rsv-phone">
                            {{ $res->guest_phone ?? '—' }}
                        </span>
                    </td>

                    {{-- Table --}}
                    <td>
                        @if($res->table)
                            <span class="rsv-table-num">
                                T&nbsp;#{{ $res->table->table_number }}
                            </span>
                            @if(!empty($res->table->capacity))
                            <span class="rsv-table-capacity">
                                cap. {{ $res->table->capacity }}
                            </span>
                            @endif
                        @else
                            <span style="color:#d1d5db;">—</span>
                        @endif
                    </td>

                    {{-- Date --}}
                    <td>
                        <span class="rsv-date-primary">
                            {{ $resDate->format('d M Y') }}
                        </span>
                        <span class="rsv-date-day">
                            @if($isToday)
                                <span class="rsv-date-today">Today</span>
                            @else
                                {{ $resDate->format('l') }}
                            @endif
                        </span>
                    </td>

                    {{-- Time --}}
                    <td>
                        @php
                            $timeParsed = \Carbon\Carbon::parse($res->reservation_time);
                        @endphp
                        <span class="rsv-time-val">
                            {{ $timeParsed->format('h:i') }}
                        </span>
                        <span class="rsv-time-period">
                            {{ $timeParsed->format('A') }}
                        </span>
                    </td>

                    {{-- Guests --}}
                    <td>
                        <span class="rsv-pax">
                            {{ $res->guests_count }}
                            <span class="rsv-pax-icon">pax</span>
                        </span>
                    </td>

                    {{-- Deposit --}}
                    <td>
                        @if(!empty($res->deposit_amount) && $res->deposit_amount > 0)
                            <span class="rsv-deposit-paid">
                                Rs.{{ number_format($res->deposit_amount, 0) }}
                            </span>
                        @else
                            <span class="rsv-deposit-none">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="rsv-badge {{ $badgeClass }}">
                            {{ $badgeLabel }}
                        </span>
                    </td>

                    {{-- Notes --}}
                    <td>
                        @if(!empty($res->notes))
                            <span class="rsv-notes" title="{{ $res->notes }}">
                                {{ Str::limit($res->notes, 28) }}
                            </span>
                        @else
                            <span class="rsv-notes-none">—</span>
                        @endif
                    </td>

                </tr>

                @empty
                <tr class="rsv-empty">
                    <td colspan="10">
                        No reservations found for the selected period.
                    </td>
                </tr>
                @endforelse

                {{-- Totals row --}}
                @if($reservations->count() > 0)
                <tr class="rsv-totals-row">
                    <td colspan="6"
                        style="text-align:right;
                               padding-right:10px !important;
                               color:rgba(255,255,255,0.35) !important;
                               font-size:8px !important;
                               letter-spacing:0.1em !important;">
                        Totals
                    </td>
                    <td>
                        <span class="rsv-totals-gold">
                            {{ $totalGuests }} pax
                        </span>
                    </td>
                    <td>
                        @if($depositTotal > 0)
                        <span class="rsv-totals-gold">
                            Rs.{{ number_format($depositTotal, 0) }}
                        </span>
                        @else
                        <span style="color:rgba(255,255,255,0.2) !important;">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="color:rgba(255,255,255,0.4) !important;
                                     font-size:8px !important;">
                            {{ $confirmed }} confirmed
                        </span>
                    </td>
                    <td></td>
                </tr>
                @endif

            </tbody>
        </table>

        {{-- ── SUMMARY BOXES ── --}}
        @if($reservations->count() > 0)
        <table class="rsv-summary-wrap">
            <tbody>
                <tr>

                    {{-- Booking Summary --}}
                    <td style="width:33.3%;">
                        <div class="rsv-summary-box">
                            <div class="rsv-summary-box-header">
                                Booking Summary
                            </div>
                            <div class="rsv-summary-box-body">
                                <table class="rsv-summary-rows">
                                    <tr>
                                        <td class="rsv-sum-key">Total Bookings</td>
                                        <td class="rsv-sum-val rsv-sum-val--gold">{{ $total }}</td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Confirmed</td>
                                        <td class="rsv-sum-val rsv-sum-val--green">{{ $confirmed }}</td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Pending Approval</td>
                                        <td class="rsv-sum-val rsv-sum-val--orange">{{ $pending }}</td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Cancelled</td>
                                        <td class="rsv-sum-val rsv-sum-val--red">{{ $cancelled }}</td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">No-Shows</td>
                                        <td class="rsv-sum-val rsv-sum-val--gray">{{ $noShow }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>

                    {{-- Guest Summary --}}
                    <td style="width:33.3%;">
                        <div class="rsv-summary-box">
                            <div class="rsv-summary-box-header">
                                Guest Summary
                            </div>
                            <div class="rsv-summary-box-body">
                                <table class="rsv-summary-rows">
                                    <tr>
                                        <td class="rsv-sum-key">Total Guests Expected</td>
                                        <td class="rsv-sum-val rsv-sum-val--blue">{{ $totalGuests }}</td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Avg Guests / Booking</td>
                                        <td class="rsv-sum-val">{{ $avgGuests }}</td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Today's Reservations</td>
                                        <td class="rsv-sum-val rsv-sum-val--gold">{{ $todayCount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Completion Rate</td>
                                        <td class="rsv-sum-val rsv-sum-val--green">
                                            {{ $total > 0 ? round((($completed + $seated) / $total) * 100) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Cancellation Rate</td>
                                        <td class="rsv-sum-val rsv-sum-val--red">
                                            {{ $total > 0 ? round(($cancelled / $total) * 100) : 0 }}%
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>

                    {{-- Deposit Summary --}}
                    <td style="width:33.3%;">
                        <div class="rsv-summary-box">
                            <div class="rsv-summary-box-header">
                                Deposit Summary
                            </div>
                            <div class="rsv-summary-box-body">
                                <table class="rsv-summary-rows">
                                    <tr>
                                        <td class="rsv-sum-key">Total Deposits Collected</td>
                                        <td class="rsv-sum-val rsv-sum-val--green">
                                            Rs.{{ number_format($depositTotal, 0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Bookings with Deposit</td>
                                        <td class="rsv-sum-val">
                                            {{ $reservations->where('deposit_amount', '>', 0)->count() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Bookings without Deposit</td>
                                        <td class="rsv-sum-val rsv-sum-val--orange">
                                            {{ $reservations->where('deposit_amount', '<=', 0)
                                                             ->orWhereNull('deposit_amount')
                                                             ->count() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Avg Deposit / Booking</td>
                                        <td class="rsv-sum-val">
                                            Rs.{{ $total > 0 ? number_format($depositTotal / $total, 0) : 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="rsv-sum-key">Seated Now</td>
                                        <td class="rsv-sum-val rsv-sum-val--blue">{{ $seated }}</td>
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
        <table class="rsv-footer">
            <tbody>
                <tr>
                    <td class="rsv-footer-left">
                        <strong>The Restaurant</strong>
                        &nbsp;&mdash;&nbsp;
                        Restaurant Management System
                        &nbsp;&copy;&nbsp;{{ date('Y') }}
                        <br>
                        <span class="rsv-confidential">Confidential</span>
                    </td>
                    <td class="rsv-footer-right">
                        <strong>Report ID:</strong>
                        RSV-{{ strtoupper(substr(md5(now()), 0, 8)) }}
                        <br>
                        Printed: {{ now()->format('d M Y, h:i A') }}
                    </td>
                </tr>
            </tbody>
        </table>

    </div>{{-- /rsv-body --}}

</div>{{-- /rsv-page --}}
</body>
</html>