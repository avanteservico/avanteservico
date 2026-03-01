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
            (work_id, name, value, executed_percentage, paid_value, status)
            VALUES
            (:work_id, :name, :value, :executed_percentage, :paid_value, :status)";

        $stmt = $this->conn->prepare($query);

        $status = ($data['executed_percentage'] >= 100) ? 'finalizado' : 'pendente';

        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':value', $data['value']);
        $stmt->bindParam(':executed_percentage', $data['executed_percentage']);
        $stmt->bindParam(':paid_value', $data['paid_value']);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function update($data)
    {
        $query = "UPDATE " . $this->table_name . "
            SET name=:name, value=:value, executed_percentage=:executed_percentage,
                paid_value=:paid_value, status=:status
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $status = ($data['executed_percentage'] >= 100) ? 'finalizado' : 'pendente';

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':value', $data['value']);
        $stmt->bindParam(':executed_percentage', $data['executed_percentage']);
        $stmt->bindParam(':paid_value', $data['paid_value']);
        $stmt->bindParam(':status', $status);
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
}
