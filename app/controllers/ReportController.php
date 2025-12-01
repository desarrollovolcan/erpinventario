<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'supervisor']);
        $report = new Report();
        $this->view('reports/index', [
            'salesByDay' => $report->salesByDay(),
            'inventoryValue' => $report->inventoryValue(),
            'accountsReceivable' => $report->accountsReceivable(),
        ]);
    }
}
