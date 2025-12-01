<?php
use App\Controllers\AuthController;
use App\Controllers\CashController;
use App\Controllers\ClosingController;
use App\Controllers\CustomerController;
use App\Controllers\DashboardController;
use App\Controllers\ExpenseController;
use App\Controllers\HomeController;
use App\Controllers\InventoryController;
use App\Controllers\ProductController;
use App\Controllers\ProviderController;
use App\Controllers\PurchaseController;
use App\Controllers\ReceivableController;
use App\Controllers\ReportController;
use App\Controllers\SalesController;
use App\Controllers\SettingsController;
use App\Controllers\UserController;
use App\Controllers\WarehouseController;

return function (\App\Core\Router $router): void {
    $router->setPublicPaths(['/', '/login']);

    $router->get('/', [HomeController::class, 'index']);
    $router->get('/dashboard', [DashboardController::class, 'index']);
    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/logout', [AuthController::class, 'logout']);

    $router->get('/productos', [ProductController::class, 'index']);
    $router->match('/inventario/productos', [ProductController::class, 'index']);
    $router->get('/inventario', [InventoryController::class, 'index']);
    $router->match('/proveedores', [ProviderController::class, 'index']);
    $router->match('/clientes', [CustomerController::class, 'index']);
    $router->match('/usuarios', [UserController::class, 'index']);
    $router->match('/ventas/pos', [SalesController::class, 'pos']);
    $router->get('/ventas', [SalesController::class, 'index']);
    $router->get('/ventas/cotizaciones', [SalesController::class, 'quotes']);
    $router->get('/bodegas', [WarehouseController::class, 'index']);
    $router->get('/compras', [PurchaseController::class, 'index']);
    $router->get('/reportes', [ReportController::class, 'index']);
    $router->get('/cobranzas', [ReceivableController::class, 'index']);
    $router->get('/cajas', [CashController::class, 'index']);
    $router->get('/gastos', [ExpenseController::class, 'index']);
    $router->get('/cierres', [ClosingController::class, 'index']);
    $router->get('/parametros', [SettingsController::class, 'index']);
};
