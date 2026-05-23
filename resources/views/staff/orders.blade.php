@extends('layouts.staff')
@section('title', 'Live Orders')
@section('page-title', 'Live Order Queue')

@section('content')

<div class="row">
    @forelse($orders as $order)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow h-100
            {{ $order->status === 'pending'  ? 'border-left-warning' :
               ($order->status === 'cooking' ? 'border-left-danger'  :
                'border-left-success') }}">

            <div class="card-header d-flex justify-content-between
                        align-items-center
                {{ $order->status === 'pending'  ? 'bg-warning'  :
                   ($order->status === 'cooking' ? 'bg-danger'   :
                    'bg-success') }} text-white">
                <strong>Order #{{ $order->id }}</strong>
                <span>
                    {{ $order->table
                        ? 'Table #'.$order->table->table_number
                        : 'Takeaway' }}
                </span>
            </div>

            <div class="card-body">
                <p class="text-muted small mb-2">
                    <i class="fas fa-clock mr-1"></i>
                    {{ $order->created_at->diffForHumans() }}
                </p>
                <ul class="list-unstyled mb-3">
                    @foreach($order->orderItems as $item)
                    <li class="mb-1">
                        <span class="badge badge-secondary mr-1">
                            x{{ $item->quantity }}
                        </span>
                        {{ $item->menuItem->name }}
                        @if($item->special_instructions)
                        <br>
                        <small class="text-warning ml-3">
                            {{ $item->special_instructions }}
                        </small>
                        @endif
                    </li>
                    @endforeach
                </ul>

                @if($order->notes)
                <div class="alert alert-warning py-1 px-2 mb-3"
                     style="font-size:12px;">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    {{ $order->notes }}
                </div>
                @endif

                <form method="POST"
                      action="{{ route('staff.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-control form-control-sm mb-2">
                        @foreach(['pending','cooking','ready'] as $s)
                        <option value="{{ $s }}"
                            {{ $order->status === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="btn btn-sm btn-primary btn-block">
                        <i class="fas fa-sync mr-1"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-check-circle fa-3x mb-3 d-block text-success"></i>
                <h5>All caught up!</h5>
                <p>No active orders right now.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@push('scripts')
<script>
setTimeout(function(){ location.reload(); }, 20000);
</script>
@endpush

@endsection