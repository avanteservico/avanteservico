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

        // Dados Mockados para o Gráfico (enquanto não temos query complexa de financeiro)
        $financialData = [
            'receitas' => 0, // Implementar query real
            'despesas' => 0, // Implementar query real
            'status' => 'Neutro'
        ];

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/dashboard.php';
        require_once '../app/Views/templates/footer.php';
    }
}
