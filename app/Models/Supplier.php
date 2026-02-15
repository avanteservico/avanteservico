<?php



class Supplier
{
    private $conn;
    private $table_name = "suppliers";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
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
            (name, phone, contact_name, contact_phone, observations) 
            VALUES 
            (:name, :phone, :contact_name, :contact_phone, :observations)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':contact_name', $data['contact_name']);
        $stmt->bindParam(':contact_phone', $data['contact_phone']);
        $stmt->bindParam(':observations', $data['observations']);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function update($data)
    {
        $query = "UPDATE " . $this->table_name . " 
            SET name=:name, phone=:phone, contact_name=:contact_name, contact_phone=:contact_phone, observations=:observations
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':contact_name', $data['contact_name']);
        $stmt->bindParam(':contact_phone', $data['contact_phone']);
        $stmt->bindParam(':observations', $data['observations']);
        $stmt->bindParam(':id', $data['id']);

        return $stmt->execute();
    }

    public function delete($id)
    {
        // Check for dependencies (expenses) handled by DB constraints usually, 
        // but specific error handling here is good.
        // For now, simple delete which will fail if foreign keys exist (RESTRICT)

        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getExpenses($supplier_id)
    {
        $query = "SELECT m.*, w.name as work_name, et.name as expense_type_name
                  FROM materials m
                  LEFT JOIN works w ON m.work_id = w.id
                  LEFT JOIN expense_types et ON m.expense_type_id = et.id
                  WHERE m.supplier_id = :supplier_id
                  ORDER BY m.purchase_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSummary($supplier_id)
    {
        $query = "SELECT 
            SUM(CASE WHEN is_paid = true THEN amount ELSE 0 END) as total_paid,
            SUM(CASE WHEN is_paid = false THEN amount ELSE 0 END) as total_pending
            FROM materials WHERE supplier_id = :supplier_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
