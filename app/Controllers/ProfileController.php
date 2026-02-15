<?php




class ProfileController
{
    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/profile/index.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $id = $_SESSION['user_id'];
            $name = $_POST['name'];
            $password = $_POST['password'];

            if ($userModel->updateProfile($id, $name, $password)) {
                $success = "Perfil atualizado com sucesso.";
                $_SESSION['user_name'] = $name;
            } else {
                $error = "Erro ao atualizar perfil.";
            }

            $user = $userModel->findById($id);
            require_once ROOT_PATH . '/app/Views/templates/header.php';
            require_once ROOT_PATH . '/app/Views/profile/index.php';
            require_once ROOT_PATH . '/app/Views/templates/footer.php';
        }
    }
}
