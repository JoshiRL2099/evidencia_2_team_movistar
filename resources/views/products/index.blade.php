@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Productos</h2>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
        Nuevo Producto
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Unidad</th>
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
                    <td>{{ $product->stock_quantity }}</td>
                    <td>{{ $product->active ? 'Sí' : 'No' }}</td>

                    <td>
                        <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-info btn-sm">
                            Ver
                        </a>

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
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay productos registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection