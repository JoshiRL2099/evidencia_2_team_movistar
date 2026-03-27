@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Detalle del Producto</h2>

    <p><strong>ID:</strong> {{ $product->product_id }}</p>
    <p><strong>SKU:</strong> {{ $product->sku }}</p>
    <p><strong>Nombre:</strong> {{ $product->name }}</p>
    <p><strong>Unidad:</strong> {{ $product->unit }}</p>
    <p><strong>Cantidad en stock:</strong> {{ $product->stock_quantity }}</p>
    <p><strong>Activo:</strong> {{ $product->active ? 'Sí' : 'No' }}</p>

    <a href="{{ route('products.index') }}">Volver</a>

</div>

@endsection