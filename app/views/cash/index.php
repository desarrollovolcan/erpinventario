<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Cajas</h5>
            <small class="text-muted">Jornadas y aperturas registradas</small>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm">
            <thead class="table-light">
            <tr>
                <th>Cajero</th>
                <th>Bodega</th>
                <th>Abierta</th>
                <th>Saldo inicial</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sessions as $session): ?>
                <tr>
                    <td><?php echo App\Core\Helper::e($session['user']); ?></td>
                    <td><?php echo App\Core\Helper::e($session['warehouse']); ?></td>
                    <td><?php echo $session['opened_at']; ?></td>
                    <td>$<?php echo number_format($session['opening_amount'], 0, ',', '.'); ?></td>
                    <td><span class="badge bg-<?php echo $session['status'] === 'open' ? 'success' : 'secondary'; ?>"><?php echo App\Core\Helper::e($session['status']); ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
