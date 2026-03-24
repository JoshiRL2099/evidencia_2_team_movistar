<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Bienvenido, {{ $user->full_name }}</h1>
    <p>Rol: {{ $user->role->name }}</p>

    <hr>

    <h2>Panel de control</h2>

    <p><strong>Pedidos pendientes:</strong> {{ $pendingOrders }}</p>
    <p><strong>Pedidos en ruta:</strong> {{ $onRouteOrders }}</p>
    <p><strong>Entregados hoy:</strong> {{ $deliveredToday }}</p>
    <p><strong>Materiales sin stock:</strong> 0</p>

    <hr>

    <h2>Departamentos</h2>

    <p><strong>Ventas:</strong> {{ $salesUsers }} usuarios activos</p>
    <p><strong>Compras:</strong> {{ $purchasingUsers }} usuarios activos</p>
    <p><strong>Almacén:</strong> {{ $warehouseUsers }} usuarios activos</p>
    <p><strong>Ruta:</strong> {{ $routeUsers }} usuarios activos</p>

    <hr>

    <h2>Actividad reciente</h2>

    @if($recentActivity->isEmpty())
        <p>No hay actividad reciente.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Pedido</th>
                    <th>Acción</th>
                    <th>Fecha/Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentActivity as $activity)
                    <tr>
                        <td>{{ $activity->changedBy->full_name ?? 'N/A' }}</td>
                        <td>{{ $activity->order->invoice_number ?? 'N/A' }}</td>
                        <td>
                            Cambio de "{{ $activity->from_status }}" a "{{ $activity->to_status }}"
                        </td>
                        <td>{{ $activity->changed_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <p><a href="{{ route('orders.index') }}">Ver órdenes</a></p>
    <p><a href="{{ route('users.index') }}">Ver usuarios</a></p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>