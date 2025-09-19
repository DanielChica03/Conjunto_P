@extends('layouts.app')
@section('title', 'Lista de Compras')

@section('content')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">

<h1 class="h4 mb-3">Lista de Compras</h1>

<a href="{{ route('compras.create') }}" class="btn btn-primary mb-3">Nueva Compra</a>

    <table class="table table-custom">
        <thead>
            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Total</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($compras as $compra)
                <tr>
                    <td>{{ $compra->id }}</td>
                    <td>{{ $compra->proveedor->nombre_proveedor }}</td>
                    <td>{{ $compra->fecha }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach($compra->detalles as $detalle)
                                <li>
                                    {{ $detalle->producto->nombre_producto ?? 'Producto eliminado' }} 
                                    (x{{ $detalle->cantidad }}) 
                                    - ${{ number_format($detalle->valor_unitario, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $compra->total }}</td>
                    <td>{{ $compra->estado }}</td>
                    <td class="text-end">
                        <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-info btn-sm">Actualizar</a>
                        <form action="{{ route('compras.destroy', $compra->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Cancelar compra?')">Cancelar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay compras registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
