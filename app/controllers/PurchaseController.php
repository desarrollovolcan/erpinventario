<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'bodeguero', 'supervisor']);
        $purchase = new Purchase();
        $this->view('purchases/index', [
            'purchases' => $purchase->recent(),
        ]);
    }
}
