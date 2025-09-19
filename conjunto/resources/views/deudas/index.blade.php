@extends('layouts.app')
@section('title', 'Lista de Deudas')
@section('content')
<h1 class="h4 mb-3">Lista de Deudas</h1>
<a href="{{ route('deudas.create') }}" class="btn btn-primary mb-3">Nueva Deuda</a>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Venta</th>
            <th>Valor</th>
            <th>Plazo</th>
            <th>Saldo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($deudas as $deuda)
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
        @empty
            <tr>
                <td colspan="6" class="text-center">No hay deudas registradas.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection