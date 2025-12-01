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

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO providers (name, tax_id, address, phone, email, payment_terms, notes) VALUES (:name, :tax_id, :address, :phone, :email, :payment_terms, :notes)');
        $stmt->execute([
            ':name' => $data['name'],
            ':tax_id' => $data['tax_id'] ?? null,
            ':address' => $data['address'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':email' => $data['email'] ?? null,
            ':payment_terms' => $data['payment_terms'] ?? null,
            ':notes' => $data['notes'] ?? null,
        ]);

        return (int)$this->db->lastInsertId();
    }
}
