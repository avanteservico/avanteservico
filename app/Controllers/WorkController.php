<?php



class WorkController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        if (!AuthHelper::hasPermission('works', 'list')) {
            die('Acesso negado. Você não tem permissão para listar obras.');
        }
        $workModel = new Work();
        $works = $workModel->getAll();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/works/index.php';
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
        if (!AuthHelper::hasPermission('works', 'create')) {
            die('Acesso negado. Você não tem permissão para criar obras.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $workModel = new Work();
            $data = [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'reference_point' => $_POST['reference_point'],
                'total_value' => $this->parseCurrency($_POST['total_value']), // Parse
                'start_date' => $_POST['start_date'],
                'end_date_prediction' => $_POST['end_date_prediction']
            ];

            if ($workModel->create($data)) {
                header('Location: ' . BASE_URL . '/works');
                exit;
            } else {
                $error = "Erro ao criar obra.";
            }
        }

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/works/create.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function edit($id)
    {
        if (!AuthHelper::hasPermission('works', 'update')) {
            die('Acesso negado. Você não tem permissão para editar obras.');
        }
        $workModel = new Work();
        $work = $workModel->findById($id);

        if (!$work) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/works/edit.php'; // View a ser criada
        require_once '../app/Views/templates/footer.php';
    }

    public function update()
    {
        if (!AuthHelper::hasPermission('works', 'update')) {
            die('Acesso negado. Você não tem permissão para editar obras.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $workModel = new Work();
            $data = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'reference_point' => $_POST['reference_point'],
                'total_value' => $this->parseCurrency($_POST['total_value']),
                'start_date' => $_POST['start_date'],
                'end_date_prediction' => $_POST['end_date_prediction'],
                'status' => $_POST['status']
            ];

            if ($workModel->update($data)) {
                // Recalcular valores de serviços e sub-serviços se o valor total mudou
                $id = $data['id'];
                $totalValue = $data['total_value'];
                $serviceModel = new Service();
                $serviceModel->recalculateByWork($id, $totalValue);

                header('Location: ' . BASE_URL . '/works/show/' . $id);
                exit;
            } else {
                $error = "Erro ao atualizar obra.";
                // Redirecionar com erro ou recarregar view (simplificado aqui)
                header('Location: ' . BASE_URL . '/works/edit/' . $_POST['id']);
            }
        }
    }

    public function show($id)
    {
        if (!AuthHelper::hasPermission('works', 'read')) {
            die('Acesso negado. Você não tem permissão para visualizar detalhes da obra.');
        }
        $workModel = new Work();
        $work = $workModel->findById($id);

        if (!$work) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/works/show.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function delete($id)
    {
        if (!AuthHelper::hasPermission('works', 'delete')) {
            die('Acesso negado. Você não tem permissão para excluir obras.');
        }
        $workModel = new Work();
        if ($workModel->delete($id)) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        } else {
            // Tratar erro
            header('Location: ' . BASE_URL . '/works');
        }
    }

    public function suppliers($id)
    {
        if (!AuthHelper::hasPermission('works', 'read')) {
            die('Acesso negado.');
        }

        $workModel = new Work();
        $work = $workModel->findById($id);

        if (!$work) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        $linkedSuppliers = $workModel->getSuppliers($id);

        $supplierModel = new Supplier();
        $allSuppliers = $supplierModel->getAll();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/works/suppliers.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function addSupplier()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $work_id = $_POST['work_id'];
            $supplier_id = $_POST['supplier_id'];

            $workModel = new Work();
            $workModel->addSupplier($work_id, $supplier_id);

            header('Location: ' . BASE_URL . '/works/suppliers/' . $work_id);
            exit;
        }
    }

    public function removeSupplier($work_id)
    {
        $supplier_id = $_GET['supplier_id'];

        $workModel = new Work();
        $workModel->removeSupplier($work_id, $supplier_id);

        header('Location: ' . BASE_URL . '/works/suppliers/' . $work_id);
        exit;
    }
}
