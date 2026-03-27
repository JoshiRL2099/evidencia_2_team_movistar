@extends('layouts.app')

@section('content')

<h2>Crear Orden</h2>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Cliente</label>
        <select name="customer_id" class="form-control" required>
            <option value="">Seleccione un cliente</option>

            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">
                    {{ $customer->display_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="description" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Total</label>
        <input type="number" step="0.01" name="total" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">
        Guardar
    </button>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        Cancelar
    </a>

</form>

@endsection