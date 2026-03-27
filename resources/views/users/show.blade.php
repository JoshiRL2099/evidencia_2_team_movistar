@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Detalle del Usuario</h2>

    <p><strong>ID:</strong> {{ $user->user_id }}</p>
    <p><strong>Nombre:</strong> {{ $user->full_name }}</p>
    <p><strong>Username:</strong> {{ $user->username }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Activo:</strong> {{ $user->is_active ? 'Sí' : 'No' }}</p>
    <p><strong>Rol:</strong> {{ $user->role->name ?? 'Sin rol' }}</p>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        Volver
    </a>

</div>
@endsection