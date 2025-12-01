<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Panel de control</h3>
        <p class="text-muted mb-0">Hola, <?php echo Helper::e($user['name']); ?> · Rol: <?php echo Helper::e($user['role_name'] ?? $user['role_slug']); ?></p>
    </div>
    <div class="badge rounded-pill text-bg-light text-primary px-3 py-2">Último acceso seguro</div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Ventas hoy</p>
                        <h5 class="fw-bold mb-0">$<?php echo number_format($stats['today'], 0, ',', '.'); ?></h5>
                    </div>
                    <div class="stat-icon bg-primary text-white">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Ventas mes</p>
                        <h5 class="fw-bold mb-0">$<?php echo number_format($stats['month'], 0, ',', '.'); ?></h5>
                    </div>
                    <div class="stat-icon bg-success text-white">
                        <i class="bi bi-graph-up"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Bajo stock</p>
                        <h5 class="fw-bold mb-0"><?php echo $counters['low_stock_count']; ?></h5>
                    </div>
                    <div class="stat-icon bg-warning text-white">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Clientes</p>
                        <h5 class="fw-bold mb-0"><?php echo $counters['customers']; ?></h5>
                    </div>
                    <div class="stat-icon bg-info text-white">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Cuentas por cobrar</p>
                        <h5 class="fw-bold mb-0"><?php echo $counters['receivables']; ?></h5>
                    </div>
                    <div class="stat-icon bg-secondary text-white">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Cajas abiertas</p>
                        <h5 class="fw-bold mb-0"><?php echo $counters['open_cash']; ?></h5>
                    </div>
                    <div class="stat-icon bg-dark text-white">
                        <i class="bi bi-safe"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-bold">Ventas últimos 7 días</h6>
                    <small class="text-muted">Tendencia diaria</small>
                </div>
                <span class="badge bg-light text-primary">Chart</span>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="110"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0 fw-bold">Alertas rápidas</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small text-uppercase">Productos con bajo stock</p>
                <ul class="list-group list-group-flush mb-3">
                    <?php foreach ($alerts['lowStock'] as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><?php echo Helper::e($item['name']); ?></span>
                            <span class="badge rounded-pill text-bg-warning"><?php echo $item['total_stock']; ?>/<?php echo $item['stock_min']; ?></span>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($alerts['lowStock'])): ?>
                        <li class="list-group-item px-0 text-muted">Sin alertas de stock.</li>
                    <?php endif; ?>
                </ul>
                <p class="text-muted small text-uppercase">Cuentas por cobrar vencidas</p>
                <ul class="list-group list-group-flush">
                    <?php foreach ($alerts['receivables'] as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <div class="fw-semibold"><?php echo Helper::e($item['name']); ?></div>
                                <small class="text-muted">Venc.: <?php echo $item['due_date']; ?></small>
                            </div>
                            <span class="badge rounded-pill text-bg-danger">$<?php echo number_format($item['balance'], 0, ',', '.'); ?></span>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($alerts['receivables'])): ?>
                        <li class="list-group-item px-0 text-muted">Sin cuentas vencidas.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-3">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-bold">Últimas ventas</h6>
                    <small class="text-muted">Movimientos recientes</small>
                </div>
                <a href="/ventas" class="btn btn-sm btn-outline-primary">Ver todo</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Bodega</th>
                        <th>Tipo</th>
                        <th class="text-end">Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($inventoryMovements as $move): ?>
                        <tr>
                            <td><?php echo $move['movement_date']; ?></td>
                            <td><?php echo Helper::e($move['product']); ?></td>
                            <td><?php echo Helper::e($move['warehouse']); ?></td>
                            <td><span class="badge bg-light text-dark"><?php echo Helper::e($move['type']); ?></span></td>
                            <td class="text-end"><?php echo $move['quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($inventoryMovements)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Sin movimientos recientes.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-bold">Top productos</h6>
                    <small class="text-muted">Más vendidos</small>
                </div>
                <i class="bi bi-trophy text-warning"></i>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($topProducts as $product): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><?php echo Helper::e($product['name']); ?></span>
                            <span class="badge rounded-pill text-bg-primary"><?php echo $product['qty']; ?></span>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($topProducts)): ?>
                        <li class="list-group-item px-0 text-muted">Sin ventas registradas.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    const trendLabels = <?php echo json_encode(array_map(fn($row) => date('d M', strtotime($row['date'])), $salesTrend)); ?>;
    const trendValues = <?php echo json_encode(array_map(fn($row) => (float)$row['total'], $salesTrend)); ?>;

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Ventas',
                data: trendValues,
                backgroundColor: '#0d6efd',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
