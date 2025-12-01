<div class="row mb-4">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">Proveedores</h3>
                <small class="text-muted">Socios comerciales</small>
            </div>
            <?php if (!empty($_GET['success'])): ?>
                <span class="badge bg-success">Proveedor guardado</span>
            <?php endif; ?>
        </div>
        <table class="table table-striped table-sm">
            <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>RUT</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Condición</th>
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
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Nuevo proveedor</div>
            <div class="card-body">
                <form method="POST" action="/proveedores">
                    <input type="hidden" name="_token" value="<?php echo $csrf; ?>">
                    <div class="mb-2">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">RUT</label>
                        <input type="text" name="tax_id" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Condición de pago</label>
                        <input type="text" name="payment_terms" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Notas</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
