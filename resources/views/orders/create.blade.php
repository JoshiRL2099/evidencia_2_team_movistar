@extends('layouts.app')

@section('content')

<h2>Nueva Orden</h2>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <h4>Campos Obligatorios</h4>

    <div class="mb-3">
        <label>Número de Factura</label>
        <input type="text" name="invoice_number" class="form-control" placeholder="FAC-2025-025">
    </div>

    <div class="mb-3">
        <label>Número de Cliente</label>
        <input type="text" name="customer_number" class="form-control" placeholder="CLT-025">
    </div>

    <div class="mb-3">
        <label>Fecha y Hora</label>
        <input type="datetime-local" name="date_time" class="form-control">
    </div>

    <div class="mb-3">
        <label>Nombre / Razón Social</label>
        <input type="text" name="name" class="form-control" placeholder="Constructora del Valle">
    </div>

    <div class="mb-3">
        <label>Teléfono de Contacto</label>
        <input type="text" name="phone" class="form-control" placeholder="7290007865">
    </div>

    <div class="mb-3">
        <label>RFC / Datos Fiscales</label>
        <input type="text" name="rfc" class="form-control" placeholder="CVA-123456-ABC">
    </div>

    <div class="mb-3">
        <label>Dirección de Entrega</label>
        <input type="text" name="address" class="form-control" placeholder="Av. Industrial #456...">
    </div>

    <div class="mb-3">
        <label>Notas Adicionales</label>
        <textarea name="notes" class="form-control" placeholder="Entregar entre 6am y 6pm..."></textarea>
    </div>

    <hr>

    <h4>Imagen del Banner</h4>

    <div class="mb-3">
        <input type="file" name="image" class="form-control">
    </div>

    <hr>

    <h4>Material del pedido</h4>

    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Material</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input name="items[0][product_id]" class="form-control"></td>
                <td><input name="items[0][quantity]" class="form-control"></td>
                <td><input name="items[0][unit]" class="form-control"></td>
                <td><input name="items[0][unit_price]" class="form-control"></td>
                <td><button type="button" onclick="removeRow(this)">X</button></td>
            </tr>
        </tbody>
    </table>

    <button type="button" onclick="addRow()" class="btn btn-primary">
        Agregar material
    </button>

    <button type="submit" class="btn btn-success">
        Guardar Orden
    </button>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        Cancelar Orden
    </a>

</form>

@endsection