<?php

require_once '../app/Config/Database.php';

class Task
{
    private $conn;
    private $table_name = "tasks";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllByWorkId($work_id)
    {
        $query = "SELECT t.*, p.name as responsible_name 
                  FROM " . $this->table_name . " t
                  LEFT JOIN people p ON t.responsible_id = p.id
                  WHERE t.work_id = :work_id 
                  ORDER BY t.column_index ASC, t.deadline ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        // Para visão geral de todas as tarefas (se necessário)
        $query = "SELECT t.*, w.name as work_name, p.name as responsible_name 
                  FROM " . $this->table_name . " t
                  JOIN works w ON t.work_id = w.id
                  LEFT JOIN people p ON t.responsible_id = p.id
                  ORDER BY t.deadline ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
            (work_id, title, priority, deadline, responsible_id, description, status) 
            VALUES 
            (:work_id, :title, :priority, :deadline, :responsible_id, :description, 'todo')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':priority', $data['priority']);
        $stmt->bindParam(':deadline', $data['deadline']);
        $stmt->bindParam(':responsible_id', $data['responsible_id']);
        $stmt->bindParam(':description', $data['description']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $query = "UPDATE " . $this->table_name . " 
            SET title=:title, priority=:priority, deadline=:deadline, 
                responsible_id=:responsible_id, description=:description 
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':priority', $data['priority']);
        $stmt->bindParam(':deadline', $data['deadline']);
        $stmt->bindParam(':responsible_id', $data['responsible_id']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $data['id']);

        return $stmt->execute();
    }

    public function updateStatus($id, $status)
    {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Método simples para deletar
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
