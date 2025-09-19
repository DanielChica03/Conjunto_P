@extends('layouts.app')
@section('title','Editar Producto')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Editar Producto</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update',$producto) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id" class="form-label">ID: </label>
            <input type="number" readonly class="form-control" id="id" name="id" min="1000000" max="999999999999" value="{{ old('id', $producto->id) }}" placeholder="1245632874" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre: </label>
            <input type="text" class="form-control" id="nombre" name="nombre_producto" minlength="2" maxlength="100" value="{{ old('nombre_producto', $producto->nombre_producto) }}" placeholder="Juan" required>
        </div>
        
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción: </label>
            <textarea class="form-control" id="descripcion" name="descripcion_producto" minlength="2" maxlength="100" placeholder="Descripción del producto" required>{{ old('descripcion_producto', $producto->descripcion_producto) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="valor_unitario" class="form-label">Valor unitario: </label>
            <input type="number" class="form-control" id="valor_unitario" name="valor_unitario" minlength="9" maxlength="100" value="{{ old('valor_unitario', $producto->valor_unitario) }}" placeholder="correo@ejemplo.com" required>
        </div>

        <div class="mb-3">
            <label for="unidad_medida" class="form-label">Unidad de medida: </label>
            <input type="text" class="form-control" id="unidad_medida" name="unidad_medida" min="1000000000" max="999999999999999" value="{{ old('unidad_medida', $producto->unidad_medida) }}" placeholder="1234567890" required>
        </div>
            <label for="estado" class="form-label">Estado: </label>
            <select name="estado_producto" id="estado_producto" class="form-select" required>
                <option value="" disabled selected>Seleccione un estado</option>
                <option value="ACTIVO" {{ old('estado_producto', $producto->estado_producto) == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                <option value="INACTIVO" {{ old('estado_producto', $producto->estado_producto) == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Guardar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection