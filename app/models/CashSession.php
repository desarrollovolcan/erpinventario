<?php
namespace App\Models;

use App\Core\Model;

class CashSession extends Model
{
    public function openSessions(): array
    {
        $stmt = $this->query("SELECT cs.*, w.name as warehouse, u.name as user FROM cash_sessions cs JOIN warehouses w ON w.id = cs.warehouse_id JOIN users u ON u.id = cs.user_id ORDER BY cs.opened_at DESC");
        return $stmt->fetchAll();
    }
}
