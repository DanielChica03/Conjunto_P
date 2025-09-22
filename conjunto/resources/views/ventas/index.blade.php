@extends('layouts.app')
@section('title', 'Lista de Ventas')

@section('content')

<h1 class="h4 mb-3">Lista de Ventas</h1>

<a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3">Nueva Venta</a>

<div class="d-flex justify-content-between" style="margin: 20px;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Descuento</th>
                <th>Total</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'Sin Cliente' }}</td>
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
                    <td>{{ $venta->estado }}</td>
                    <td class="text-end">
                        <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-info btn-sm">Actualizar</a>
                        <form action="{{ route('ventas.destroy', $venta->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar venta?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay ventas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection