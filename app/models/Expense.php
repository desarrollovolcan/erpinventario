<?php
namespace App\Models;

use App\Core\Model;

class Expense extends Model
{
    public function latest(): array
    {
        $stmt = $this->query('SELECT e.*, w.name as warehouse, u.name as user FROM expenses e JOIN warehouses w ON w.id = e.warehouse_id JOIN users u ON u.id = e.user_id ORDER BY e.expense_date DESC LIMIT 20');
        return $stmt->fetchAll();
    }
}
