<?php
namespace App\Models;

use App\Core\Model;

class Dashboard extends Model
{
    public function getSalesSummary(): array
    {
        return [
            'today' => (float)($this->query("SELECT IFNULL(SUM(total),0) as total FROM sales WHERE DATE(created_at) = CURDATE()")->fetch()['total'] ?? 0),
            'week' => (float)($this->query("SELECT IFNULL(SUM(total),0) as total FROM sales WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)")->fetch()['total'] ?? 0),
            'month' => (float)($this->query("SELECT IFNULL(SUM(total),0) as total FROM sales WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())")->fetch()['total'] ?? 0),
        ];
    }

    public function getTopProducts(): array
    {
        $stmt = $this->query('SELECT p.name, SUM(sd.quantity) as qty FROM sale_details sd JOIN products p ON p.id = sd.product_id GROUP BY p.id ORDER BY qty DESC LIMIT 5');
        return $stmt->fetchAll();
    }

    public function getAlerts(): array
    {
        $lowStock = $this->query('SELECT name, stock_min, total_stock FROM product_stock_view WHERE total_stock < stock_min LIMIT 10')->fetchAll();
        $receivables = $this->query('SELECT c.name, ar.balance, ar.due_date FROM accounts_receivable ar JOIN customers c ON c.id = ar.customer_id WHERE ar.due_date < CURDATE() AND ar.balance > 0 ORDER BY ar.due_date ASC LIMIT 10')->fetchAll();
        return ['lowStock' => $lowStock, 'receivables' => $receivables];
    }

    public function getRecentMovements(): array
    {
        $stmt = $this->query('SELECT im.*, p.name as product, w.name as warehouse FROM inventory_movements im JOIN products p ON p.id = im.product_id JOIN warehouses w ON w.id = im.warehouse_id ORDER BY im.movement_date DESC LIMIT 10');
        return $stmt->fetchAll();
    }
}
