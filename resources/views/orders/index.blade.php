@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Lista de Órdenes</h1>

    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">
        Nueva Orden
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->user->full_name ?? 'N/A' }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->created_at }}</td>

                <td>
                    <a href="{{ route('orders.show',$order->order_id) }}" class="btn btn-info btn-sm">Ver</a>

                    <a href="{{ route('orders.edit', $order->order_id) }}"class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('orders.destroy',$order->order_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection