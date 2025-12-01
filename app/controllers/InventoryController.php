<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\InventoryMovement;
use App\Models\Warehouse;

class InventoryController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'bodeguero', 'supervisor']);
        $movements = new InventoryMovement();
        $warehouses = new Warehouse();
        $this->view('inventory/index', [
            'movements' => $movements->recent(),
            'warehouses' => $warehouses->all(),
        ]);
    }
}
