<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Cajero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Bienvenido Cajero, {{ session('usuario')->nombre }}</h2>
        <ul>
            <li><a href="#">Facturación</a></li>
            <li><a href="#">Reportes</a></li>
            <li><a href="#">Mi Perfil</a></li>
            <li><a href="#">Volver a Tienda</a></li>
        </ul>
    </div>
</body>
</html>