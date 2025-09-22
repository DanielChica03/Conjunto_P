@extends('layouts.app')
@section('title', 'Lista de Productos')

@section('content')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">

@php
    $usuario = session('usuario');
@endphp

<h1 class="h4 mb-3">Lista de Productos</h1>

{{-- SOLO ADMIN puede registrar productos --}}
@if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>
@endif

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
                @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                    <th class="text-end">Acciones</th>
                @endif
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

                    {{-- Acciones solo visibles para ADMIN --}}
                    @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                        <td class="text-end">
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-info btn-sm">Actualizar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="post" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR' ? '7' : '6' }}" 
                        class="text-center">
                        No hay productos registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
