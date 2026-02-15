<?php







class FinancialController
{
    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        if (!AuthHelper::hasPermission('financial', 'list')) {
            die('Acesso negado. Você não tem permissão para acessar o painel financeiro.');
        }
        $work_id = $_GET['work_id'] ?? null;
        if (!$work_id) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        $workModel = new Work();
        $work = $workModel->findById($work_id);
        if (!$work) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        $revenueModel = new Revenue();
        $materialModel = new Material();
        $paymentModel = new PersonPayment();

        $revenueSummary = $revenueModel->getSummaryByWorkId($work_id);
        $materialSummary = $materialModel->getSummaryByWorkId($work_id);
        $paymentSummary = $paymentModel->getSummaryByWorkId($work_id);

        // Calcular totais gerais
        $totalIncomes = ($revenueSummary['total_received'] ?? 0) + ($revenueSummary['total_to_receive'] ?? 0);
        $totalExpenses = ($materialSummary['total_paid'] ?? 0) + ($materialSummary['total_pending'] ?? 0) +
            ($paymentSummary['total_paid'] ?? 0) + ($paymentSummary['total_pending'] ?? 0);

        $balance = $totalIncomes - $totalExpenses;

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/financial/index.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function revenues()
    {
        if (!AuthHelper::hasPermission('revenues', 'list')) {
            die('Acesso negado. Você não tem permissão para listar receitas.');
        }

        $revenueModel = new Revenue();
        $revenues = $revenueModel->getAll();
        $summary = $revenueModel->getGlobalSummary();

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/financial/revenues.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function expenses()
    {
        if (!AuthHelper::hasPermission('materials', 'list')) {
            die('Acesso negado. Você não tem permissão para listar despesas.');
        }

        $materialModel = new Material();
        $expenses = $materialModel->getAll();
        $summary = $materialModel->getGlobalSummary();

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/financial/expenses.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }
}
