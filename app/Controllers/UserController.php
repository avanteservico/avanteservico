<?php




class UserController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
        // Verificar se é admin
        if ($_SESSION['user_role'] !== 'admin') {
            die('Acesso negado. Apenas administradores podem acessar esta área.');
        }
    }

    public function index()
    {
        $userModel = new User();
        $users = $userModel->getAll();

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/admin/users/index.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password']; // Senha temporária
            $role = $_POST['role'];

            if ($userModel->create($name, $email, $password, $role)) {
                header('Location: ' . BASE_URL . '/users');
                exit;
            } else {
                $error = "Erro ao criar usuário.";
            }
        }

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/admin/users/create.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->findById($id);

        if (!$user) {
            header('Location: ' . BASE_URL . '/users');
            exit;
        }

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/admin/users/edit.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            if ($userModel->adminUpdate($id, $name, $email, $role)) {
                header('Location: ' . BASE_URL . '/users');
                exit;
            } else {
                $error = "Erro ao atualizar usuário.";
                $user = $userModel->findById($id);
                require_once ROOT_PATH . '/app/Views/templates/header.php';
                require_once ROOT_PATH . '/app/Views/admin/users/edit.php';
                require_once ROOT_PATH . '/app/Views/templates/footer.php';
            }
        }
    }

    public function delete($id)
    {
        // Evitar que o admin se delete (opcional, mas recomendado)
        if ($id == $_SESSION['user_id']) {
            die('Você não pode excluir sua própria conta.');
        }

        $userModel = new User();
        if ($userModel->delete($id)) {
            header('Location: ' . BASE_URL . '/users');
            exit;
        } else {
            die('Erro ao excluir usuário.');
        }
    }

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $id = $_POST['id'];
            $tempPassword = $_POST['temp_password'];

            if ($userModel->resetPassword($id, $tempPassword)) {
                header('Location: ' . BASE_URL . '/users?reset=success');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/users?reset=error');
                exit;
            }
        }
    }

    public function permissions($id)
    {
        $userModel = new User();
        $user = $userModel->findById($id);

        if (!$user) {
            header('Location: ' . BASE_URL . '/users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $permissions = $_POST['permissions'] ?? [];
            if ($userModel->savePermissions($id, $permissions)) {
                $success = "Permissões atualizadas com sucesso.";
            } else {
                $error = "Erro ao salvar permissões.";
            }
        }

        $userPermissions = $userModel->getPermissions($id);

        // Formatar permissões para a view indexada por recurso
        $formattedPermissions = [];
        foreach ($userPermissions as $p) {
            $formattedPermissions[$p['resource']] = $p;
        }

        // Recursos disponíveis no sistema
        $resources = [
            'works' => 'Obras',
            'tasks' => 'Tarefas / Kanban',
            'people' => 'Equipe / Pessoas',
            'services' => 'Serviços da Obra',
            'financial' => 'Painel Financeiro',
            'revenues' => 'Receitas',
            'materials' => 'Materiais / Despesas',
            'users' => 'Usuários (Admin)'
        ];

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/admin/users/permissions.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }
}
