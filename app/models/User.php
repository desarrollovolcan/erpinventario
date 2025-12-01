<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function findByEmailOrUsername(string $identifier): ?array
    {
        $stmt = $this->query('SELECT u.*, r.slug AS role_slug, r.name AS role_name FROM users u JOIN roles r ON r.id = u.role_id WHERE u.email = :identifier OR u.name = :identifier LIMIT 1', [
            ':identifier' => $identifier,
        ]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findActiveById(int $id): ?array
    {
        $stmt = $this->query('SELECT u.*, r.slug AS role_slug, r.name AS role_name FROM users u JOIN roles r ON r.id = u.role_id WHERE u.id = :id AND u.status = 1 LIMIT 1', [
            ':id' => $id,
        ]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function all(): array
    {
        $stmt = $this->query('SELECT u.id, u.name, u.email, r.name AS role FROM users u JOIN roles r ON r.id = u.role_id ORDER BY u.name');
        return $stmt->fetchAll();
    }
}
