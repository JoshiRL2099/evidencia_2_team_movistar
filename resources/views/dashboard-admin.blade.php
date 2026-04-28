@extends('layouts.app')

@section('page_title','ORDER DETAILS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="display-5 text-primary">Welcome back, {{ $user->full_name }}.</h1>
            <p class="text-muted">Here you will see a summary of your users' information.</p>
        </div>
    </div>

    {{-- Control Panel cards --}}
    <div class="row mt-4 g-3">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Pending orders</small>
                    <h2 class="mt-2">{{ $pendingOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">On Route</small>
                    <h2 class="mt-2">{{ $onRouteOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Delivered Today</small>
                    <h2 class="mt-2">{{ $deliveredToday }}</h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Out of Stock Materials</small>
                    <h2 class="mt-2">{{ $outOfStockItems }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Departments --}}
    <div class="row mt-4 g-3">
        <div class="col-12">
            <h5>Department</h5>
        </div>

        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-1">Sales</h6>
                    <p class="h5 mb-1">{{ $salesUsers }} active users</p>
                    <small class="text-muted">Taking customer orders</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-1">Purchasing</h6>
                    <p class="h5 mb-1">{{ $purchasingUsers }} active users</p>
                    <small class="text-muted">Manage the purchase of materials</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-1">Warehouse</h6>
                    <p class="h5 mb-1">{{ $warehouseUsers }} active users</p>
                    <small class="text-muted">Preparing orders</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-1">Route</h6>
                    <p class="h5 mb-1">{{ $routeUsers }} active users</p>
                    <small class="text-muted">Distributing orders</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent activity table --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                    <th>Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivity as $activity)
                                    <tr>
                                        <td>{{ $activity->changedBy->full_name ?? 'User' }}</td>
                                        <td>{{ $activity->order->invoice_number ?? 'N/A' }}</td>
                                        <td>{{ $activity->description ?? ("Change to \"".$activity->to_status."\"") }}</td>
                                        <td>{{ $activity->changed_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No recent activity.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm">Ver órdenes</a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Ver usuarios</a>
        </div>
    </div>

</div>

@endsection