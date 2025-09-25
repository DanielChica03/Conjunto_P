@extends('layouts.app')
@section('title', 'Registrar Pago')
@section('content')
@php
    $usuario = session('usuario');
@endphp

<h1 class="h4 mb-3">Registrar Pago</h1>
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('pagos.store') }}" method="post">
    @csrf
    <div class="mb-3">
        <label for="id_deuda" class="form-label">Deuda:</label>
        <select name="id_deuda" id="id_deuda" class="form-select" required>
            <option value="" disabled selected>Seleccione una deuda</option>
            @foreach($deudas as $deuda)
                <option value="{{ $deuda->id_deuda }}">Deuda #{{ $deuda->id_deuda }} - Venta #{{ $deuda->id_venta }} - Saldo: ${{ $deuda->saldo }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="abono" class="form-label">Abono:</label>
        <input type="number" class="form-control" id="abono" name="abono" required min="1" value="{{ old('abono') }}">
    </div>
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha:</label>
        <input type="date" class="form-control" id="fecha" name="fecha" required value="{{ old('fecha') }}">
    </div>
    <button type="submit" class="btn btn-primary">Registrar Pago</button>
    <a href="{{ route('pagos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection