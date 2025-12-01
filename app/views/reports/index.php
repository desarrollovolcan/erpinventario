<div class="row mb-3">
    <div class="col-12">
        <h3>Reportes</h3>
        <p class="text-muted">Informes básicos de ventas, inventario y finanzas.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Ventas por día</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($salesByDay as $row): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><?php echo $row['day']; ?></span>
                        <strong>$<?php echo number_format($row['total'], 0, ',', '.'); ?></strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Valor inventario actual</div>
            <div class="card-body">
                <p class="display-6">$<?php echo number_format($inventoryValue, 0, ',', '.'); ?></p>
                <button class="btn btn-outline-secondary btn-sm">Exportar CSV</button>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Cuentas por cobrar</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($accountsReceivable as $item): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><?php echo App\Core\Helper::e($item['name']); ?> (<?php echo $item['due_date']; ?>)</span>
                        <strong>$<?php echo number_format($item['balance'], 0, ',', '.'); ?></strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
