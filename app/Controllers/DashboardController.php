<?php

require_once '../app/Models/Work.php';
require_once '../app/Helpers/AuthHelper.php';

class DashboardController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        $workModel = new Work();
        $works = $workModel->getAll();
        $summary = $workModel->getSummary();

        // Calcular dados financeiros reais
        require_once '../app/Models/Revenue.php';
        require_once '../app/Models/Material.php';

        $revenueModel = new Revenue();
        $materialModel = new Material();

        $revenueSummary = $revenueModel->getGlobalSummary();
        $expenseSummary = $materialModel->getGlobalSummary();

        $financialData = [
            'receitas' => ($revenueSummary['total_received'] ?? 0) + ($revenueSummary['total_to_receive'] ?? 0),
            'despesas' => ($expenseSummary['total_paid'] ?? 0) + ($expenseSummary['total_pending'] ?? 0),
            'status' => 'Calculado'
        ];

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/dashboard.php';
        require_once '../app/Views/templates/footer.php';
    }
}
