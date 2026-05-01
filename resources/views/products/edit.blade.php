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
            <input type="text"
                   id="stock_quantity"
                   name="stock_quantity"
                   value="{{ old('stock_quantity', (int) $product->stock_quantity) }}"
                   class="form-control"
                   required>
            <div id="stock-error" class="text-danger" style="display:none;">
                Solo se permiten números enteros.
            </div>
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

<script>
    const stockInput = document.getElementById('stock_quantity');
    const stockError = document.getElementById('stock-error');

    stockInput.addEventListener('keydown', function (e) {
        if (e.key === '.' || e.key === ',' || e.key === 'e' || e.key === 'E' || e.key === '-') {
            e.preventDefault();
            stockError.style.display = 'block';
        } else {
            stockError.style.display = 'none';
        }
    });

    stockInput.addEventListener('paste', function (e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text');
        this.value = text.replace(/[^0-9]/g, '');
    });

    stockInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

@endsection