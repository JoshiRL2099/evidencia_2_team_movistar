@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Editar Producto</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->product_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>SKU</label>
            <input type="text"
                   name="sku"
                   value="{{ old('sku', $product->sku) }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $product->name) }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Unidad</label>
            <input type="text"
                   name="unit"
                   value="{{ old('unit', $product->unit) }}"
                   class="form-control"
                   required>
        </div>

        {{-- ✅ Campo precio agregado --}}
        <div class="mb-3">
            <label>Precio</label>
            <input type="number"
                   name="price"
                   value="{{ old('price', $product->price ?? 0) }}"
                   class="form-control"
                   step="0.01"
                   min="0"
                   required>
        </div>

        <div class="mb-3">
            <label>Cantidad en stock</label>
            <input type="number"
                   name="stock_quantity"
                   value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                   class="form-control"
                   step="0.01"
                   min="0"
                   required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox"
                   name="active"
                   value="1"
                   class="form-check-input"
                   {{ old('active', $product->active) ? 'checked' : '' }}>
            <label class="form-check-label">Activo</label>
        </div>

        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>

    </form>
</div>
@endsection