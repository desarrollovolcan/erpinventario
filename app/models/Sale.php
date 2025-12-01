<?php
namespace App\Models;

use App\Core\Model;
use PDOException;

class Sale extends Model
{
    public function all(): array
    {
        $stmt = $this->query('SELECT s.*, c.name as customer, w.name as warehouse, u.name as user FROM sales s LEFT JOIN customers c ON c.id = s.customer_id JOIN warehouses w ON w.id = s.warehouse_id JOIN users u ON u.id = s.user_id ORDER BY s.created_at DESC LIMIT 30');
        return $stmt->fetchAll();
    }

    public function create(array $payload): int
    {
        $this->db->beginTransaction();
        try {
            $saleStmt = $this->db->prepare('INSERT INTO sales (customer_id, user_id, warehouse_id, document_type, document_number, total, tax, payment_method, status) VALUES (:customer_id, :user_id, :warehouse_id, :document_type, :document_number, :total, :tax, :payment_method, :status)');
            $saleStmt->execute([
                ':customer_id' => $payload['customer_id'] ?: null,
                ':user_id' => $payload['user_id'],
                ':warehouse_id' => $payload['warehouse_id'],
                ':document_type' => $payload['document_type'] ?? 'boleta',
                ':document_number' => $payload['document_number'] ?? null,
                ':total' => $payload['total'],
                ':tax' => $payload['tax'],
                ':payment_method' => $payload['payment_method'],
                ':status' => $payload['status'] ?? 'pagada',
            ]);

            $saleId = (int)$this->db->lastInsertId();

            $detailStmt = $this->db->prepare('INSERT INTO sale_details (sale_id, product_id, quantity, price, discount, tax) VALUES (:sale_id, :product_id, :quantity, :price, :discount, :tax)');
            $detailStmt->execute([
                ':sale_id' => $saleId,
                ':product_id' => $payload['product_id'],
                ':quantity' => $payload['quantity'],
                ':price' => $payload['price'],
                ':discount' => $payload['discount'] ?? 0,
                ':tax' => $payload['tax'],
            ]);

            $stockStmt = $this->db->prepare('INSERT INTO warehouses_products (warehouse_id, product_id, stock) VALUES (:warehouse_id, :product_id, 0 - :qty) ON DUPLICATE KEY UPDATE stock = stock - :qty');
            $stockStmt->execute([
                ':warehouse_id' => $payload['warehouse_id'],
                ':product_id' => $payload['product_id'],
                ':qty' => $payload['quantity'],
            ]);

            $movementStmt = $this->db->prepare('INSERT INTO inventory_movements (product_id, warehouse_id, user_id, type, quantity, unit_cost, comments) VALUES (:product_id, :warehouse_id, :user_id, :type, :quantity, :unit_cost, :comments)');
            $movementStmt->execute([
                ':product_id' => $payload['product_id'],
                ':warehouse_id' => $payload['warehouse_id'],
                ':user_id' => $payload['user_id'],
                ':type' => 'salida venta',
                ':quantity' => $payload['quantity'],
                ':unit_cost' => $payload['cost_price'],
                ':comments' => 'Venta rápida',
            ]);

            if ($payload['payment_method'] === 'crédito') {
                $receivable = $this->db->prepare('INSERT INTO accounts_receivable (customer_id, sale_id, amount, balance, due_date) VALUES (:customer_id, :sale_id, :amount, :balance, :due_date)');
                $receivable->execute([
                    ':customer_id' => $payload['customer_id'] ?: null,
                    ':sale_id' => $saleId,
                    ':amount' => $payload['total'],
                    ':balance' => $payload['total'],
                    ':due_date' => $payload['due_date'] ?? date('Y-m-d', strtotime('+30 days')),
                ]);
            }

            $this->db->commit();
            return $saleId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
