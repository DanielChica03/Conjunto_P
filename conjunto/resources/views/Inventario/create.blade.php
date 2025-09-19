@extends('layouts.app')
@section('title', 'Registrar Item Inventario')

@section('content')
@section('menu')
@endsection

<h1 class="h4 mb-3">Registrar Item Inventario</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('inventario.store') }}" method="post">
    @csrf

    <div class="mb-3">
        <label for="producto_id" class="form-label">Producto:</label>
        <select class="form-control" id="producto_id" name="producto_id" required>
            <option value="">-- Selecciona un producto --</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                    {{ $producto->nombre_producto }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="ubicacion" class="form-label">Ubicación:</label>
        <input type="text" class="form-control" id="ubicacion" name="ubicacion" maxlength="40" value="{{ old('ubicacion') }}" placeholder="Bodega 1 - Estante A" required>
    </div>

    <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad:</label>
        <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" value="{{ old('cantidad') }}" placeholder="Ej: 50" required>
    </div>

    <div class="mb-3">
        <label for="especificaciones" class="form-label">Especificaciones:</label>
        <input type="text" class="form-control" id="especificaciones" name="especificaciones" maxlength="50" value="{{ old('especificaciones') }}" placeholder="Caja de 12 unidades" required>
    </div>

    <div class="mb-3">
        <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" required>
    </div>

    <div class="mb-3">
        <label for="estado" class="form-label">Estado:</label>
        <select class="form-control" id="estado" name="estado" required>
            <option value="DISPONIBLE" {{ old('estado') == 'DISPONIBLE' ? 'selected' : '' }}>Disponible</option>
            <option value="NO_DISPONIBLE" {{ old('estado') == 'NO_DISPONIBLE' ? 'selected' : '' }}>No disponible</option>
        </select>
    </div>

    <button type="submit" class="btn btn-danger">Guardar</button>
    <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
