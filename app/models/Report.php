<?php
namespace App\Models;

use App\Core\Model;

class Report extends Model
{
    public function salesByDay(): array
    {
        $stmt = $this->query('SELECT DATE(created_at) as day, SUM(total) as total FROM sales GROUP BY DATE(created_at) ORDER BY day DESC LIMIT 30');
        return $stmt->fetchAll();
    }

    public function inventoryValue(): float
    {
        $stmt = $this->query('SELECT SUM(cost_price * stock) as total_value FROM product_stock_view');
        $row = $stmt->fetch();
        return (float)($row['total_value'] ?? 0);
    }

    public function accountsReceivable(): array
    {
        $stmt = $this->query('SELECT c.name, ar.balance, ar.due_date FROM accounts_receivable ar JOIN customers c ON c.id = ar.customer_id WHERE ar.balance > 0 ORDER BY ar.due_date');
        return $stmt->fetchAll();
    }
}
