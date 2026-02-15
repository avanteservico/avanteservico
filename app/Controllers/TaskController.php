<?php






class TaskController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        if (!AuthHelper::hasPermission('tasks', 'list')) {
            die('Acesso negado. Você não tem permissão para listar tarefas.');
        }
        $work_id = $_GET['work_id'] ?? null;

        $taskModel = new Task();
        $workModel = new Work();
        $personModel = new Person(); // Para o modal de criar tarefa

        if ($work_id) {
            $work = $workModel->findById($work_id);
            $allTasks = $taskModel->getAllByWorkId($work_id);

            // Agrupar tarefas por status
            $tasks = [
                'todo' => [],
                'doing' => [],
                'done' => []
            ];

            foreach ($allTasks as $t) {
                // Map database status 'in_progress' to frontend status 'doing'
                if ($t['status'] === 'in_progress') {
                    $t['status'] = 'doing';
                }

                if (isset($tasks[$t['status']])) {
                    $tasks[$t['status']][] = $t;
                }
            }
        } else {
            // Se não tiver obra selecionada, redirecionar ou mostrar erro.
            // Pelo prompt: "Não pode incluir tarefas sem obra vinculada"
            // "Poderá adicionar tarefas a partir da funcionalidade de obras cadastradas ou do quadro Kanban de tarefas"
            // Vou assumir que o Kanban precisa de uma Obra selecionada para funcionar bem,
            // ou listar todas as obras para selecionar.
            // Vou redirecionar para lista de obras se não tiver ID.
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        // Dados para o modal de nova tarefa
        $people = $personModel->getAll();

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/tasks/index.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function create()
    {
        if (!AuthHelper::hasPermission('tasks', 'create')) {
            die('Acesso negado. Você não tem permissão para criar tarefas.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskModel = new Task();

            $data = [
                'work_id' => $_POST['work_id'],
                'title' => $_POST['title'],
                'priority' => $_POST['priority'],
                'deadline' => $_POST['deadline'],
                'responsible_id' => $_POST['responsible_id'],
                'description' => $_POST['description']
            ];

            if ($taskModel->create($data)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Tarefa criada com sucesso!'
                ];
                header('Location: ' . BASE_URL . '/tasks?work_id=' . $_POST['work_id']);
                exit;
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Erro ao criar tarefa.'
                ];
            }
        }
    }

    public function update()
    {
        if (!AuthHelper::hasPermission('tasks', 'update')) {
            die('Acesso negado. Você não tem permissão para atualizar tarefas.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskModel = new Task();

            $data = [
                'id' => $_POST['id'],
                'title' => $_POST['title'],
                'priority' => $_POST['priority'],
                'deadline' => $_POST['deadline'],
                'responsible_id' => $_POST['responsible_id'],
                'description' => $_POST['description']
            ];

            if ($taskModel->update($data)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Tarefa atualizada com sucesso!'
                ];
                header('Location: ' . BASE_URL . '/tasks?work_id=' . $_POST['work_id']);
                exit;
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Erro ao atualizar tarefa.'
                ];
            }
        }
    }

    public function updateStatus()
    {
        // Limpar qualquer output anterior que possa corromper o JSON
        if (ob_get_length())
            ob_clean();

        header('Content-Type: application/json');

        if (!AuthHelper::hasPermission('tasks', 'update')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão']);
            exit;
        }

        // Endpoint para AJAX/Fetch do Drag and Drop
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['success' => false, 'message' => 'JSON inválido']);
                exit;
            }

            if (isset($data['id']) && isset($data['status'])) {
                $taskModel = new Task();
                try {
                    $success = $taskModel->updateStatus($data['id'], $data['status']);
                    echo json_encode(['success' => $success]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método inválido']);
            exit;
        }
    }

    public function delete($id)
    {
        if (!AuthHelper::hasPermission('tasks', 'delete')) {
            die('Acesso negado. Você não tem permissão para excluir tarefas.');
        }
        $work_id = $_GET['work_id'] ?? null;
        if ($id) {
            $taskModel = new Task();
            if ($taskModel->delete($id)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Tarefa excluída com sucesso!'
                ];
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Erro ao excluir tarefa.'
                ];
            }
        }
        if ($work_id) {
            header('Location: ' . BASE_URL . '/tasks?work_id=' . $work_id);
        } else {
            header('Location: ' . BASE_URL . '/works');
        }
    }
}
