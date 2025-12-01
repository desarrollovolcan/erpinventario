<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Warehouse;

class SalesController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'vendedor', 'supervisor']);
        $sale = new Sale();
        $this->view('sales/index', [
            'sales' => $sale->all(),
        ]);
    }

    public function pos(): void
    {
        Auth::requireRole(['admin', 'vendedor']);
        $productModel = new Product();
        $customerModel = new Customer();
        $warehouseModel = new Warehouse();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSaleSubmission($productModel, $warehouseModel, $customerModel);
            return;
        }

        $this->view('sales/pos', [
            'csrf' => Csrf::token(),
            'products' => $productModel->all(),
            'customers' => $customerModel->all(),
            'warehouses' => $warehouseModel->all(),
        ]);
    }

    public function quotes(): void
    {
        Auth::requireRole(['admin', 'vendedor', 'supervisor']);
        $this->view('sales/quotes');
    }

    private function handleSaleSubmission(Product $productModel, Warehouse $warehouseModel, Customer $customerModel): void
    {
        $token = $_POST['_token'] ?? '';
        if (!Csrf::validate($token)) {
            $this->view('sales/pos', [
                'csrf' => Csrf::token(),
                'products' => $productModel->all(),
                'customers' => $customerModel->all(),
                'warehouses' => $warehouseModel->all(),
                'error' => 'Token inválido. Intenta nuevamente.',
            ]);
            return;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (float)($_POST['quantity'] ?? 0);
        $paymentMethod = trim($_POST['payment_method'] ?? 'efectivo');
        $warehouseId = (int)($_POST['warehouse_id'] ?? 0);
        $customerId = (int)($_POST['customer_id'] ?? 0);

        $product = $productModel->find($productId);
        $warehouse = $warehouseModel->find($warehouseId);

        if (!$product || !$warehouse || $quantity <= 0) {
            $this->view('sales/pos', [
                'csrf' => Csrf::token(),
                'products' => $productModel->all(),
                'customers' => $customerModel->all(),
                'warehouses' => $warehouseModel->all(),
                'error' => 'Completa la información de la venta.',
            ]);
            return;
        }

        $taxRate = (float)($product['tax_included'] ? 0.19 : 0);
        $price = (float)$product['sale_price'];
        $tax = $price * $quantity * $taxRate;
        $total = ($price * $quantity) + $tax;

        $sale = new Sale();
        $saleId = $sale->create([
            'customer_id' => $customerId ?: null,
            'user_id' => Auth::user()['id'],
            'warehouse_id' => $warehouseId,
            'document_type' => 'boleta',
            'document_number' => null,
            'total' => $total,
            'tax' => $tax,
            'payment_method' => $paymentMethod,
            'status' => $paymentMethod === 'crédito' ? 'pendiente' : 'pagada',
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price,
            'discount' => 0,
            'cost_price' => (float)$product['cost_price'],
            'due_date' => $_POST['due_date'] ?? null,
        ]);

        $this->redirect('/ventas?success=' . $saleId);
    }
}
