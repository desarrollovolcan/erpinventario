<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="mb-0">Ventas</h3>
        <small class="text-muted">Listado de ventas recientes</small>
    </div>
    <a class="btn btn-primary" href="/ventas/pos"><i class="bi bi-plus-lg me-1"></i>Nueva venta</a>
</div>
<table class="table table-hover table-sm align-middle">
    <thead class="table-light">
    <tr>
        <th>#</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Usuario</th>
        <th>Bodega</th>
        <th>Forma de pago</th>
        <th>Total</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sales as $sale): ?>
        <tr>
            <td><?php echo $sale['id']; ?></td>
            <td><?php echo $sale['created_at']; ?></td>
            <td><?php echo App\Core\Helper::e($sale['customer'] ?? 'Mostrador'); ?></td>
            <td><?php echo App\Core\Helper::e($sale['user']); ?></td>
            <td><?php echo App\Core\Helper::e($sale['warehouse']); ?></td>
            <td class="text-capitalize"><?php echo App\Core\Helper::e($sale['payment_method']); ?></td>
            <td>$<?php echo number_format($sale['total'], 0, ',', '.'); ?></td>
            <td><span class="badge bg-<?php echo $sale['status'] === 'pagada' ? 'success' : 'warning'; ?>"><?php echo App\Core\Helper::e($sale['status']); ?></span></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
