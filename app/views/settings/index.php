<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Parámetros del sistema</h5>
            <small class="text-muted">Datos generales de la empresa</small>
        </div>
        <span class="badge bg-primary">Solo administrador</span>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" value="<?php echo App\Core\Helper::e($company['name']); ?>" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">RUT</label>
                <input type="text" class="form-control" value="<?php echo App\Core\Helper::e($company['tax_id']); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="<?php echo App\Core\Helper::e($company['email']); ?>" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" value="<?php echo App\Core\Helper::e($company['phone']); ?>" readonly>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <textarea class="form-control" rows="2" readonly><?php echo App\Core\Helper::e($company['address']); ?></textarea>
        </div>
        <p class="text-muted small mb-0">Estos valores pueden externalizarse a la configuración en /config/config.php.</p>
    </div>
</div>
