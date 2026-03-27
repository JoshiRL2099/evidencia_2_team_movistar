@extends('layouts.app')

@section('content')
<div class="container">

<h2>Editar Orden</h2>

<form action="{{ route('orders.update', $order->order_id) }}" method="POST">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Cliente</label>
    <input type="text"
           name="customer_name"
           value="{{ $order->customer_name }}"
           class="form-control"
           required>
</div>

<div class="mb-3">
    <label>Producto</label>
    <input type="text"
           name="product"
           value="{{ $order->product }}"
           class="form-control"
           required>
</div>

<div class="mb-3">
    <label>Cantidad</label>
    <input type="number"
           name="quantity"
           value="{{ $order->quantity }}"
           class="form-control"
           required>
</div>

<div class="mb-3">
    <label>Precio</label>
    <input type="number"
           step="0.01"
           name="price"
           value="{{ $order->price }}"
           class="form-control"
           required>
</div>

<button class="btn btn-warning">
    Actualizar Orden
</button>

<a href="{{ route('orders.index') }}" class="btn btn-secondary">
    Cancelar
</a>

</form>

</div>
@endsection