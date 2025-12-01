<?php
namespace App\Models;

use App\Core\Model;

class Customer extends Model
{
    public function all(): array
    {
        $stmt = $this->query('SELECT * FROM customers ORDER BY name');
        return $stmt->fetchAll();
    }
}
