<?php
namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    public function all(): array
    {
        $stmt = $this->query('SELECT p.*, c.name as category, pr.name as provider FROM products p LEFT JOIN categories c ON c.id = p.category_id LEFT JOIN providers pr ON pr.id = p.provider_id ORDER BY p.name');
        return $stmt->fetchAll();
    }
}
