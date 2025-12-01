<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'bodeguero', 'supervisor']);
        $warehouses = new Warehouse();
        $this->view('warehouses/index', [
            'warehouses' => $warehouses->all(),
        ]);
    }
}
