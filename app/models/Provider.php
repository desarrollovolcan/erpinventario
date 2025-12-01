<?php
namespace App\Models;

use App\Core\Model;

class Provider extends Model
{
    public function all(): array
    {
        $stmt = $this->query('SELECT * FROM providers ORDER BY name');
        return $stmt->fetchAll();
    }
}
