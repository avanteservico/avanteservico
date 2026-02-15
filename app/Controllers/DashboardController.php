<?php



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


        $revenueModel = new Revenue();
        $materialModel = new Material();

        $revenueSummary = $revenueModel->getGlobalSummary();
        $expenseSummary = $materialModel->getGlobalSummary();

        $financialData = [
            'receitas' => ($revenueSummary['total_received'] ?? 0) + ($revenueSummary['total_to_receive'] ?? 0),
            'despesas' => ($expenseSummary['total_paid'] ?? 0) + ($expenseSummary['total_pending'] ?? 0),
            'status' => 'Calculado'
        ];

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/dashboard.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }
}
