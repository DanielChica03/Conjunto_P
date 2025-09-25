@extends('layouts.app')
@section('title', 'Editar Pago')
@section('content')
@php
    $usuario = session('usuario');
@endphp
@if(strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
<div class="container"> 
    <h1 class="h4 mb-3">Editar Pago</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('pagos.update', $pago->id_pago) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_deuda" class="form-label">Deuda:</label>
            <select name="id_deuda" id="id_deuda" class="form-select" required>
                @foreach($deudas as $deuda)
                    <option value="{{ $deuda->id_deuda }}" {{ $pago->id_deuda == $deuda->id_deuda ? 'selected' : '' }}>Deuda #{{ $deuda->id_deuda }} - Venta #{{ $deuda->id_venta }} - Saldo: ${{ $deuda->saldo }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="abono" class="form-label">Abono:</label>
            <input type="number" class="form-control" id="abono" name="abono" required min="1" value="{{ old('abono', $pago->abono) }}">
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required value="{{ old('fecha', $pago->fecha) }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Pago</button>
        <a href="{{ route('pagos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@else
    <div class="alert alert-danger">
        <h4 class="alert-heading">Acceso Denegado</h4>
        <p>No tienes permiso para acceder a esta página.</p>
    </div>
@endif
@endsection