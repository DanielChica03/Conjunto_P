@extends('layouts.app')
@section('title', 'Registrar Deuda')
@section('content')
<h1 class="h4 mb-3">Registrar Deuda</h1>
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('deudas.store') }}" method="post">
    @csrf
    <div class="mb-3">
        <label for="id_venta" class="form-label">Venta Pendiente:</label>
        <select name="id_venta" id="id_venta" class="form-select" required>
            <option value="" disabled selected>Seleccione una venta</option>
            @foreach($ventas as $venta)
                <option value="{{ $venta->id }}">Venta #{{ $venta->id }} - Cliente: {{ $venta->cliente->nombre ?? 'Sin Cliente' }} - Total: ${{ $venta->total }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="valor" class="form-label">Valor:</label>
        <input type="number" class="form-control" id="valor" name="valor" required min="0" value="{{ old('valor') }}">
    </div>
    <div class="mb-3">
        <label for="plazo" class="form-label">Plazo:</label>
        <input type="date" class="form-control" id="plazo" name="plazo" required value="{{ old('plazo') }}">
    </div>
    <div class="mb-3">
        <label for="saldo" class="form-label">Saldo:</label>
        <input type="number" class="form-control" id="saldo" name="saldo" required min="0" value="{{ old('saldo') }}">
    </div>
    <button type="submit" class="btn btn-primary">Registrar Deuda</button>
    <a href="{{ route('deudas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection