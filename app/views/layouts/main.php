<?php
use App\Core\Auth;
use App\Core\Helper;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Helper::e($data['title'] ?? 'ERP Inventario'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-light">
<div class="d-flex" id="wrapper">
    <aside class="sidebar bg-white shadow-sm" id="sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div class="brand-logo">ERP</div>
                <div>
                    <h6 class="mb-0 fw-bold text-primary">Inventario</h6>
                    <small class="text-muted">Panel</small>
                </div>
            </div>
            <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle" aria-label="Alternar menú">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <nav class="nav flex-column py-3">
            <div class="px-3 text-uppercase text-muted small fw-semibold">Principal</div>
            <a class="nav-link px-3 <?php echo Helper::isActive('/dashboard') || Helper::isActive('/') ? 'active' : ''; ?>" href="/dashboard">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <div class="px-3 mt-3 text-uppercase text-muted small fw-semibold">Ventas</div>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/ventas/pos']) ?>" href="/ventas/pos"><i class="bi bi-cash-register me-2"></i> POS</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/ventas']) ?>" href="/ventas"><i class="bi bi-receipt me-2"></i> Ventas</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/ventas/cotizaciones']) ?>" href="/ventas/cotizaciones"><i class="bi bi-file-earmark-text me-2"></i> Cotizaciones</a>
            <div class="px-3 mt-3 text-uppercase text-muted small fw-semibold">Inventario</div>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/inventario/productos','/productos']) ?>" href="/inventario/productos"><i class="bi bi-box-seam me-2"></i> Productos</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/inventario']) ?>" href="/inventario"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/bodegas']) ?>" href="/bodegas"><i class="bi bi-buildings me-2"></i> Bodegas</a>
            <div class="px-3 mt-3 text-uppercase text-muted small fw-semibold">Compras</div>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/proveedores']) ?>" href="/proveedores"><i class="bi bi-truck me-2"></i> Proveedores</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/compras']) ?>" href="/compras"><i class="bi bi-bag-check me-2"></i> Compras</a>
            <div class="px-3 mt-3 text-uppercase text-muted small fw-semibold">Clientes y créditos</div>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/clientes']) ?>" href="/clientes"><i class="bi bi-people me-2"></i> Clientes</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/cobranzas']) ?>" href="/cobranzas"><i class="bi bi-clipboard-data me-2"></i> Cuentas por cobrar</a>
            <div class="px-3 mt-3 text-uppercase text-muted small fw-semibold">Finanzas</div>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/cajas']) ?>" href="/cajas"><i class="bi bi-safe me-2"></i> Cajas</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/gastos']) ?>" href="/gastos"><i class="bi bi-cash-coin me-2"></i> Gastos</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/cierres']) ?>" href="/cierres"><i class="bi bi-journal-check me-2"></i> Cierres</a>
            <div class="px-3 mt-3 text-uppercase text-muted small fw-semibold">Configuración</div>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/usuarios']) ?>" href="/usuarios"><i class="bi bi-shield-lock me-2"></i> Usuarios</a>
            <a class="nav-link px-3 <?php echo Helper::isActivePrefix(['/parametros']) ?>" href="/parametros"><i class="bi bi-gear me-2"></i> Parámetros</a>
        </nav>
    </aside>

    <div class="main flex-grow-1">
        <header class="topbar d-flex align-items-center justify-content-between shadow-sm px-4 py-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary btn-sm d-none d-lg-inline" id="sidebarToggleDesktop" aria-label="Alternar menú">
                    <i class="bi bi-layout-sidebar-inset"></i>
                </button>
                <h5 class="mb-0 fw-semibold text-primary">Bienvenido</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <?php if ($user): ?>
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-semibold text-dark"><?php echo Helper::e($user['name']); ?></div>
                        <small class="text-muted text-capitalize"><?php echo Helper::e($user['role_name'] ?? $user['role_slug'] ?? 'Usuario'); ?></small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> Cuenta
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <main class="content p-4">
            <?php include $viewPath; ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
