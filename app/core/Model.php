<?php
namespace App\Core;

use PDO;
use PDOException;

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    protected function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt->execute($params)) {
            throw new PDOException('Error ejecutando consulta');
        }
        return $stmt;
    }
}
