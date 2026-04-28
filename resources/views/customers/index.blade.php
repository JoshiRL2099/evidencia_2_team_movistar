@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Clientes</h2>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            + Nuevo Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($customers->isEmpty())
        <div class="alert alert-info">No hay clientes registrados.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>N° Cliente</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>RFC</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->customer_number }}</td>
                        <td>{{ $customer->display_name }}</td>

                        {{-- Dirección (relación address) --}}
                        <td>{{ $customer->address->city ?? '—' }}</td>
                        <td>{{ $customer->address->state ?? '—' }}</td>

                        {{-- Datos fiscales (relación fiscalData) --}}
                        <td>{{ $customer->fiscalData->rfc ?? '—' }}</td>

                        <td>
                            <a href="{{ route('customers.show', $customer->customer_id) }}"
                               class="btn btn-sm btn-info">Ver</a>

                            <a href="{{ route('customers.edit', $customer->customer_id) }}"
                               class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('customers.destroy', $customer->customer_id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este cliente?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection