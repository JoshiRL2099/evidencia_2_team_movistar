@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Detalle de la Orden</h2>

        <p><strong>Factura:</strong> {{ $order->invoice_number }}</p>
        <p><strong>Cliente:</strong> {{ $order->customer->display_name ?? 'N/A' }}</p>
        <p><strong>Usuario:</strong> {{ $order->createdBy->full_name ?? 'N/A' }}</p>
        <p><strong>Fecha:</strong> {{ $order->order_datetime }}</p>
        <p><strong>Estado:</strong> {{ $order->status }}</p>
        <p><strong>Notas:</strong> {{ $order->notes ?? 'Sin notas' }}</p>

        <hr>

        <h4>Dirección de entrega</h4>
        @if($order->deliveryAddress)
            <p>
                {{ $order->deliveryAddress->street }}
                #{{ $order->deliveryAddress->ext_number }}
                @if($order->deliveryAddress->int_number)
                    Int. {{ $order->deliveryAddress->int_number }}
                @endif
            </p>
            <p>{{ $order->deliveryAddress->neighborhood }}, {{ $order->deliveryAddress->city }},
                {{ $order->deliveryAddress->state }}</p>
            <p>CP {{ $order->deliveryAddress->zip }}</p>
            <p><strong>Referencias:</strong> {{ $order->deliveryAddress->references ?? 'N/A' }}</p>
        @else
            <p>No hay dirección registrada.</p>
        @endif

        <hr>

        <h4>Materiales</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Precio Unitario</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->unit ?? 'N/A' }}</td>
                        <td>${{ number_format($item->unit_price ?? 0, 2) }}</td>
                        <td>${{ number_format($item->quantity * ($item->unit_price ?? 0), 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay materiales registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Volver</a>
    </div>

@endsection