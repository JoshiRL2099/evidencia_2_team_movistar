@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Nuevo Producto</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>SKU</label>
            <input type="text"
                   name="sku"
                   value="{{ old('sku') }}"
                   class="form-control @error('sku') is-invalid @enderror"
                   required>
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Unidad</label>
            <input type="text"
                   name="unit"
                   value="{{ old('unit') }}"
                   class="form-control @error('unit') is-invalid @enderror"
                   required>
            @error('unit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Precio</label>
            <input type="number"
                   name="price"
                   value="{{ old('price', 0) }}"
                   class="form-control @error('price') is-invalid @enderror"
                   step="0.01"
                   min="0"
                   required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Cantidad en stock</label>
            <input type="number"
                   name="stock_quantity"
                   value="{{ old('stock_quantity', 0) }}"
                   class="form-control @error('stock_quantity') is-invalid @enderror"
                   step="1"
                   min="0"
                   required>
            @error('stock_quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox"
                   name="active"
                   value="1"
                   class="form-check-input"
                   {{ old('active') ? 'checked' : '' }}>
            <label class="form-check-label">Activo</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>

    </form>
</div>
@endsection