<?php
namespace App\Models;

use App\Core\Model;

class Purchase extends Model
{
    public function recent(): array
    {
        $stmt = $this->query('SELECT pr.name as provider, p.document_number, p.total, p.status, p.issue_date FROM purchases p JOIN providers pr ON pr.id = p.provider_id ORDER BY p.issue_date DESC LIMIT 20');
        return $stmt->fetchAll();
    }
}
