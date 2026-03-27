@extends('layouts.app')

@section('content')
<div class="container">

<h2>Crear Usuario</h2>

<form action="{{ route('users.store') }}" method="POST">
@csrf

<div class="mb-3">
    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control" required>
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
</div>

<button class="btn btn-success">Guardar</button>

</form>

</div>
@endsection