@extends('layouts.app')
@section('title', 'Lista de Proveedores')

@section('content')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">

<h1 class="h4 mb-3">Lista de Proveedores</h1>

<a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">Nuevo Proveedor</a>

<div class="d-flex justify-content-between" style="margin: 20px;">
    <table class="table table-custom">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nombre_proveedor }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>
                            <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-info btn-sm">Actualizar</a>
                            <form action="{{ route('proveedores.destroy', $proveedor) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay proveedores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
</div>
@endsection