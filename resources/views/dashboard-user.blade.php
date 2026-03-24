<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Usuario</title>
</head>
<body>
    <h1>Bienvenido, {{ $user->full_name }}</h1>
    <p>Rol: {{ $user->role->name }}</p>

    <hr>

    @if(!$latestOrder)
        <p>No tienes pedidos registrados todavía.</p>
    @else
        <h2>Estado de la orden</h2>

        <p><strong>Número de cliente:</strong> {{ $latestOrder->customer->customer_number ?? 'N/A' }}</p>
        <p><strong>Número de factura:</strong> {{ $latestOrder->invoice_number }}</p>
        <p><strong>Estado actual:</strong> {{ $latestOrder->status }}</p>

        <hr>

        <h2>Detalles de la orden</h2>

        <p><strong>Cliente:</strong> {{ $latestOrder->customer->display_name ?? 'N/A' }}</p>

        <p>
            <strong>Dirección:</strong>
            @if($latestOrder->deliveryAddress)
                {{ $latestOrder->deliveryAddress->street }}
                #{{ $latestOrder->deliveryAddress->ext_number }},
                {{ $latestOrder->deliveryAddress->neighborhood }},
                {{ $latestOrder->deliveryAddress->city }},
                {{ $latestOrder->deliveryAddress->state }},
                CP {{ $latestOrder->deliveryAddress->zip }}
            @else
                N/A
            @endif
        </p>

        <p><strong>Materiales:</strong></p>
        <ul>
            @forelse($latestOrder->items as $item)
                <li>
                    {{ $item->quantity }} {{ $item->product->unit ?? '' }} de {{ $item->product->name ?? 'Producto' }}
                </li>
            @empty
                <li>No hay materiales registrados.</li>
            @endforelse
        </ul>

        <p><strong>Notas:</strong> {{ $latestOrder->notes ?? 'Sin notas' }}</p>
        <p><strong>Fecha de pedido:</strong> {{ $latestOrder->order_datetime }}</p>
    @endif

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>