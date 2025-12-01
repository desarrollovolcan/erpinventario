<div class="row mb-4">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">Clientes</h3>
                <small class="text-muted">Registra clientes y condiciones de pago</small>
            </div>
            <?php if (!empty($_GET['success'])): ?>
                <span class="badge bg-success">Cliente creado</span>
            <?php endif; ?>
        </div>
        <table class="table table-striped table-sm">
            <thead class="table-light">
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
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Nuevo cliente</div>
            <div class="card-body">
                <form method="POST" action="/clientes">
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
                        <input type="text" name="payment_terms" class="form-control" placeholder="30 días, contado, etc.">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Límite de crédito</label>
                        <input type="number" name="credit_limit" class="form-control" value="0">
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
