<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Cuentas por cobrar</h5>
            <small class="text-muted">Documentos vencidos o pendientes</small>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-sm">
            <thead class="table-light">
            <tr>
                <th>Cliente</th>
                <th>Saldo</th>
                <th>Vencimiento</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($accounts as $account): ?>
                <tr>
                    <td><?php echo App\Core\Helper::e($account['name']); ?></td>
                    <td>$<?php echo number_format($account['balance'], 0, ',', '.'); ?></td>
                    <td><?php echo $account['due_date']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
