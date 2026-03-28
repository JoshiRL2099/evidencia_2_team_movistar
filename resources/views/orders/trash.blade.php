@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Papelera de Órdenes</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3">Volver</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Eliminada el</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->invoice_number }}</td>
                        <td>{{ $order->customer->display_name ?? 'N/A' }}</td>
                        <td>{{ $order->createdBy->full_name ?? 'N/A' }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->deleted_at }}</td>
                        <td>
                            <form action="{{ route('orders.restore', $order->order_id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Restaurar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay órdenes en la papelera.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection