@extends('layouts.admin')
@section('title', 'Table QR Code')
@section('page-title', 'Table QR Code')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body p-5">

                <h5 class="fw-bold mb-1">Table #{{ $table->table_number }}</h5>
                <p class="text-muted mb-4">
                    Capacity: {{ $table->capacity }} persons
                </p>

                <!-- QR Code -->
                <div style="background:#fff; padding:20px; display:inline-block;
                            border-radius:12px; margin-bottom:20px;">
                    {!! $qr !!}
                </div>

                <p class="text-muted small mb-4">
                    Scan to place order from this table
                </p>

                <div class="d-flex gap-2 justify-content-center">
                    <button onclick="window.print()"
                            class="btn btn-primary">
                        <i class="ti ti-printer me-1"></i>Print QR
                    </button>
                    <a href="{{ route('admin.tables.index') }}"
                       class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@media print {
    #miniSidebar, .navbar-glass, .btn,
    .page-breadcrumb { display:none !important; }
    .card { box-shadow:none !important; border:none !important; }
}
</style>
@endsection