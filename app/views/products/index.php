<div class="row mb-4">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">Productos</h3>
                <small class="text-muted">Catálogo disponible</small>
            </div>
            <?php if (!empty($_GET['success'])): ?>
                <span class="badge bg-success">Producto creado</span>
            <?php endif; ?>
        </div>
        <table class="table table-striped table-sm">
            <thead class="table-light">
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
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Nuevo producto</div>
            <div class="card-body">
                <form method="POST" action="/inventario/productos">
                    <input type="hidden" name="_token" value="<?php echo $csrf; ?>">
                    <div class="mb-2">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Código de barras</label>
                        <input type="text" name="barcode" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Unidad</label>
                        <select name="unit" class="form-select">
                            <option value="unidad">Unidad</option>
                            <option value="kg">Kg</option>
                            <option value="m">Metro</option>
                            <option value="lts">Litro</option>
                        </select>
                    </div>
                    <div class="mb-2 form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="tax_included" name="tax_included" checked>
                        <label class="form-check-label" for="tax_included">Incluye IVA</label>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col">
                            <label class="form-label">Costo</label>
                            <input type="number" step="0.01" name="cost_price" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Precio venta</label>
                            <input type="number" step="0.01" name="sale_price" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col">
                            <label class="form-label">Descuento máx %</label>
                            <input type="number" step="0.01" name="discount_max" class="form-control" value="0">
                        </div>
                        <div class="col">
                            <label class="form-label">Stock mínimo</label>
                            <input type="number" name="stock_min" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Proveedor</label>
                        <select name="provider_id" class="form-select">
                            <option value="">Seleccione</option>
                            <?php foreach ($providers as $provider): ?>
                                <option value="<?php echo $provider['id']; ?>"><?php echo App\Core\Helper::e($provider['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
