@php
    $usuario = session('usuario');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Conjunto')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .table-custom th {
            background: #ff9800;
            color: #fff;
            border: none;
            font-weight: 600;
            font-size: 1rem;
        }
        .table-custom td {
            background: #fff8f0;
            border: none;
            color: #4b2c25;
            vertical-align: middle;
        }
        .table-custom tr {
            border-bottom: 1px solid #e0c3a0;
        }
        .btn-primary {
            background: #ff9800;
            border: none;
            color: #fff;
            font-weight: 600;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #e68900;
            color: #fff;
        }
        .btn-info {
            background: #4b2c25;
            border: none;
            color: #fff;
            font-weight: 600;
        }
        .btn-info:hover, .btn-info:focus {
            background: #6d3c2a;
            color: #fff;
        }
        .btn-danger {
            background: #b23c17;
            border: none;
            color: #fff;
            font-weight: 600;
        }
        .btn-danger:hover, .btn-danger:focus {
            background: #a12e0c;
            color: #fff;
        }
    </style>
</head>
<body>
    <div>
        
        <div class="container mt-5">
            <h2>Bienvenido Administrador, {{ session('usuario')->nombre }}</h2>
        </div>
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Conjunto</a>
                <!-- Cerrar sesion -->
                <div class="d-flex">
                    @if($usuario)
                        <span class="navbar-text text-white me-3">Hola, {{ $usuario->nombre }}</span>
                        <a href="{{ route('index') }}" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar Sesión</a>
                    @endif
            </div>
        </nav>
        <div class="navbar navbar-expand-lg navbar-success container">

            @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Usuarios</a>
                <a href="{{ route('inventario.index') }}" class="navbar-brand">Inventario</a>
                <a href="{{ route('productos.index') }}" class="navbar-brand">Productos</a>
                <a href="{{ route('proveedores.index') }}" class="navbar-brand">Proveedores</a>
                <a href="{{ route('compras.index') }}" class="navbar-brand">Compras</a>
                <a href="{{ route('deudas.index') }}" class="navbar-brand">Deudas</a>
                <a href="{{ route('ventas.index') }}" class="navbar-brand">Ventas</a>
            @elseif($usuario && strtoupper($usuario->tipo_usuario) === 'CLIENTE')
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Perfil</a>
                <a href="{{ route('productos.index') }}" class="navbar-brand">Productos</a>
                <a href="{{ route('deudas.index') }}" class="navbar-brand">Mis deudas</a>
                <a href="{{ route('ventas.index') }}" class="navbar-brand">Mis Compras</a>
            @elseif($usuario && strtoupper($usuario->tipo_usuario) === 'CAJERO')
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Usuarios</a>
                <a href="{{ route('inventario.index') }}" class="navbar-brand">Inventario</a>
                <a href="{{ route('productos.index') }}" class="navbar-brand">Productos</a>
                <a href="{{ route('proveedores.index') }}" class="navbar-brand">Proveedores</a>
                <a href="{{ route('compras.index') }}" class="navbar-brand">Compras</a>
                <a href="{{ route('deudas.index') }}" class="navbar-brand">Deudas</a>
                <a href="{{ route('ventas.index') }}" class="navbar-brand">Ventas</a>
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
