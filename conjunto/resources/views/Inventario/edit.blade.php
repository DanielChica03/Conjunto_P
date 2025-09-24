@extends('layouts.app')
@section('title', 'Editar Item Inventario')

@section('content')
@section('menu')
@endsection
@php
    $usuario = session('usuario');
@endphp
@if(strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')

<div class="container">
    <h1 class="h4 mb-3">Editar Item Inventario</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventario.update', $inventario->id_item) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto:</label>
            <select class="form-control" id="producto_id" name="producto_id" required>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" 
                        {{ $inventario->producto_id == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre_producto }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación:</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                maxlength="40" value="{{ old('ubicacion', $inventario->ubicacion) }}" required>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" 
                min="1" value="{{ old('cantidad', $inventario->cantidad) }}" required>
        </div>

        <div class="mb-3">
            <label for="especificaciones" class="form-label">Especificaciones:</label>
            <input type="text" class="form-control" id="especificaciones" name="especificaciones" 
                maxlength="100" value="{{ old('especificaciones', $inventario->especificaciones) }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" 
                value="{{ old('fecha_vencimiento', $inventario->fecha_vencimiento) }}" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="DISPONIBLE" {{ $inventario->estado == 'DISPONIBLE' ? 'selected' : '' }}>Disponible</option>
                <option value="NO_DISPONIBLE" {{ $inventario->estado == 'NO_DISPONIBLE' ? 'selected' : '' }}>No disponible</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@else
    <div class="alert alert-danger">
        <h4 class="alert-heading">Acceso Denegado</h4>
        <p>No tienes permiso para acceder a esta página.</p>
    </div>
@endif
@endsection
