<?php



class User
{
    private $conn;
    private $table_name = "users";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $password, $role = 'user')
    {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role, must_change_password) VALUES (:name, :email, :password, :role, 1)";
        $stmt = $this->conn->prepare($query);

        // Hash da senha
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function verifyPassword($inputPassword, $storedPassword)
    {
        return password_verify($inputPassword, $storedPassword);
    }

    public function changePassword($id, $newPassword)
    {
        $query = "UPDATE " . $this->table_name . " SET password = :password, must_change_password = 0 WHERE id = :id";
        $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAll()
    {
        $query = "SELECT id, name, email, role, must_change_password, created_at FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPermissions($user_id)
    {
        $query = "SELECT * FROM user_permissions WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function savePermissions($user_id, $permissions)
    {
        // Primeiro deletar existentes
        $query = "DELETE FROM user_permissions WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Inserir novas
        $query = "INSERT INTO user_permissions (user_id, resource, can_list, can_read, can_create, can_update, can_delete) VALUES (:user_id, :resource, :can_list, :can_read, :can_create, :can_update, :can_delete)";
        $stmt = $this->conn->prepare($query);

        foreach ($permissions as $resource => $actions) {
            $can_list = isset($actions['list']) ? 1 : 0;
            $can_read = isset($actions['read']) ? 1 : 0;
            $can_create = isset($actions['create']) ? 1 : 0;
            $can_update = isset($actions['update']) ? 1 : 0;
            $can_delete = isset($actions['delete']) ? 1 : 0;

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':resource', $resource);
            $stmt->bindParam(':can_list', $can_list);
            $stmt->bindParam(':can_read', $can_read);
            $stmt->bindParam(':can_create', $can_create);
            $stmt->bindParam(':can_update', $can_update);
            $stmt->bindParam(':can_delete', $can_delete);
            $stmt->execute();
        }
        return true;
    }

    public function updateProfile($id, $name, $password = null)
    {
        if ($password) {
            $query = "UPDATE " . $this->table_name . " SET name = :name, password = :password WHERE id = :id";
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $password_hash);
        } else {
            $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";
            $stmt = $this->conn->prepare($query);
        }

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function adminUpdate($id, $name, $email, $role)
    {
        $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function resetPassword($id, $tempPassword)
    {
        $query = "UPDATE " . $this->table_name . " SET password = :password, must_change_password = 1 WHERE id = :id";
        $password_hash = password_hash($tempPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
