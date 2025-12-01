<div class="row">
    <div class="col-12 mb-3">
        <h2>Panel de control</h2>
        <p class="text-muted">Bienvenido <?php echo App\Core\Helper::e($user['name']); ?> (<?php echo App\Core\Helper::e($user['role_name']); ?>)</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Ventas hoy</h5>
                <p class="card-text">$<?php echo number_format($stats['today'], 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Ventas semana</h5>
                <p class="card-text">$<?php echo number_format($stats['week'], 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Ventas mes</h5>
                <p class="card-text">$<?php echo number_format($stats['month'], 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Top productos</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($topProducts as $product): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo App\Core\Helper::e($product['name']); ?>
                            <span class="badge bg-primary rounded-pill"><?php echo $product['qty']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Alertas</div>
            <div class="card-body">
                <h6>Bajo stock</h6>
                <ul>
                    <?php foreach ($alerts['lowStock'] as $item): ?>
                        <li><?php echo App\Core\Helper::e($item['name']); ?> (<?php echo $item['total_stock']; ?> / mínimo <?php echo $item['stock_min']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
                <h6>Cuentas por cobrar vencidas</h6>
                <ul>
                    <?php foreach ($alerts['receivables'] as $item): ?>
                        <li><?php echo App\Core\Helper::e($item['name']); ?> - $<?php echo number_format($item['balance'], 0, ',', '.'); ?> (<?php echo $item['due_date']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Movimientos recientes</div>
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Bodega</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($inventoryMovements as $move): ?>
                    <tr>
                        <td><?php echo $move['movement_date']; ?></td>
                        <td><?php echo App\Core\Helper::e($move['product']); ?></td>
                        <td><?php echo App\Core\Helper::e($move['warehouse']); ?></td>
                        <td><?php echo App\Core\Helper::e($move['type']); ?></td>
                        <td><?php echo $move['quantity']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
