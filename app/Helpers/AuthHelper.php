<?php

class AuthHelper
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Se o usuário precisa trocar a senha e não está na página de troca de senha
        if (!empty($_SESSION['must_change_password']) && $_SESSION['must_change_password'] == 1) {
            // Usar REQUEST_URI que funciona em todos os ambientes (localhost e Vercel)
            $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
            $currentPath = ltrim($requestUri, '/');

            // Lista de caminhos permitidos (sem redirecionar)
            $allowedPaths = ['auth/change-password', 'auth/changePassword', 'auth/logout', 'logout'];

            $isAllowed = false;
            foreach ($allowedPaths as $path) {
                if (strpos($currentPath, $path) !== false) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                header('Location: ' . BASE_URL . '/auth/change-password');
                exit;
            }
        }
    }

    public static function hasPermission($resource, $action)
    {
        if (!self::isLoggedIn())
            return false;

        if ($_SESSION['user_role'] === 'admin') {
            return true;
        }

        $user_id = $_SESSION['user_id'];
        $database = new Database();
        $conn = $database->getConnection();

        $column = "can_" . $action;
        // Sanitizar o nome da coluna (embora venha do código)
        $allowedActions = ['list', 'read', 'create', 'update', 'delete'];
        if (!in_array($action, $allowedActions))
            return false;

        $query = "SELECT $column FROM user_permissions WHERE user_id = :user_id AND resource = :resource LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':resource', $resource);
        $stmt->execute();

        $permission = $stmt->fetch(PDO::FETCH_ASSOC);
        return $permission && $permission[$column] == 1;
    }
}
