@extends('layouts.app')

<body>
    <div>
        {{-- filepath: c:\xampp\htdocs\Conjunto_P\conjunto\resources\views\dashboard\admin.blade.php --}}
    @php
        $usuario = session('usuario');
        if (!$usuario || strtoupper($usuario->tipo_usuario) !== 'ADMINISTRADOR') {
            header('Location: /login');
            exit;
        }
    @endphp

    <div class="container mt-5">
        <h2>Bienvenido Administrador, {{ session('usuario')->nombre }}</h2>
        @section('menu')
        @endsection
    </div>
    @section('admin')
    </div>
</body>
</html>