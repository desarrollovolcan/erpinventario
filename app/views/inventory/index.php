<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Inventario</h3>
    <button class="btn btn-sm btn-success">Registrar movimiento</button>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Bodega</label>
        <select class="form-select">
            <?php foreach ($warehouses as $warehouse): ?>
                <option><?php echo App\Core\Helper::e($warehouse['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Producto</th>
        <th>Bodega</th>
        <th>Tipo</th>
        <th>Cantidad</th>
        <th>Comentario</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($movements as $move): ?>
        <tr>
            <td><?php echo $move['movement_date']; ?></td>
            <td><?php echo App\Core\Helper::e($move['product']); ?></td>
            <td><?php echo App\Core\Helper::e($move['warehouse']); ?></td>
            <td><?php echo App\Core\Helper::e($move['type']); ?></td>
            <td><?php echo $move['quantity']; ?></td>
            <td><?php echo App\Core\Helper::e($move['comments']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
