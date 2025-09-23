@extends('layouts.app')
@section('title', 'Lista de Deudas')
@section('content')

@php
    $usuario = session('usuario');
@endphp

<h1 class="h4 mb-3">Lista de Deudas</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- SOLO ADMIN puede registrar deudas --}}
@if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
    <a href="{{ route('deudas.create') }}" class="btn btn-primary mb-3">Nueva Deuda</a>
@endif

<table class="table table-custom">
    <thead>
        <tr>
            <th>ID</th>
            <th>Venta</th>
            <th>Valor</th>
            <th>Plazo</th>
            <th>Saldo</th>
            @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                <th>Acciones</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($deudas as $deuda)
            {{-- Mostrar TODO si es ADMIN --}}
            @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                <tr>
                    <td>{{ $deuda->id_deuda }}</td>
                    <td>{{ $deuda->venta->id ?? 'Sin venta' }}</td>
                    <td>{{ $deuda->valor }}</td>
                    <td>{{ $deuda->plazo }}</td>
                    <td>{{ $deuda->saldo }}</td>
                    <td>
                        <a href="{{ route('deudas.edit', $deuda->id_deuda) }}" class="btn btn-info btn-sm">Editar</a>
                        <form action="{{ route('deudas.destroy', $deuda->id_deuda) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar deuda?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @elseif($usuario && strtoupper($usuario->tipo_usuario) === 'CLIENTE' && $deuda->venta->cliente_id == $usuario->cedula)
                {{-- El CLIENTE solo ve sus propias deudas --}}
                <tr>
                    <td>{{ $deuda->id_deuda }}</td>
                    <td>{{ $deuda->venta->id ?? 'Sin venta' }}</td>
                    <td>{{ $deuda->valor }}</td>
                    <td>{{ $deuda->plazo }}</td>
                    <td>{{ $deuda->saldo }}</td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="{{ $usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR' ? '6' : '5' }}" class="text-center">
                    No hay deudas registradas.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
