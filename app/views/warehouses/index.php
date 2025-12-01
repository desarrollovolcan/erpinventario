<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Bodegas</h5>
            <small class="text-muted">Listado de sucursales y bodegas</small>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm">
            <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($warehouses as $warehouse): ?>
                <tr>
                    <td><?php echo App\Core\Helper::e($warehouse['name']); ?></td>
                    <td><?php echo App\Core\Helper::e($warehouse['address']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
