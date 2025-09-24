@extends('layouts.app')
@section('title', $esCliente ? 'Mis Compras' : 'Lista de Ventas')

@section('content')

@php
    $usuario = session('usuario');
    $esAdmin = $usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR';
    $esCajero = $usuario && strtoupper($usuario->tipo_usuario) === 'CAJERO';
@endphp

<h1 class="h4 mb-3">{{ $esCliente ? 'Mis Compras' : 'Lista de Ventas' }}</h1>

@if($esAdmin || $esCajero)
    <a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3">Nueva Venta</a>
@endif

<div class="d-flex justify-content-between" style="margin: 20px;">
    <table class="table table-custom">
        <thead>
            <tr>
                @if(!$esCliente)
                    <th>ID</th>
                    <th>Cliente</th>
                @endif
                <th>Fecha</th>
                <th>Productos</th>
                <th>Descuento</th>
                <th>Total</th>
                @if($esAdmin)
                    <th class="text-end">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($ventas as $venta)
                <tr>
                    @if(!$esCliente)
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente->nombre ?? 'Sin Cliente' }}</td>
                    @endif
                    <td>{{ $venta->fecha_venta }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach($venta->detalles as $detalle)
                                <li>
                                    {{ $detalle->producto->nombre_producto ?? 'Producto eliminado' }} 
                                    (x{{ $detalle->cantidad }}) 
                                    - ${{ number_format($detalle->valor_unitario, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $venta->descuento }}</td>
                    <td>{{ $venta->total }}</td>
                    @if($esAdmin)
                        <td class="text-end">
                            <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-info btn-sm">Actualizar</a>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar venta?')">Eliminar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $esCliente ? '4' : ($esAdmin ? '7' : '6') }}" class="text-center">
                        No hay {{ $esCliente ? 'compras' : 'ventas' }} registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection