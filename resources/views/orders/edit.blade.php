@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Editar Orden</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.update', $order->order_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Número de Factura</label>
                <input type="text" name="invoice_number" class="form-control"
                    value="{{ old('invoice_number', $order->invoice_number) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <select name="customer_id" class="form-control" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ old('customer_id', $order->customer_id) == $customer->customer_id ? 'selected' : '' }}>
                            {{ $customer->customer_number }} - {{ $customer->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha y Hora</label>
                <input type="datetime-local" name="order_datetime" class="form-control"
                    value="{{ old('order_datetime', \Carbon\Carbon::parse($order->order_datetime)->format('Y-m-d\TH:i')) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="status" class="form-control" required>
                    @foreach(['ORDERED', 'IN_PROCESS', 'IN_ROUTE', 'DELIVERED', 'DELETED'] as $status)
                        <option value="{{ $status }}" {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Notas</label>
                <textarea name="notes" class="form-control">{{ old('notes', $order->notes) }}</textarea>
            </div>

            @if($order->deliveryAddress)
                <h4>Dirección de entrega</h4>

                <div class="mb-3">
                    <label class="form-label">Calle</label>
                    <input type="text" name="street" class="form-control"
                        value="{{ old('street', $order->deliveryAddress->street) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Número exterior</label>
                    <input type="text" name="ext_number" class="form-control"
                        value="{{ old('ext_number', $order->deliveryAddress->ext_number) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Número interior</label>
                    <input type="text" name="int_number" class="form-control"
                        value="{{ old('int_number', $order->deliveryAddress->int_number) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Colonia</label>
                    <input type="text" name="neighborhood" class="form-control"
                        value="{{ old('neighborhood', $order->deliveryAddress->neighborhood) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ciudad</label>
                    <input type="text" name="city" class="form-control"
                        value="{{ old('city', $order->deliveryAddress->city) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <input type="text" name="state" class="form-control"
                        value="{{ old('state', $order->deliveryAddress->state) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Código Postal</label>
                    <input type="text" name="zip" class="form-control" value="{{ old('zip', $order->deliveryAddress->zip) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Referencias</label>
                    <input type="text" name="references" class="form-control"
                        value="{{ old('references', $order->deliveryAddress->references) }}">
                </div>
            @endif

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

@endsection