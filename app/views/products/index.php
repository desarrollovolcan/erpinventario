<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Productos</h3>
    <button class="btn btn-sm btn-primary">Nuevo producto</button>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>SKU</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Proveedor</th>
        <th>Precio venta</th>
        <th>Stock mínimo</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo App\Core\Helper::e($product['sku']); ?></td>
            <td><?php echo App\Core\Helper::e($product['name']); ?></td>
            <td><?php echo App\Core\Helper::e($product['category']); ?></td>
            <td><?php echo App\Core\Helper::e($product['provider']); ?></td>
            <td>$<?php echo number_format($product['sale_price'], 0, ',', '.'); ?></td>
            <td><?php echo $product['stock_min']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
