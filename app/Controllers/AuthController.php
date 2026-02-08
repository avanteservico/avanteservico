<?php

require_once '../app/Models/User.php';
require_once '../app/Helpers/AuthHelper.php';

class AuthController
{

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if (AuthHelper::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && $userModel->verifyPassword($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['must_change_password'] = $user['must_change_password'];

                header('Location: ' . BASE_URL . '/dashboard');
                exit;
            } else {
                $error = 'Email ou senha inválidos.';
            }
        }

        require_once '../app/Views/auth/login.php';
    }

    public function logout()
    {
        @session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function changePassword()
    {
        AuthHelper::requireLogin();

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if (empty($password) || strlen($password) < 6) {
                $error = 'A senha deve ter pelo menos 6 caracteres.';
            } elseif ($password !== $password_confirm) {
                $error = 'As senhas não coincidem.';
            } else {
                $userModel = new User();
                if ($userModel->changePassword($_SESSION['user_id'], $password)) {
                    $_SESSION['must_change_password'] = 0;
                    header('Location: ' . BASE_URL . '/dashboard');
                    exit;
                } else {
                    $error = 'Erro ao alterar a senha.';
                }
            }
        }

        require_once '../app/Views/auth/change_password.php';
    }

    // Método oculto para criar o admin inicial se não existir
    public function seed()
    {
        $userModel = new User();
        $adminEmail = 'avanteservico@gmail.com';

        if (!$userModel->findByEmail($adminEmail)) {
            // Senha solicitada: Ita251012
            if ($userModel->create('Administrador', $adminEmail, 'Ita251012', 'admin')) {
                // Forçar must_change_password = 0 para o admin inicial
                $user = $userModel->findByEmail($adminEmail);
                $database = new Database();
                $conn = $database->getConnection();
                $conn->query("UPDATE users SET must_change_password = 0 WHERE id = " . $user['id']);

                echo "Admin criado com sucesso. <a href='" . BASE_URL . "/login'>Ir para Login</a>";
            } else {
                echo "Erro ao criar admin.";
            }
        } else {
            echo "Admin já existe. <a href='" . BASE_URL . "/login'>Ir para Login</a>";
        }
    }
}
