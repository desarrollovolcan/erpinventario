<?php
namespace App\Models;

use App\Core\Model;

class Warehouse extends Model
{
    public function all(): array
    {
        $stmt = $this->query('SELECT * FROM warehouses ORDER BY name');
        return $stmt->fetchAll();
    }
}
