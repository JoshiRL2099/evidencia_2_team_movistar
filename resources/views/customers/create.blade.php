@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Nuevo Cliente</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <h5 class="mt-3">Datos generales</h5>

        <div class="mb-3">
            <label>N° Cliente</label>
            <input type="text"
                   name="customer_number"
                   value="{{ old('customer_number') }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text"
                   name="display_name"
                   value="{{ old('display_name') }}"
                   class="form-control"
                   required>
        </div>

        <h5 class="mt-4">Dirección</h5>

        <div class="mb-3">
            <label>Calle</label>
            <input type="text" name="street" value="{{ old('street') }}" class="form-control" required>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label>N° Exterior</label>
                <input type="text" name="ext_number" value="{{ old('ext_number') }}" class="form-control" required>
            </div>
            <div class="col mb-3">
                <label>N° Interior</label>
                <input type="text" name="int_number" value="{{ old('int_number') }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Colonia</label>
            <input type="text" name="neighborhood" value="{{ old('neighborhood') }}" class="form-control" required>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label>Ciudad</label>
                <input type="text" name="city" value="{{ old('city') }}" class="form-control" required>
            </div>
            <div class="col mb-3">
                <label>Estado</label>
                <input type="text" name="state" value="{{ old('state') }}" class="form-control" required>
            </div>
            <div class="col mb-3">
                <label>CP</label>
                <input type="text" name="zip" value="{{ old('zip') }}" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Referencias</label>
            <input type="text" name="references" value="{{ old('references') }}" class="form-control">
        </div>

        <h5 class="mt-4">Datos fiscales <small class="text-muted">(opcional)</small></h5>

        <div class="mb-3">
            <label>RFC</label>
            <input type="text" name="rfc" value="{{ old('rfc') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Razón social</label>
            <input type="text" name="legal_name" value="{{ old('legal_name') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Régimen fiscal</label>
            <input type="text" name="tax_regime" value="{{ old('tax_regime') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Uso CFDI</label>
            <input type="text" name="cfdi_use" value="{{ old('cfdi_use') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email para factura</label>
            <input type="email" name="email_for_invoice" value="{{ old('email_for_invoice') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancelar</a>

    </form>
</div>
@endsection