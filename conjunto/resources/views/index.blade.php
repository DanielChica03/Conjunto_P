<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Store Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .main-header { background: #4b2c25; color: #fff; }
        .main-header .navbar-brand img { height: 70px; }
        .category-icon { font-size: 2.5rem; color: #b97a3c; }
        .card { border: none; }
        .footer { background: #222; color: #fff; padding: 40px 0; }
        .footer a { color: #fff; }
        .footer .fw-bold { color: #bfa14a; }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg main-header">
        <div class="container">
            <a class="navbar-brand mx-auto" href="#">
                <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" alt="Store Logo">
                <span class="ms-2">STORE <span class="fw-light">PRODUCTS</span></span>
            </a>
            <div class="d-flex align-items-center">
                <a href="{{ route('login') }}" class="me-3 text-white"><i class="bi bi-person-circle"></i></a>
                <a href="#" class="text-white"><i class="bi bi-cart3"></i></a>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: #4b2c25;">
        <div class="container">
            <form class="d-flex me-4">
                <input class="form-control me-2" type="search" placeholder="¿Qué estás buscando?" aria-label="Buscar">
                <button class="btn btn-warning" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Productos</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Destacados</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Contáctenos</a></li>
            </ul>
        </div>
    </nav>
    <!-- Categorías -->
    <div class="container my-4">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card p-4">
                    <div class="category-icon mb-2 text-center">🍬</div>
                    <h4 class="fw-bold">Dulces</h4>
                    <ul>
                        <li>Chocolatinas</li>
                        <li>Galletas</li>
                        <li>Chicles</li>
                        <li>Caramelos</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card p-4">
                    <div class="category-icon mb-2 text-center">📦</div>
                    <h4 class="fw-bold">Paquetes</h4>
                    <ul>
                        <li>Papas fritas</li>
                        <li>Maní</li>
                        <li>Palomitas</li>
                        <li>Tostacos</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card p-4">
                    <div class="category-icon mb-2 text-center">🍹</div>
                    <h4 class="fw-bold">Jugos y Gaseosas</h4>
                    <ul>
                        <li>Coca-Cola</li>
                        <li>Pepsi</li>
                        <li>Hit</li>
                        <li>Jugos naturales</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card p-4">
                    <div class="category-icon mb-2 text-center">🧼</div>
                    <h4 class="fw-bold">Productos de Aseo</h4>
                    <ul>
                        <li>Jabón de baño</li>
                        <li>Detergente</li>
                        <li>Papel higiénico</li>
                        <li>Desinfectantes</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card p-4">
                    <div class="category-icon mb-2 text-center">🍏</div>
                    <h4 class="fw-bold">Frutas y Verduras</h4>
                    <ul>
                        <li>Manzanas</li>
                        <li>Plátanos</li>
                        <li>Tomates</li>
                        <li>Zanahorias</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card p-4">
                    <div class="category-icon mb-2 text-center">👕</div>
                    <h4 class="fw-bold">Panadería</h4>
                    <ul>
                        <li>Pan de bono</li>
                        <li>Pan tajado</li>
                        <li>Almojábanas</li>
                        <li>Roscones</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
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
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>
</html>