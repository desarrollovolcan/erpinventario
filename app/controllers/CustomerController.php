<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'vendedor', 'supervisor']);
        $customer = new Customer();
        $this->view('customers/index', [
            'customers' => $customer->all(),
        ]);
    }
}
