@extends('layouts.app')
@section('title', 'Lista de Usuarios')

@section('content')

<h1 class="h4 mb-3">Lista de Usuarios</h1>

<a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Nuevo Usuario</a>

<div class="d-flex justify-content-between" style="margin: 20px;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Género</th>
                <th>Fecha Nacimiento</th>
                <th>Tipo Usuario</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->cedula }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->apellido }}</td>
                    <td>{{ $usuario->correo }}</td>
                    <td>{{ $usuario->telefono }}</td>
                    <td>{{ $usuario->genero }}</td>
                    <td>{{ $usuario->fecha_nacimiento }}</td>
                    <td>{{ $usuario->tipo_usuario }}</td>
                    <td>{{ $usuario->estado }}</td>
                    <td class="text-end">
                        <a href="{{ route('usuarios.edit', $usuario->cedula) }}" class="btn btn-info btn-sm">Actualizar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->cedula) }}" method="post" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
