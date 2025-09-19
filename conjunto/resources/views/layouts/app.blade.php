<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Conjunto')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Conjunto</a>
            </div>
        </nav>
        <div class="navbar navbar-expand-lg navbar-success container">
            @php
                $usuario = session('usuario');
            @endphp

            @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Usuarios</a>
                <a href="{{ route('inventario.index') }}" class="navbar-brand">Inventario</a>
                <a href="{{ route('productos.index') }}" class="navbar-brand">Productos</a>
                <a href="{{ route('proveedores.index') }}" class="navbar-brand">Proveedores</a>
                <a href="{{ route('compras.index') }}" class="navbar-brand">Compras</a>
                <a href="{{ route('deudas.index') }}" class="navbar-brand">Deudas</a>
                <a href="{{ route('ventas.index') }}" class="navbar-brand">Ventas</a>
            @else
                {{-- Aquí puedes poner el menú para otros roles o dejarlo vacío --}}
            @endif
        </div>
    @yield('menu')
    </div>

    <main class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-TODO" crossorigin="anonymous"></script>
</body>
</html>
