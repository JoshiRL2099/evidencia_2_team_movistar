@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Productos</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php $__role = auth()->user()->role->name ?? ''; @endphp
    @if($__role === 'ADMIN')
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
            Nuevo Producto
        </a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th>Cantidad en stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>{{ $product->active ? 'Sí' : 'No' }}</td>

                    <td>
                        <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-info btn-sm">
                            Ver
                        </a>

                        @if($__role === 'ADMIN')
                            <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay productos registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection