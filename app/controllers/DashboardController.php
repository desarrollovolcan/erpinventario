<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Dashboard;

class DashboardController extends Controller
{
    public function index(): void
    {
        if (!Auth::check()) {
            $this->redirect('/login');
            return;
        }
        $dashboard = new Dashboard();
        $user = Auth::user();

        $this->view('dashboard/index', [
            'user' => $user,
            'stats' => $dashboard->getSalesSummary(),
            'topProducts' => $dashboard->getTopProducts(),
            'alerts' => $dashboard->getAlerts(),
            'inventoryMovements' => $dashboard->getRecentMovements(),
        ]);
    }
}
