<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\CashSession;

class ClosingController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin', 'supervisor']);
        $sessions = new CashSession();
        $this->view('closings/index', [
            'sessions' => $sessions->openSessions(),
        ]);
    }
}
