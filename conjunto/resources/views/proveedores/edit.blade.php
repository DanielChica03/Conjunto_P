@extends('layouts.app')
@section('title', 'Lista de Proveedores')
@section('content')

<div class="container">
    <h1 class="h4 mb-3">Editar Proveedor</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proveedores.update', $proveedor) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id" class="form-label">ID:</label>
            <input type="text" class="form-control" id="id" name="id" value="{{ old('id', $proveedor->id) }}" required readonly>
        </div>
        
        <div class="mb-3">
            <label for="nombre_proveedor" class="form-label">Nombre del Proveedor:</label>
            <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" maxlength="50" value="{{ old('nombre_proveedor', $proveedor->nombre_proveedor) }}" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15" value="{{ old('telefono', $proveedor->telefono) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" maxlength="100" value="{{ old('email', $proveedor->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" maxlength="100" value="{{ old('direccion', $proveedor->direccion) }}" required>
        </div>

        <button type="submit" class="btn btn-danger">Actualizar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection