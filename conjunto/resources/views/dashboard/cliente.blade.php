@extends('layouts.app')

<body>
    <div class="container mt-5">
        <h2>Bienvenido cliente, {{ session('usuario')->nombre }}</h2>
    </div>
</body>
</html>