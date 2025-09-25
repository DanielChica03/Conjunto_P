@php
    $usuario = session('usuario');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Conjunto')</title>
    <link rel="stylesheet" href="../../css/estilos.css">
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

        .footer {
            background: #4a2c2a;
            color: #fdfbf8;
            padding: 40px 0;
            text-align: center;
        }

        .footer h6 {
            color: #d6b27d; 
            font-weight: bold;
        }

        .footer a {
            color: #fdfbf8;
            text-decoration: none;
        }

        .footer a:hover {
            color: #d6b27d;
        }

        .footer .text-center {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #ddd;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.2rem;
            color: #fff;
        }
    </style>
</head>
<body>
    <div>
        
        <div class="container mt-5">
            @if($usuario && strtoupper($usuario->tipo_usuario) === 'ADMINISTRADOR')
                <h2>Bienvenido Administrador, {{ session('usuario')->nombre }}</h2>
            @elseif($usuario && strtoupper($usuario->tipo_usuario) === 'CLIENTE')
                <h2>Bienvenido Cliente, {{ session('usuario')->nombre }}</h2>
            @elseif($usuario && strtoupper($usuario->tipo_usuario) === 'CAJERO')
                <h2>Bienvenido Cajero, {{ session('usuario')->nombre }}</h2>
            @endif 
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
                <a href="{{ route('pagos.index') }}" class="navbar-brand">Pagos</a>
            @elseif($usuario && strtoupper($usuario->tipo_usuario) === 'CLIENTE')
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Perfil</a>
                <a href="{{ route('productos.index') }}" class="navbar-brand">Productos</a>
                <a href="{{ route('deudas.index') }}" class="navbar-brand">Mis deudas</a>
                <a href="{{ route('ventas.index') }}" class="navbar-brand">Mis Compras</a>
                <a href="{{ route('pagos.index') }}" class="navbar-brand">Pagos</a>
            @elseif($usuario && strtoupper($usuario->tipo_usuario) === 'CAJERO')
                <a href="{{ route('usuarios.index') }}" class="navbar-brand">Usuarios</a>
                <a href="{{ route('deudas.index') }}" class="navbar-brand">Deudas</a>
                <a href="{{ route('ventas.index') }}" class="navbar-brand">Ventas</a>
                <a href="{{ route('pagos.index') }}" class="navbar-brand">Pagos</a>
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

    <footer class="footer mt-5">
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">Sobre la empresa</h6>
                    <p>Venta de los mejores productos en el conjunto de Yerba Mora.</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">Enlaces Rápidos</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Productos</a></li>
                        <li><a href="#">Ofertas</a></li>
                        <li><a href="#">Política de Privacidad</a></li>
                        <li><a href="#">Términos y Condiciones</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">Contáctenos</h6>
                    <p><i class="bi bi-geo-alt"></i> Calle 145# 128 - 41, Bogotá, Colombia</p>
                    <p><i class="bi bi-telephone"></i> 320 12345678</p>
                    <p><i class="bi bi-envelope"></i> diego.soler@gmail.com</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">Síguenos</h6>
                    <a href="#"><i class="bi bi-facebook me-2"></i></a>
                    <a href="#"><i class="bi bi-twitter me-2"></i></a>
                    <a href="#"><i class="bi bi-instagram me-2"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <div class="text-center mt-3">
                © 2023 INNOVAR. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-TODO" crossorigin="anonymous"></script>
</body>
</html>
