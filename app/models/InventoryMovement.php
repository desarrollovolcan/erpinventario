<?php
namespace App\Models;

use App\Core\Model;

class InventoryMovement extends Model
{
    public function recent(): array
    {
        $stmt = $this->query('SELECT im.*, p.name as product, w.name as warehouse FROM inventory_movements im JOIN products p ON p.id = im.product_id JOIN warehouses w ON w.id = im.warehouse_id ORDER BY im.movement_date DESC LIMIT 20');
        return $stmt->fetchAll();
    }
}
