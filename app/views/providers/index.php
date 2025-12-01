<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Proveedores</h3>
    <button class="btn btn-sm btn-primary">Nuevo proveedor</button>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>RUT</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Condición de pago</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($providers as $provider): ?>
        <tr>
            <td><?php echo App\Core\Helper::e($provider['name']); ?></td>
            <td><?php echo App\Core\Helper::e($provider['tax_id']); ?></td>
            <td><?php echo App\Core\Helper::e($provider['phone']); ?></td>
            <td><?php echo App\Core\Helper::e($provider['email']); ?></td>
            <td><?php echo App\Core\Helper::e($provider['payment_terms']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
