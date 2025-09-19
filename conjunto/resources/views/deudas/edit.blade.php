@extends('layouts.app')
@section('title', 'Editar Deuda')
@section('content')
<h1 class="h4 mb-3">Editar Deuda</h1>
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('deudas.update', $deuda->id_deuda) }}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="id_venta" class="form-label">Venta Pendiente:</label>
        <select name="id_venta" id="id_venta" class="form-select" required>
            @foreach($ventas as $venta)
                <option value="{{ $venta->id }}" {{ $deuda->id_venta == $venta->id ? 'selected' : '' }}>Venta #{{ $venta->id }} - Cliente: {{ $venta->cliente->nombre ?? 'Sin Cliente' }} - Total: ${{ $venta->total }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="valor" class="form-label">Valor:</label>
        <input type="number" class="form-control" id="valor" name="valor" required min="0" value="{{ old('valor', $deuda->valor) }}">
    </div>
    <div class="mb-3">
        <label for="plazo" class="form-label">Plazo:</label>
        <input type="date" class="form-control" id="plazo" name="plazo" required value="{{ old('plazo', $deuda->plazo) }}">
    </div>
    <div class="mb-3">
        <label for="saldo" class="form-label">Saldo:</label>
        <input type="number" class="form-control" id="saldo" name="saldo" required min="0" value="{{ old('saldo', $deuda->saldo) }}">
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Deuda</button>
    <a href="{{ route('deudas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection