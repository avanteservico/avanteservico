<?php

class SubAdditive
{
    private $conn;
    private $table_name = "sub_additives";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllByAdditiveId($additive_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE additive_id = :additive_id ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':additive_id', $additive_id);
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
            (additive_id, name, status)
            VALUES
            (:additive_id, :name, :status)";

        $stmt = $this->conn->prepare($query);

        $status = 'pendente';

        $stmt->bindParam(':additive_id', $data['additive_id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update($data)
    {
        $query = "UPDATE " . $this->table_name . "
            SET name=:name, status=:status
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
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
}
