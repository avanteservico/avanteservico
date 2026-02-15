<?php





class RevenueController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        if (!AuthHelper::hasPermission('revenues', 'list')) {
            die('Acesso negado. Você não tem permissão para listar receitas.');
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
        $revenues = $revenueModel->getAllByWorkId($work_id);
        $summary = $revenueModel->getSummaryByWorkId($work_id);

        $works = [$work]; // Keep compatible with views if needed, though they should use $work

        $works = $workModel->getAll();

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/revenues/index.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
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
        if (!AuthHelper::hasPermission('revenues', 'create')) {
            die('Acesso negado. Você não tem permissão para adicionar receitas.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $revenueModel = new Revenue();
            $work_id = $_POST['work_id'];

            $data = [
                'work_id' => $work_id,
                'description' => $_POST['description'],
                'amount' => $this->parseCurrency($_POST['amount']),
                'received_date' => $_POST['received_date'],
                'status' => isset($_POST['is_received']) ? 'received' : 'to_receive'
            ];

            if ($revenueModel->create($data)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Receita cadastrada com sucesso!'
                ];
                $redirect = $work_id ? '?work_id=' . $work_id : '';
                header('Location: ' . BASE_URL . '/revenues' . $redirect);
                exit;
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cadastrar receita.'
                ];
                $redirect = $work_id ? '?work_id=' . $work_id . '&error=true' : '?error=true';
                header('Location: ' . BASE_URL . '/revenues' . $redirect);
            }
        }
    }

    public function update()
    {
        if (!AuthHelper::hasPermission('revenues', 'update')) {
            die('Acesso negado. Você não tem permissão para atualizar receitas.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $revenueModel = new Revenue();
            $id = $_POST['id'];
            $work_id = $_POST['work_id'] ?? null;

            $data = [
                'id' => $id,
                'work_id' => $work_id,
                'description' => $_POST['description'],
                'amount' => $this->parseCurrency($_POST['amount']),
                'received_date' => $_POST['received_date'],
                'status' => isset($_POST['is_received']) ? 'received' : 'to_receive'
            ];

            if ($revenueModel->update($data)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Receita atualizada com sucesso!'
                ];
                $redirect = $work_id ? '?work_id=' . $work_id : '';
                header('Location: ' . BASE_URL . '/revenues' . $redirect);
                exit;
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Erro ao atualizar receita.'
                ];
                $redirect = $work_id ? '?work_id=' . $work_id . '&error=true' : '?error=true';
                header('Location: ' . BASE_URL . '/revenues' . $redirect);
            }
        }
    }

    public function delete($id)
    {
        if (!AuthHelper::hasPermission('revenues', 'delete')) {
            die('Acesso negado. Você não tem permissão para excluir receitas.');
        }
        $work_id = $_GET['work_id'] ?? null;
        if ($id) {
            $revenueModel = new Revenue();
            if ($revenueModel->delete($id)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Receita excluída com sucesso!'
                ];
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Erro ao excluir receita.'
                ];
            }
        }
        if ($work_id) {
            header('Location: ' . BASE_URL . '/revenues?work_id=' . $work_id);
        } else {
            header('Location: ' . BASE_URL . '/works');
        }
    }
}
