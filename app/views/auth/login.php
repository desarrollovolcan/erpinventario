<div class="auth-wrapper container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="card auth-card shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="brand-logo-lg mb-2">ERP Ferretería</div>
                        <h5 class="fw-bold text-primary">Iniciar sesión</h5>
                        <p class="text-muted small">Accede al panel de control</p>
                    </div>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="/login" class="needs-validation" novalidate>
                        <input type="hidden" name="_token" value="<?php echo $csrf; ?>">
                        <div class="mb-3">
                            <label class="form-label">Email o usuario</label>
                            <input type="text" name="email" class="form-control <?php echo !empty($error) ? 'is-invalid' : ''; ?>" value="<?php echo $email ?? ''; ?>" placeholder="tu@correo.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control <?php echo !empty($error) ? 'is-invalid' : ''; ?>" placeholder="••••••••" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Recordarme</label>
                            </div>
                            <a href="#" class="small text-decoration-none">¿Olvidaste tu contraseña?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
