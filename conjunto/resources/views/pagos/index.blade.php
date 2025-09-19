@extends('layouts.app')
@section('title', 'Lista de Pagos')
@section('content')
<h1 class="h4 mb-3">Lista de Pagos</h1>
<a href="{{ route('pagos.create') }}" class="btn btn-primary mb-3">Registrar Pago</a>@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Pago</th>
            <th>Deuda</th>
            <th>Venta</th>
            <th>Abono</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pagos as $pago)
            <tr>
                <td>{{ $pago->id_pago }}</td>
                <td>{{ $pago->deuda->id_deuda ?? 'Sin deuda' }}</td>
                <td>{{ $pago->deuda->venta->id ?? 'Sin venta' }}</td>
                <td>{{ $pago->abono }}</td>
                <td>{{ $pago->fecha }}</td>
                <td>
                    <a href="{{ route('pagos.edit', parameters: $pago->id_pago) }}" class="btn btn-info btn-sm">Editar</a>
                    <form action="{{ route('pagos.destroy', $pago->id_pago) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar pago?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No hay pagos registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection