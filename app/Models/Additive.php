<?php

class Additive
{
    private $conn;
    private $table_name = "additives";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllByWorkId($work_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE work_id = :work_id ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table_name . "
            (work_id, name, description, status)
            VALUES
            (:work_id, :name, :description, :status)";

        $stmt = $this->conn->prepare($query);

        $status = 'pendente';

        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function update($data)
    {
        $query = "UPDATE " . $this->table_name . "
            SET name=:name, description=:description, status=:status
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $data['id']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function recalculateStatus($additive_id)
    {
        $subAdditiveModel = new SubAdditive();
        $subAdditives = $subAdditiveModel->getAllByAdditiveId($additive_id);

        if (empty($subAdditives)) {
            return;
        }

        $allFinished = true;
        foreach ($subAdditives as $sub) {
            if ($sub['status'] !== 'finalizado') {
                $allFinished = false;
                break;
            }
        }

        $status = $allFinished ? 'finalizado' : 'pendente';

        $query = "UPDATE " . $this->table_name . "
            SET status = :status
            WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $additive_id);
        $stmt->execute();
    }
}
