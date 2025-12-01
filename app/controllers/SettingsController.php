<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

class SettingsController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin']);
        $this->view('settings/index', [
            'company' => [
                'name' => 'ERP Inventario Demo',
                'tax_id' => '76.123.456-7',
                'address' => 'Av. Principal 123, Santiago',
                'email' => 'contacto@erp.test',
                'phone' => '+56 9 5555 5555',
            ],
        ]);
    }
}
