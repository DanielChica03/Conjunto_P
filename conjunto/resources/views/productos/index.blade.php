@extends('layouts.app')
@section('title', 'Lista de Productos')

@section('content')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">

<h1 class="h4 mb-3">Lista de Productos</h1>

<a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>

<div class="d-flex justify-content-between" style="margin: 20px;">
    <table class="table table-custom">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Valor Unitario</th>
                <th>Unidad de Medida</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre_producto }}</td>
                    <td>{{ $producto->descripcion_producto }}</td>
                    <td>{{ $producto->valor_unitario }}</td>
                    <td>{{ $producto->unidad_medida }}</td>
                    <td>{{ $producto->estado_producto }}</td>
                    <td class="text-end">
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-info btn-sm">Actualizar</a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="post" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay productos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
