@extends('layouts.app')
@section('title', 'Crear Producto')

    @section('content')
    @section('menu')
    @endsection
    @php
    $usuario = session('usuario');
@endphp
@if(strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')

<h1 class="h4 mb-3">Crear Producto</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if($usuario && strtoupper($usuario->tipo_usuario) === 'CAJERO' || strtoupper($usuario->tipo_usuario) === 'CLIENTE')
    <div class="alert alert-danger">
        <ul class="mb-0">
            <li>No tiene permisos para crear productos.</li>
        </ul>
    </div>
@endif
@if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
<form action="{{ route('productos.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre: </label>
            <input type="text" class="form-control" id="nombre" name="nombre_producto" minlength="2" maxlength="100" value="{{ old('nombre') }}" placeholder="Galletas oreo" required>
        </div>
        
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción: </label>
            <input type="text" class="form-control" id="descripcion" name="descripcion_producto" minlength="2" maxlength="100" value="{{ old('descripcion') }}" placeholder="Galletas de chocolate con relleno de vainilla, paquete de 6 unidades" required>
        </div>

        <div class="mb-3">
            <label for="valor_unitario" class="form-label">Valor unitario: </label>
            <input type="number" class="form-control" id="valor_unitario" name="valor_unitario" min="50" value="{{ old('valor_unitario') }}" placeholder="1200" required>
        </div>

        <div class="mb-3">
            <label for="unidad_medida" class="form-label">Unidad de medida: </label>
            <input type="text" class="form-control" id="unidad_medida" name="unidad_medida" minlength="2" maxlength="100" value="{{ old('unidad_medida') }}" placeholder="120g" required>
        </div>
        <button type="submit" class="btn btn-danger">Guardar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secundary">Cancelar</a>
    </form>
@endif
@else
    <div class="alert alert-danger">
        <h4 class="alert-heading">Acceso Denegado</h4>
        <p>No tienes permiso para acceder a esta página.</p>
    </div>
@endif
@endsection
