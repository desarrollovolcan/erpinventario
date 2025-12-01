<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Compras</h3>
    <button class="btn btn-sm btn-primary">Registrar compra</button>
</div>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Proveedor</th>
        <th>Número documento</th>
        <th>Fecha emisión</th>
        <th>Estado</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($purchases as $purchase): ?>
        <tr>
            <td><?php echo App\Core\Helper::e($purchase['provider']); ?></td>
            <td><?php echo App\Core\Helper::e($purchase['document_number']); ?></td>
            <td><?php echo $purchase['issue_date']; ?></td>
            <td><?php echo App\Core\Helper::e($purchase['status']); ?></td>
            <td>$<?php echo number_format($purchase['total'], 0, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
