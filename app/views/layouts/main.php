<?php use App\Core\Helper; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Helper::e($data['title'] ?? 'ERP Inventario'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">ERP Inventario</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/productos">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="/inventario">Inventario</a></li>
                <li class="nav-item"><a class="nav-link" href="/compras">Compras</a></li>
                <li class="nav-item"><a class="nav-link" href="/clientes">Clientes</a></li>
                <li class="nav-item"><a class="nav-link" href="/proveedores">Proveedores</a></li>
                <li class="nav-item"><a class="nav-link" href="/reportes">Reportes</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (\App\Core\Auth::check()): ?>
                    <li class="nav-item"><span class="navbar-text text-white">Hola <?php echo Helper::e(\App\Core\Auth::user()['name']); ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Salir</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <?php include $viewPath; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
