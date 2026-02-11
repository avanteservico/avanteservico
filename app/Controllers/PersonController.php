<?php






class PersonController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        if (!AuthHelper::hasPermission('people', 'list')) {
            die('Acesso negado. Você não tem permissão para listar pessoas.');
        }
        $personModel = new Person();
        $people = $personModel->getAll();

        $paymentModel = new PersonPayment();
        $summaries = $paymentModel->getAllSummaries();

        // Mapear resumos por ID de pessoa
        $mappedSummaries = [];
        foreach ($summaries as $s) {
            $mappedSummaries[$s['person_id']] = $s;
        }

        // Adicionar saldos a cada pessoa
        foreach ($people as &$person) {
            $person['total_paid'] = $mappedSummaries[$person['id']]['total_paid'] ?? 0;
            $person['total_pending'] = $mappedSummaries[$person['id']]['total_pending'] ?? 0;
        }
        unset($person);

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/people/index.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function create()
    {
        if (!AuthHelper::hasPermission('people', 'create')) {
            die('Acesso negado. Você não tem permissão para cadastrar pessoas.');
        }
        $personModel = new Person();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'nickname' => $_POST['nickname'],
                'phone' => $_POST['phone'],
                'role' => $_POST['role'] === 'new' ? $_POST['new_role'] : $_POST['role'], // Lógica para nova função
                'service_type' => $_POST['service_type'],
                'description' => $_POST['description']
            ];

            if ($personModel->create($data)) {
                header('Location: ' . BASE_URL . '/people');
                exit;
            } else {
                $error = "Erro ao cadastrar pessoa.";
            }
        }

        $roles = $personModel->getDistinctRoles();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/people/create.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function show($id)
    {
        if (!AuthHelper::hasPermission('people', 'read')) {
            die('Acesso negado. Você não tem permissão para visualizar detalhes da pessoa.');
        }
        $personModel = new Person();
        $person = $personModel->findById($id);

        if (!$person) {
            header('Location: ' . BASE_URL . '/people');
            exit;
        }

        $paymentModel = new PersonPayment();
        $payments = $paymentModel->getByPersonId($id);
        $summary = $paymentModel->getSummaryByPerson($id);

        // Buscar obras para o select de pagamento
        $workModel = new Work();
        $works = $workModel->getAll();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/people/show.php';
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

    public function createPayment()
    {
        if (!AuthHelper::hasPermission('people', 'update')) {
            die('Acesso negado. Você não tem permissão para registrar pagamentos.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentModel = new PersonPayment();
            $person_id = $_POST['person_id'];

            $data = [
                'person_id' => $person_id,
                'work_id' => !empty($_POST['work_id']) ? $_POST['work_id'] : null,
                'amount' => $this->parseCurrency($_POST['amount']),
                'payment_date' => $_POST['payment_date'],
                'description' => $_POST['description'],
                'is_paid' => isset($_POST['is_paid'])
            ];

            if ($paymentModel->create($data)) {
                header('Location: ' . BASE_URL . '/people/show/' . $person_id);
                exit;
            } else {
                // Erro
                header('Location: ' . BASE_URL . '/people/show/' . $person_id . '?error=true');
            }
        }
    }

    public function updatePayment()
    {
        if (!AuthHelper::hasPermission('people', 'update')) {
            die('Acesso negado. Você não tem permissão para atualizar pagamentos.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentModel = new PersonPayment();
            $id = $_POST['id'];
            $person_id = $_POST['person_id'];

            $data = [
                'id' => $id,
                'person_id' => $person_id,
                'work_id' => !empty($_POST['work_id']) ? $_POST['work_id'] : null,
                'amount' => $this->parseCurrency($_POST['amount']),
                'payment_date' => $_POST['payment_date'],
                'description' => $_POST['description'],
                'is_paid' => isset($_POST['is_paid'])
            ];

            if ($paymentModel->update($data)) {
                header('Location: ' . BASE_URL . '/people/show/' . $person_id);
                exit;
            } else {
                header('Location: ' . BASE_URL . '/people/show/' . $person_id . '?error=true');
            }
        }
    }

    public function deletePayment($id)
    {
        if (!AuthHelper::hasPermission('people', 'delete')) {
            die('Acesso negado. Você não tem permissão para excluir pagamentos.');
        }
        $person_id = $_GET['person_id'] ?? null;
        if ($id) {
            $paymentModel = new PersonPayment();
            $paymentModel->delete($id);
        }

        if ($person_id) {
            header('Location: ' . BASE_URL . '/people/show/' . $person_id);
        } else {
            header('Location: ' . BASE_URL . '/people');
        }
        exit;
    }
}
