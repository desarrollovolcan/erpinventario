<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'vendedor', 'supervisor']);
        $customer = new Customer();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($customer);
            return;
        }

        $this->view('customers/index', [
            'customers' => $customer->all(),
            'csrf' => Csrf::token(),
        ]);
    }

    private function store(Customer $customer): void
    {
        $token = $_POST['_token'] ?? '';
        if (!Csrf::validate($token)) {
            $this->redirect('/clientes?error=csrf');
        }

        $customer->create([
            'name' => trim($_POST['name'] ?? ''),
            'tax_id' => trim($_POST['tax_id'] ?? ''),
            'business' => trim($_POST['business'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'payment_terms' => trim($_POST['payment_terms'] ?? ''),
            'credit_limit' => (float)($_POST['credit_limit'] ?? 0),
            'notes' => trim($_POST['notes'] ?? ''),
        ]);

        $this->redirect('/clientes?success=1');
    }
}
