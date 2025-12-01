<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Provider;

class ProviderController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'supervisor', 'bodeguero']);
        $provider = new Provider();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($provider);
            return;
        }

        $this->view('providers/index', [
            'providers' => $provider->all(),
            'csrf' => Csrf::token(),
        ]);
    }

    private function store(Provider $provider): void
    {
        $token = $_POST['_token'] ?? '';
        if (!Csrf::validate($token)) {
            $this->redirect('/proveedores?error=csrf');
        }

        $provider->create([
            'name' => trim($_POST['name'] ?? ''),
            'tax_id' => trim($_POST['tax_id'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'payment_terms' => trim($_POST['payment_terms'] ?? ''),
            'notes' => trim($_POST['notes'] ?? ''),
        ]);

        $this->redirect('/proveedores?success=1');
    }
}
