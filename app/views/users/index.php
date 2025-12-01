<div class="row mb-4">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">Usuarios</h3>
                <small class="text-muted">Gestiona acceso y roles</small>
            </div>
            <?php if (!empty($_GET['success'])): ?>
                <span class="badge bg-success">Usuario creado</span>
            <?php endif; ?>
            <?php if (!empty($_GET['error'])): ?>
                <span class="badge bg-danger">Ocurrió un error</span>
            <?php endif; ?>
        </div>
        <table class="table table-hover table-sm">
            <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo App\Core\Helper::e($user['name']); ?></td>
                    <td><?php echo App\Core\Helper::e($user['email']); ?></td>
                    <td><?php echo App\Core\Helper::e($user['role']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Crear usuario</div>
            <div class="card-body">
                <form method="POST" action="/usuarios">
                    <input type="hidden" name="_token" value="<?php echo $csrf; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="role_id" class="form-select" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id']; ?>"><?php echo App\Core\Helper::e($role['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
