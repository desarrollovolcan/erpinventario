<?php
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ProductController;
use App\Controllers\InventoryController;
use App\Controllers\ProviderController;
use App\Controllers\CustomerController;
use App\Controllers\PurchaseController;
use App\Controllers\ReportController;

return function (\App\Core\Router $router): void {
    $router->get('/', [DashboardController::class, 'index']);
    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/logout', [AuthController::class, 'logout']);

    $router->get('/productos', [ProductController::class, 'index']);
    $router->get('/inventario', [InventoryController::class, 'index']);
    $router->get('/proveedores', [ProviderController::class, 'index']);
    $router->get('/clientes', [CustomerController::class, 'index']);
    $router->get('/compras', [PurchaseController::class, 'index']);
    $router->get('/reportes', [ReportController::class, 'index']);
};
