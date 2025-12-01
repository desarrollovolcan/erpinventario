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

    public function find(int $id): ?array
    {
        $stmt = $this->query('SELECT * FROM warehouses WHERE id = :id LIMIT 1', [':id' => $id]);
        $warehouse = $stmt->fetch();
        return $warehouse ?: null;
    }
}
