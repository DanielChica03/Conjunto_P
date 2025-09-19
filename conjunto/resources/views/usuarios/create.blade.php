@extends('layouts.app')
@section('title', 'Crear Usuario')
    @php
        $usuario = session('usuario');
        if ($usuario === 'ADMINISTRADOR'){
            @section('admin')
            @endsection
        }
    @endphp

<h1 class="h4 mb-3">Crear Usuario</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('usuarios.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="cedula" class="form-label">Cedula: </label>
            <input type="number" class="form-control" id="cedula" name="cedula" min="1000000" max="999999999999" value="{{ old('cedula') }}" placeholder="1245632874" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" minlength="2" maxlength="100" value="{{ old('nombre') }}" placeholder="Juan" required>
        </div>
        
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" minlength="2" maxlength="100" value="{{ old('apellido') }}" placeholder="Pérez" required>
        </div>

        <div class="mb-3">
            <label for="clave" class="form-label">Clave</label>
            <input type="password" class="form-control" id="clave" name="clave" minlength="8" maxlength="100" value="{{ old('clave') }}" placeholder="Ingrese su clave" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" minlength="9" maxlength="100" value="{{ old('correo') }}" placeholder="correo@ejemplo.com" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="number" class="form-control" id="telefono" name="telefono" min="3000000000" max="3999999999" value="{{ old('telefono') }}" placeholder="3125565849" required>
        </div>
        <div class="mb-3">
            <label for="genero" class="form-label">Genero</label>
            <select name="genero" id="genero" class="form-select" required>
                <option value="" disabled selected>Seleccione un género</option>
                <option value="MASCULINO" {{ old('genero') == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                <option value="FEMENINO" {{ old('genero') == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                <option value="OTRO" {{ old('genero') == 'OTRO' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
        </div>
        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-select" required>
                <option value="" disabled selected>Seleccione un tipo de usuario</option>
                <option value="ADMINISTRADOR" {{ old('tipo_usuario') == 'ADMINISTRADOR' ? 'selected' : '' }}>Administrador</option>
                <option value="CLIENTE" {{ old('tipo_usuario') == 'CLIENTE' ? 'selected' : '' }}>Cliente</option>
                <option value="CAJERO" {{ old('tipo_usuario') == 'CAJERO' ? 'selected' : '' }}>Cajero</option>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Guardar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secundary">Cancelar</a>
        @yield('adminU')
    </form>

@endsection
