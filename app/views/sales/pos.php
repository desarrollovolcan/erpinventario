<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Venta rápida</h5>
                    <small class="text-muted">Registra una venta y descuenta stock</small>
                </div>
                <a href="/ventas" class="btn btn-outline-secondary btn-sm">Volver</a>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="/ventas/pos">
                    <input type="hidden" name="_token" value="<?php echo $csrf; ?>">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Producto</label>
                            <select name="product_id" class="form-select" required>
                                <option value="">Seleccione</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>"><?php echo App\Core\Helper::e($product['name']); ?> - $<?php echo number_format($product['sale_price'], 0, ',', '.'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" min="0.1" step="0.1" name="quantity" class="form-control" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Bodega</label>
                            <select name="warehouse_id" class="form-select" required>
                                <?php foreach ($warehouses as $warehouse): ?>
                                    <option value="<?php echo $warehouse['id']; ?>"><?php echo App\Core\Helper::e($warehouse['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <select name="customer_id" class="form-select">
                                <option value="">Mostrador</option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?php echo $customer['id']; ?>"><?php echo App\Core\Helper::e($customer['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Forma de pago</label>
                            <select name="payment_method" class="form-select">
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="crédito">Crédito</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de vencimiento (solo crédito)</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar venta</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-header">Resumen</div>
            <div class="card-body">
                <p class="text-muted">Selecciona producto y cantidad para calcular totales. Se aplicará IVA cuando corresponda.</p>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-check-circle text-success me-1"></i> Descuenta stock automáticamente</li>
                    <li><i class="bi bi-check-circle text-success me-1"></i> Crea cuenta por cobrar si eliges crédito</li>
                    <li><i class="bi bi-check-circle text-success me-1"></i> Registra movimiento de inventario</li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Ayuda</div>
            <div class="card-body">
                <p class="small mb-1">Escanea código de barras o selecciona producto para agilizar el proceso.</p>
                <p class="small mb-1">Puedes editar los datos del cliente desde el módulo de clientes.</p>
                <p class="small">Si tienes dudas, contacta al administrador.</p>
            </div>
        </div>
    </div>
</div>
