@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Nuevo Producto</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>SKU</label>
            <input type="text" name="sku" value="{{ old('sku') }}" required>
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Unidad</label>
            <input type="text" name="unit" value="{{ old('unit') }}" required>
        </div>

        <div class="mb-3">
            <label>Cantidad en stock</label>
            <input type="number" step="0.01" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required>
        </div>

        <div class="mb-3">
            <label>
                <input type="checkbox" name="active" value="1" {{ old('active') ? 'checked' : '' }}>
                Activo
            </label>
        </div>

        <button type="submit">Guardar</button>
        <a href="{{ route('products.index') }}">Cancelar</a>

    </form>

</div>

@endsection