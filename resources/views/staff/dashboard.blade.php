@extends('layouts.staff')
@section('title', 'Kitchen Dashboard')
@section('page-title', 'Kitchen Dashboard')

@section('content')

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-shape icon-lg rounded-circle bg-warning-subtle">
                    <i class="ti ti-clock fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Pending</div>
                    <div class="fs-3 fw-bold text-warning">
                        {{ $pendingOrders->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-shape icon-lg rounded-circle bg-danger-subtle">
                    <i class="ti ti-flame fs-4 text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Cooking</div>
                    <div class="fs-3 fw-bold text-danger">
                        {{ $cookingOrders->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-shape icon-lg rounded-circle bg-success-subtle">
                    <i class="ti ti-circle-check fs-4 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Active</div>
                    <div class="fs-3 fw-bold text-success">
                        {{ $pendingOrders->count() + $cookingOrders->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    <!-- Pending Orders -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark d-flex
                        align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-clock me-2"></i>
                    Pending Orders ({{ $pendingOrders->count() }})
                </h6>
                <span class="badge bg-dark">New</span>
            </div>
            <div class="card-body p-0">
                @forelse($pendingOrders as $order)
                <div class="p-3 border-bottom order-card-pending">
                    <div class="d-flex justify-content-between
                                align-items-center mb-2">
                        <div class="fw-bold">
                            Order #{{ $order->id }}
                            <span class="badge bg-secondary ms-2">
                                {{ $order->table
                                    ? 'Table #'.$order->table->table_number
                                    : 'Takeaway' }}
                            </span>
                        </div>
                        <small class="text-muted">
                            {{ $order->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <ul class="list-unstyled mb-3 ps-1">
                        @foreach($order->orderItems as $item)
                        <li class="mb-1 d-flex align-items-center gap-2">
                            <span class="badge bg-warning-subtle
                                         text-warning-emphasis fw-bold">
                                x{{ $item->quantity }}
                            </span>
                            <span>{{ $item->menuItem->name }}</span>
                            @if($item->special_instructions)
                            <small class="text-warning">
                                — {{ $item->special_instructions }}
                            </small>
                            @endif
                        </li>
                        @endforeach
                    </ul>

                    @if($order->notes)
                    <div class="alert alert-warning py-1 px-2 mb-2 small">
                        <i class="ti ti-alert-triangle me-1"></i>
                        {{ $order->notes }}
                    </div>
                    @endif

                    <form method="POST"
                          action="{{ route('staff.orders.status', $order) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cooking">
                        <button type="submit"
                                class="btn btn-warning btn-sm w-100 fw-semibold">
                            <i class="ti ti-flame me-1"></i>
                            Start Cooking
                        </button>
                    </form>
                </div>
                @empty
                <div class="p-4 text-center text-muted">
                    <i class="ti ti-circle-check fs-1 text-success d-block mb-2"></i>
                    No pending orders
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Cooking Orders -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white d-flex
                        align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-flame me-2"></i>
                    Cooking ({{ $cookingOrders->count() }})
                </h6>
                <span class="badge bg-light text-danger">In Progress</span>
            </div>
            <div class="card-body p-0">
                @forelse($cookingOrders as $order)
                <div class="p-3 border-bottom order-card-cooking">
                    <div class="d-flex justify-content-between
                                align-items-center mb-2">
                        <div class="fw-bold">
                            Order #{{ $order->id }}
                            <span class="badge bg-secondary ms-2">
                                {{ $order->table
                                    ? 'Table #'.$order->table->table_number
                                    : 'Takeaway' }}
                            </span>
                        </div>
                        <small class="text-muted">
                            {{ $order->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <ul class="list-unstyled mb-3 ps-1">
                        @foreach($order->orderItems as $item)
                        <li class="mb-1 d-flex align-items-center gap-2">
                            <span class="badge bg-danger-subtle
                                         text-danger-emphasis fw-bold">
                                x{{ $item->quantity }}
                            </span>
                            <span>{{ $item->menuItem->name }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <form method="POST"
                          action="{{ route('staff.orders.status', $order) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ready">
                        <button type="submit"
                                class="btn btn-success btn-sm w-100 fw-semibold">
                            <i class="ti ti-check me-1"></i>
                            Mark as Ready
                        </button>
                    </form>
                </div>
                @empty
                <div class="p-4 text-center text-muted">
                    <i class="ti ti-flame fs-1 text-danger d-block mb-2"></i>
                    Nothing cooking right now
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection