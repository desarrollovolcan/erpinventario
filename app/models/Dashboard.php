<?php
namespace App\Models;

use App\Core\Model;

class Dashboard extends Model
{
    public function getSalesSummary(): array
    {
        return [
            'today' => (float)($this->query("SELECT IFNULL(SUM(total),0) as total FROM sales WHERE DATE(created_at) = CURDATE()")->fetch()['total'] ?? 0),
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
        $lowStock = $this->query('SELECT name, stock_min, total_stock FROM product_stock_view WHERE total_stock < stock_min LIMIT 5')->fetchAll();
        $receivables = $this->query('SELECT c.name, ar.balance, ar.due_date FROM accounts_receivable ar JOIN customers c ON c.id = ar.customer_id WHERE ar.due_date < CURDATE() AND ar.balance > 0 ORDER BY ar.due_date ASC LIMIT 5')->fetchAll();
        return ['lowStock' => $lowStock, 'receivables' => $receivables];
    }

    public function getRecentMovements(): array
    {
        $stmt = $this->query('SELECT im.*, p.name as product, w.name as warehouse FROM inventory_movements im JOIN products p ON p.id = im.product_id JOIN warehouses w ON w.id = im.warehouse_id ORDER BY im.movement_date DESC LIMIT 10');
        return $stmt->fetchAll();
    }

    public function getCounters(): array
    {
        return [
            'low_stock_count' => (int)($this->query('SELECT COUNT(*) as total FROM product_stock_view WHERE total_stock < stock_min')->fetch()['total'] ?? 0),
            'customers' => (int)($this->query('SELECT COUNT(*) as total FROM customers')->fetch()['total'] ?? 0),
            'receivables' => (int)($this->query('SELECT COUNT(*) as total FROM accounts_receivable WHERE balance > 0')->fetch()['total'] ?? 0),
            'open_cash' => (int)($this->query("SELECT COUNT(*) as total FROM cash_sessions WHERE status = 'open'")->fetch()['total'] ?? 0),
        ];
    }

    public function getSalesByDay(int $days = 7): array
    {
        $stmt = $this->query('SELECT DATE(created_at) as date, SUM(total) as total FROM sales WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL :days DAY) GROUP BY DATE(created_at) ORDER BY DATE(created_at)', [
            ':days' => $days - 1,
        ]);

        $data = $stmt->fetchAll();
        $series = [];
        $start = new \DateTime('-' . ($days - 1) . ' days');
        for ($i = 0; $i < $days; $i++) {
            $dateKey = $start->format('Y-m-d');
            $match = array_filter($data, fn($row) => $row['date'] === $dateKey);
            $total = $match ? (float)array_values($match)[0]['total'] : 0;
            $series[] = ['date' => $dateKey, 'total' => $total];
            $start->modify('+1 day');
        }

        return $series;
    }
}
