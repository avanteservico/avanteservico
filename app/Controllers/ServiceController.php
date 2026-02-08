<?php

require_once '../app/Models/Service.php';
require_once '../app/Models/SubService.php';
require_once '../app/Models/Work.php';
require_once '../app/Models/Revenue.php';
require_once '../app/Helpers/AuthHelper.php';

class ServiceController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        if (!AuthHelper::hasPermission('services', 'list')) {
            die('Acesso negado. Você não tem permissão para listar serviços.');
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

        $serviceModel = new Service();
        $subServiceModel = new SubService();

        $services = $serviceModel->getAllByWorkId($work_id);

        $totals = [
            'value' => 0,
            'percentage_work' => 0,
            'valor_devido' => 0,
            'paid_value' => 0,
            'valor_a_receber' => 0
        ];

        // Carregar sub-serviços para cada serviço
        foreach ($services as &$service) {
            $service['sub_services'] = $subServiceModel->getAllByServiceId($service['id']);

            // Se houver sub-serviços, o percentual executado é a soma ponderada
            if (!empty($service['sub_services'])) {
                $calculatedProgress = 0;
                foreach ($service['sub_services'] as $sub) {
                    $calculatedProgress += ($sub['executed_percentage'] * $sub['percentage_service']) / 100;
                }
                $service['executed_percentage'] = $calculatedProgress;

                // Garantir que o status acompanhe o cálculo
                $service['status'] = ($service['executed_percentage'] >= 100) ? 'finalizado' : 'pendente';
            }

            // Cálculos extras de totais para exibição
            $service['valor_devido'] = $service['value'] * ($service['executed_percentage'] / 100);
            $service['valor_a_receber'] = $service['valor_devido'] - $service['paid_value'];

            // Somar totais (apenas serviços macro)
            $totals['value'] += $service['value'];
            $totals['percentage_work'] += $service['percentage_work'];
            $totals['valor_devido'] += $service['valor_devido'];
            $totals['paid_value'] += $service['paid_value'];
            $totals['valor_a_receber'] += $service['valor_a_receber'];
        }
        unset($service);

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/services/index.php';
        require_once '../app/Views/templates/footer.php';
    }

    private function parseCurrency($value)
    {
        // Remove tudo que não é dígito ou vírgula/ponto
        $value = preg_replace('/[^0-9,.]/', '', $value);
        // Substitui vírgula por ponto (formato americano)
        $value = str_replace('.', '', $value); // Remove ponto de milhar
        $value = str_replace(',', '.', $value); // Troca vírgula decimal por ponto
        return (float) $value;
    }

    public function create()
    {
        if (!AuthHelper::hasPermission('services', 'create')) {
            die('Acesso negado. Você não tem permissão para criar serviços.');
        }
        $work_id = $_POST['work_id'] ?? $_GET['work_id'] ?? null;

        if (!$work_id) {
            die('Obra não especificada.');
        }

        $workModel = new Work();
        $work = $workModel->findById($work_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceModel = new Service();

            $percentage_work = $this->parseCurrency($_POST['percentage_work']);
            // Calcular valor automaticamente: (Valor da Obra * Percentual) / 100
            $value = ($work['total_value'] * $percentage_work) / 100;

            $data = [
                'work_id' => $work_id,
                'name' => $_POST['name'],
                'percentage_work' => $percentage_work,
                'value' => $value,
                'executed_percentage' => $this->parseCurrency($_POST['executed_percentage'] ?? 0),
                'paid_value' => $this->parseCurrency($_POST['paid_value'] ?? 0)
            ];

            if ($id = $serviceModel->create($data)) {
                $service = $serviceModel->findById($id);
                $revenueModel = new Revenue();
                $revenueModel->syncFromService($service);

                header('Location: ' . BASE_URL . '/services?work_id=' . $work_id);
                exit;
            } else {
                $error = "Erro ao criar serviço.";
            }
        }

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/services/create.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function edit($id)
    {
        if (!AuthHelper::hasPermission('services', 'update')) {
            die('Acesso negado. Você não tem permissão para editar serviços.');
        }
        $serviceModel = new Service();
        $service = $serviceModel->findById($id);

        if (!$service) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        $workModel = new Work();
        $work = $workModel->findById($service['work_id']);

        $subServiceModel = new SubService();
        $subServices = $subServiceModel->getAllByServiceId($id);

        // Calcular valor devido para exibição inicial
        $service['valor_devido'] = $service['value'] * ($service['executed_percentage'] / 100);

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/services/edit.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function update()
    {
        if (!AuthHelper::hasPermission('services', 'update')) {
            die('Acesso negado. Você não tem permissão para atualizar serviços.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceModel = new Service();
            $id = $_POST['id'];
            $work_id = $_POST['work_id'];

            $workModel = new Work();
            $work = $workModel->findById($work_id);

            $percentage_work = $this->parseCurrency($_POST['percentage_work']);
            // Recalcular valor se o percentual mudou
            $value = ($work['total_value'] * $percentage_work) / 100;

            $executed_percentage = $this->parseCurrency($_POST['executed_percentage'] ?? 0);
            if ($executed_percentage > 100)
                $executed_percentage = 100;
            $status = ($executed_percentage >= 100) ? 'finalizado' : 'pendente';

            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'percentage_work' => $percentage_work,
                'value' => $value,
                'executed_percentage' => $executed_percentage,
                'paid_value' => $this->parseCurrency($_POST['paid_value'] ?? 0),
                'status' => $status
            ];

            if ($serviceModel->update($data)) {
                $service = $serviceModel->findById($id);
                $revenueModel = new Revenue();
                $revenueModel->syncFromService($service);

                header('Location: ' . BASE_URL . '/services?work_id=' . $work_id);
                exit;
            } else {
                header('Location: ' . BASE_URL . '/services?work_id=' . $work_id . '&error=true');
            }
        }
    }

    public function createSubService()
    {
        if (!AuthHelper::hasPermission('services', 'create')) {
            die('Acesso negado. Você não tem permissão para criar sub-serviços.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service_id = $_POST['service_id'];
            $work_id = $_POST['work_id'];

            $serviceModel = new Service();
            $service = $serviceModel->findById($service_id);

            $percentage_service = $this->parseCurrency($_POST['percentage_service']);
            // Valor do sub-serviço baseado no valor do serviço pai
            $value = ($service['value'] * $percentage_service) / 100;

            $data = [
                'service_id' => $service_id,
                'name' => $_POST['name'],
                'percentage_service' => $percentage_service,
                'value' => $value,
                'executed_percentage' => 0
            ];

            $subServiceModel = new SubService();
            if ($subServiceModel->create($data)) {
                $serviceModel->recalculateProgress($service_id);
                header('Location: ' . BASE_URL . '/services?work_id=' . $work_id);
                exit;
            }
        }
    }

    public function updateSubService()
    {
        if (!AuthHelper::hasPermission('services', 'update')) {
            die('Acesso negado. Você não tem permissão para atualizar sub-serviços.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $service_id = $_POST['service_id'];
            $work_id = $_POST['work_id'];

            $serviceModel = new Service();
            $service = $serviceModel->findById($service_id);

            $percentage_service = $this->parseCurrency($_POST['percentage_service']);
            $value = ($service['value'] * $percentage_service) / 100;

            $executed_percentage = $this->parseCurrency($_POST['executed_percentage'] ?? 0);
            if ($executed_percentage > 100)
                $executed_percentage = 100;

            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'percentage_service' => $percentage_service,
                'value' => $value,
                'executed_percentage' => $executed_percentage
            ];

            $subServiceModel = new SubService();
            if ($subServiceModel->update($data)) {
                $serviceModel->recalculateProgress($service_id);
                header('Location: ' . BASE_URL . '/services?work_id=' . $work_id);
                exit;
            }
        }
    }

    public function deleteSubService($id)
    {
        if (!AuthHelper::hasPermission('services', 'delete')) {
            die('Acesso negado. Você não tem permissão para excluir sub-serviços.');
        }
        $work_id = $_GET['work_id'] ?? null;
        if ($id) {
            $subServiceModel = new SubService();
            $subService = $subServiceModel->findById($id); // Preciso do parent ID antes de deletar

            if ($subService) {
                $service_id = $subService['service_id'];
                $subServiceModel->delete($id);

                $serviceModel = new Service();
                $serviceModel->recalculateProgress($service_id);
            }
        }
        if ($work_id) {
            header('Location: ' . BASE_URL . '/services?work_id=' . $work_id);
        } else {
            header('Location: ' . BASE_URL . '/works');
        }
    }
}
