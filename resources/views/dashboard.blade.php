@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Row -->
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">

    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Pending Orders</p>
                        <h4 class="my-1 text-warning">
                            {{ $stats['pending_orders'] }}
                        </h4>
                        <p class="mb-0 font-13">
                            <a href="{{ route('admin.orders.index') }}">
                                View all orders
                            </a>
                        </p>
                    </div>
                    <div class="ms-auto">
                        <i class="fas fa-clock fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Orders</p>
                        <h4 class="my-1 text-primary">
                            {{ $stats['total_orders'] }}
                        </h4>
                        <p class="mb-0 font-13">All time orders</p>
                    </div>
                    <div class="ms-auto">
                        <i class="fas fa-shopping-cart fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Reservations</p>
                        <h4 class="my-1 text-info">
                            {{ $stats['total_reservations'] }}
                        </h4>
                        <p class="mb-0 font-13">
                            <a href="{{ route('admin.reservations.index') }}">
                                View all
                            </a>
                        </p>
                    </div>
                    <div class="ms-auto">
                        <i class="fas fa-calendar fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Today Revenue</p>
                        <h4 class="my-1 text-success">
                            Rs.{{ number_format($stats['today_revenue'], 0) }}
                        </h4>
                        <p class="mb-0 font-13">Paid orders today</p>
                    </div>
                    <div class="ms-auto">
                        <i class="fas fa-money-bill fa-2x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Menu Items</p>
                        <h4 class="my-1 text-danger">
                            {{ $stats['total_menu_items'] }}
                        </h4>
                        <p class="mb-0 font-13">
                            <a href="{{ route('admin.menu.index') }}">
                                Manage menu
                            </a>
                        </p>
                    </div>
                    <div class="ms-auto">
                        <i class="fas fa-hamburger fa-2x text-danger opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-secondary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Users</p>
                        <h4 class="my-1">{{ $stats['total_users'] }}</h4>
                        <p class="mb-0 font-13">Registered users</p>
                    </div>
                    <div class="ms-auto">
                        <i class="fas fa-users fa-2x text-secondary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Recent Orders + Reservations -->
<div class="row">

    <!-- Recent Orders -->
    <div class="col-lg-7 mb-4">
        <div class="card radius-10">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Recent Orders</h5>
                <div class="ms-auto">
                    <a href="{{ route('admin.orders.index') }}"
                       class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Table</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                                <td>
                                    {{ $order->table
                                        ? 'T#'.$order->table->table_number
                                        : 'Takeaway' }}
                                </td>
                                <td>
                                    Rs.{{ number_format($order->total_amount,0) }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    No orders yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reservations -->
    <div class="col-lg-5 mb-4">
        <div class="card radius-10">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Recent Reservations</h5>
                <div class="ms-auto">
                    <a href="{{ route('admin.reservations.index') }}"
                       class="btn btn-sm btn-info">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Guest</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReservations as $res)
                            <tr>
                                <td>
                                    <strong>{{ $res->guest_name }}</strong><br>
                                    <small class="text-muted">
                                        {{ $res->guest_phone }}
                                    </small>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($res->reservation_date)
                                        ->format('d M') }}<br>
                                    <small>{{ $res->reservation_time }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{
                                        $res->status === 'confirmed'  ? 'success' :
                                        ($res->status === 'pending'   ? 'warning' :
                                        ($res->status === 'completed' ? 'info'    :
                                         'danger')) }}">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No reservations yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Quick Actions -->
<div class="card radius-10">
    <div class="card-header">
        <h5 class="mb-0">Quick Actions</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-outline-primary me-2 mb-2">
            <i class="fas fa-plus me-1"></i>Add Category
        </a>
        <a href="{{ route('admin.menu.create') }}"
           class="btn btn-outline-success me-2 mb-2">
            <i class="fas fa-plus me-1"></i>Add Menu Item
        </a>
        <a href="{{ route('admin.tables.create') }}"
           class="btn btn-outline-info me-2 mb-2">
            <i class="fas fa-plus me-1"></i>Add Table
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="btn btn-outline-warning me-2 mb-2">
            <i class="fas fa-eye me-1"></i>All Orders
        </a>
        <a href="{{ route('admin.reservations.index') }}"
           class="btn btn-outline-danger me-2 mb-2">
            <i class="fas fa-calendar me-1"></i>Reservations
        </a>
    </div>
</div>

@endsection