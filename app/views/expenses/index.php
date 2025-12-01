<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Gastos</h5>
            <small class="text-muted">Movimientos recientes</small>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-sm">
            <thead class="table-light">
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Forma de pago</th>
                <th>Usuario</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td><?php echo $expense['expense_date']; ?></td>
                    <td><?php echo App\Core\Helper::e($expense['type']); ?></td>
                    <td>$<?php echo number_format($expense['amount'], 0, ',', '.'); ?></td>
                    <td><?php echo App\Core\Helper::e($expense['payment_method']); ?></td>
                    <td><?php echo App\Core\Helper::e($expense['user']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
