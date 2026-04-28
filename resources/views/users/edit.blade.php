@extends('layouts.app')

@section('content')
<div class="container">

<h2>Editar Usuario</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->user_id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Campo faltante requerido por validación --}}
    <div class="mb-3">
        <label>Usuario</label>
        <input type="text"
               name="username"
               value="{{ old('username', $user->username) }}"
               class="form-control @error('username') is-invalid @enderror"
               required>
        @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Corregido: name="full_name" (antes decía "nombre") --}}
    <div class="mb-3">
        <label>Nombre completo</label>
        <input type="text"
               name="full_name"
               value="{{ old('full_name', $user->full_name) }}"
               class="form-control @error('full_name') is-invalid @enderror"
               required>
        @error('full_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Email ahora sí se guarda correctamente --}}
    <div class="mb-3">
        <label>Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', $user->email) }}"
               class="form-control @error('email') is-invalid @enderror"
               required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Campo faltante requerido por validación --}}
    <div class="mb-3">
        <label>Rol</label>
        <select name="role_id"
                class="form-control @error('role_id') is-invalid @enderror"
                required>
            @foreach($roles as $role)
                <option value="{{ $role->role_id }}"
                    {{ old('role_id', $user->role_id) == $role->role_id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Contraseña opcional --}}
    <div class="mb-3">
        <label>Nueva contraseña <small class="text-muted">(dejar vacío para no cambiar)</small></label>
        <input type="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Confirmar contraseña</label>
        <input type="password"
               name="password_confirmation"
               class="form-control">
    </div>

    {{-- Estado activo --}}
    <div class="mb-3 form-check">
        <input type="checkbox"
               name="is_active"
               value="1"
               class="form-check-input"
               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
        <label class="form-check-label">Usuario activo</label>
    </div>

    <button class="btn btn-warning">Actualizar</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>

</form>
</div>
@endsection