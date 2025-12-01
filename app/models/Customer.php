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

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO customers (name, tax_id, business, address, phone, email, payment_terms, credit_limit, notes) VALUES (:name, :tax_id, :business, :address, :phone, :email, :payment_terms, :credit_limit, :notes)');
        $stmt->execute([
            ':name' => $data['name'],
            ':tax_id' => $data['tax_id'] ?? null,
            ':business' => $data['business'] ?? null,
            ':address' => $data['address'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':email' => $data['email'] ?? null,
            ':payment_terms' => $data['payment_terms'] ?? null,
            ':credit_limit' => $data['credit_limit'] ?? 0,
            ':notes' => $data['notes'] ?? null,
        ]);

        return (int)$this->db->lastInsertId();
    }
}
