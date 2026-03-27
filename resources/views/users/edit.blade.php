@extends('layouts.app')

@section('content')
<div class="container">

<h2>Editar Usuario</h2>

<form action="{{ route('users.update',$user->user_id) }}" method="POST">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Nombre</label>
    <input type="text"
           name="nombre"
           value="{{ $user->full_name }}"
           class="form-control"
           required>
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email"
           name="email"
           value="{{ $user->email }}"
           class="form-control"
           required>
</div>

<button class="btn btn-warning">
    Actualizar
</button>

</form>

</div>
@endsection