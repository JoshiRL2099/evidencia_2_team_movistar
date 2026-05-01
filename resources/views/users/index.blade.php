@extends('layouts.app')

@section('content')

<h2>Usuarios</h2>

@php $__role = auth()->user()->role->name ?? ''; @endphp

@if($__role === 'ADMIN')
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        Nuevo Usuario
    </a>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->name ?? 'Sin rol' }}</td>

                <td>
                    <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm">Ver</a>

                    @if($__role === 'ADMIN')
                        <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    @endif
                </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection