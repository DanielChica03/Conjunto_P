@extends('layouts.app')
@section('title', 'Inventario')

@section('content')
@section('menu')
@endsection
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">

@php
    $usuario = session('usuario');
@endphp

<h1 class="h4 mb-3">Lista de Inventario</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- SOLO ADMINISTRADOR puede registrar --}}
@if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
    <a href="{{ route('inventario.create') }}" class="btn btn-primary mb-3">Agregar Item</a>
@endif

<table class="table table-custom">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Ubicación</th>
            <th>Cantidad</th>
            <th>Especificaciones</th>
            <th>Fecha Vencimiento</th>
            <th>Estado</th>
            @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                <th>Acciones</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($inventarios as $item)
            <tr>
                <td>{{ $item->id_item }}</td>
                <td>{{ $item->producto->nombre_producto ?? 'Sin producto' }}</td>
                <td>{{ $item->ubicacion }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->especificaciones }}</td>
                <td>{{ $item->fecha_vencimiento }}</td>
                <td>{{ $item->estado }}</td>

                {{-- SOLO ADMINISTRADOR puede actualizar o eliminar --}}
                @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                    <td>
                        <a href="{{ route('inventario.edit', $item->id_item) }}" class="btn btn-info btn-sm">Actualizar</a>

                        <form action="{{ route('inventario.destroy', $item->id_item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este item?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="{{ $usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR' ? '8' : '7' }}" class="text-center">
                    No hay items en inventario.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
