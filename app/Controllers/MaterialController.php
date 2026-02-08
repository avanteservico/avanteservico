<?php

require_once '../app/Models/Material.php';
require_once '../app/Models/Work.php';
require_once '../app/Helpers/AuthHelper.php';

class MaterialController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        if (!AuthHelper::hasPermission('materials', 'list')) {
            die('Acesso negado. Você não tem permissão para listar materiais/despesas.');
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

        $materialModel = new Material();
        $materials = $materialModel->getAllByWorkId($work_id);
        $summary = $materialModel->getSummaryByWorkId($work_id);

        $works = [$work];

        $works = $workModel->getAll();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/materials/index.php';
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
        if (!AuthHelper::hasPermission('materials', 'create')) {
            die('Acesso negado. Você não tem permissão para adicionar materiais/despesas.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $materialModel = new Material();
            $work_id = $_POST['work_id'];

            $data = [
                'work_id' => $work_id,
                'name' => $_POST['name'],
                'amount' => $this->parseCurrency($_POST['amount']),
                'purchase_date' => $_POST['purchase_date'],
                'is_paid' => isset($_POST['is_paid'])
            ];

            if ($materialModel->create($data)) {
                $redirect = $work_id ? '?work_id=' . $work_id : '';
                header('Location: ' . BASE_URL . '/materials' . $redirect);
                exit;
            } else {
                $redirect = $work_id ? '?work_id=' . $work_id . '&error=true' : '?error=true';
                header('Location: ' . BASE_URL . '/materials' . $redirect);
            }
        }
    }

    public function update()
    {
        if (!AuthHelper::hasPermission('materials', 'update')) {
            die('Acesso negado. Você não tem permissão para atualizar materiais/despesas.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $materialModel = new Material();
            $id = $_POST['id'];
            $work_id = $_POST['work_id'] ?? null;

            $data = [
                'id' => $id,
                'work_id' => $work_id,
                'name' => $_POST['name'],
                'amount' => $this->parseCurrency($_POST['amount']),
                'purchase_date' => $_POST['purchase_date'],
                'is_paid' => isset($_POST['is_paid'])
            ];

            if ($materialModel->update($data)) {
                $redirect = $work_id ? '?work_id=' . $work_id : '';
                header('Location: ' . BASE_URL . '/materials' . $redirect);
                exit;
            } else {
                $redirect = $work_id ? '?work_id=' . $work_id . '&error=true' : '?error=true';
                header('Location: ' . BASE_URL . '/materials' . $redirect);
            }
        }
    }

    public function delete($id)
    {
        if (!AuthHelper::hasPermission('materials', 'delete')) {
            die('Acesso negado. Você não tem permissão para excluir materiais/despesas.');
        }
        $work_id = $_GET['work_id'] ?? null;
        if ($id) {
            $materialModel = new Material();
            $materialModel->delete($id);
        }
        if ($work_id) {
            header('Location: ' . BASE_URL . '/materials?work_id=' . $work_id);
        } else {
            header('Location: ' . BASE_URL . '/works');
        }
    }
}
