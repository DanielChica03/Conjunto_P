@extends('layouts.app')
@section('title','Editar Usuario')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Editar Usuario</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update',$usuario) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="cedula" class="form-label">Cedula: </label>
            <input type="number" readonly class="form-control" id="cedula" name="cedula" min="1000000" max="999999999999" value="{{ old('cedula', $usuario->cedula) }}" placeholder="1245632874" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre: </label>
            <input type="text" class="form-control" id="nombre" name="nombre" minlength="2" maxlength="100" value="{{ old('nombre', $usuario->nombre) }}" placeholder="Juan" required>
        </div>
        
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido: </label>
            <input type="text" class="form-control" id="apellido" name="apellido" minlength="2" maxlength="100" value="{{ old('apellido', $usuario->apellido) }}" placeholder="Pérez" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo: </label>
            <input type="email" class="form-control" id="correo" name="correo" minlength="9" maxlength="100" value="{{ old('correo', $usuario->correo) }}" placeholder="correo@ejemplo.com" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Telefono: </label>
            <input type="number" class="form-control" id="telefono" name="telefono" min="1000000000" max="999999999999999" value="{{ old('telefono', $usuario->telefono) }}" placeholder="1234567890" required>
        </div>
        <div class="mb-3">
            <label for="genero" class="form-label">Genero: </label>
            <select name="genero" id="genero" class="form-select" required>
                <option value="" disabled selected>Seleccione un género</option>
                <option value="MASCULINO" {{ old('genero', $usuario->genero) == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                <option value="FEMENINO" {{ old('genero', $usuario->genero) == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                <option value="OTRO" {{ old('genero', $usuario->genero) == 'OTRO' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento: </label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento) }}" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado: </label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="" disabled selected>Seleccione un estado</option>
                <option value="ACTIVO" {{ old('estado', $usuario->estado) == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                <option value="INACTIVO" {{ old('estado', $usuario->estado) == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Guardar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection