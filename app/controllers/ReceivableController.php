<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Report;

class ReceivableController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'supervisor']);
        $report = new Report();
        $this->view('receivables/index', [
            'accounts' => $report->accountsReceivable(),
        ]);
    }
}
