<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'vendedor', 'bodeguero', 'supervisor']);
        $model = new Product();
        $this->view('products/index', [
            'products' => $model->all(),
        ]);
    }
}
