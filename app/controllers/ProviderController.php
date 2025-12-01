<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Provider;

class ProviderController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'supervisor', 'bodeguero']);
        $provider = new Provider();
        $this->view('providers/index', [
            'providers' => $provider->all(),
        ]);
    }
}
