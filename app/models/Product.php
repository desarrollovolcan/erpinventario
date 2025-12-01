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

    public function find(int $id): ?array
    {
        $stmt = $this->query('SELECT * FROM products WHERE id = :id LIMIT 1', [':id' => $id]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO products (sku, barcode, name, description, category_id, unit, type, tax_included, cost_price, sale_price, discount_max, stock_min, provider_id, status) VALUES (:sku, :barcode, :name, :description, :category_id, :unit, :type, :tax_included, :cost_price, :sale_price, :discount_max, :stock_min, :provider_id, :status)');
        $stmt->execute([
            ':sku' => $data['sku'],
            ':barcode' => $data['barcode'] ?? null,
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':unit' => $data['unit'] ?? 'unidad',
            ':type' => $data['type'] ?? 'normal',
            ':tax_included' => $data['tax_included'] ?? 1,
            ':cost_price' => $data['cost_price'],
            ':sale_price' => $data['sale_price'],
            ':discount_max' => $data['discount_max'] ?? 0,
            ':stock_min' => $data['stock_min'] ?? 0,
            ':provider_id' => $data['provider_id'] ?? null,
            ':status' => $data['status'] ?? 1,
        ]);

        return (int)$this->db->lastInsertId();
    }
}
