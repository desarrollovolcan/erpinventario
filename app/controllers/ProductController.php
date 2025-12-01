<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Product;
use App\Models\Provider;

class ProductController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'vendedor', 'bodeguero', 'supervisor']);
        $model = new Product();
        $providers = new Provider();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($model);
            return;
        }

        $this->view('products/index', [
            'products' => $model->all(),
            'providers' => $providers->all(),
            'csrf' => Csrf::token(),
        ]);
    }

    private function store(Product $model): void
    {
        $token = $_POST['_token'] ?? '';
        if (!Csrf::validate($token)) {
            $this->redirect('/inventario/productos?error=csrf');
        }

        $model->create([
            'sku' => trim($_POST['sku'] ?? ''),
            'barcode' => trim($_POST['barcode'] ?? ''),
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'unit' => $_POST['unit'] ?? 'unidad',
            'type' => $_POST['type'] ?? 'normal',
            'tax_included' => isset($_POST['tax_included']) ? 1 : 0,
            'cost_price' => (float)($_POST['cost_price'] ?? 0),
            'sale_price' => (float)($_POST['sale_price'] ?? 0),
            'discount_max' => (float)($_POST['discount_max'] ?? 0),
            'stock_min' => (int)($_POST['stock_min'] ?? 0),
            'provider_id' => (int)($_POST['provider_id'] ?? 0) ?: null,
            'status' => 1,
        ]);

        $this->redirect('/inventario/productos?success=1');
    }
}
