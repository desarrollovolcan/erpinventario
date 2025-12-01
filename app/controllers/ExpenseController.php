<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'supervisor']);
        $expense = new Expense();
        $this->view('expenses/index', [
            'expenses' => $expense->latest(),
        ]);
    }
}
