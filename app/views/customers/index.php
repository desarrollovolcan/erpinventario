<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Clientes</h3>
    <button class="btn btn-sm btn-primary">Nuevo cliente</button>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>RUT</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Límite crédito</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?php echo App\Core\Helper::e($customer['name']); ?></td>
            <td><?php echo App\Core\Helper::e($customer['tax_id']); ?></td>
            <td><?php echo App\Core\Helper::e($customer['phone']); ?></td>
            <td><?php echo App\Core\Helper::e($customer['email']); ?></td>
            <td>$<?php echo number_format($customer['credit_limit'], 0, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
