<?php

require_once '../app/Config/Database.php';

class Material
{
    private $conn;
    private $table_name = "materials";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT m.*, w.name as work_name, et.name as expense_type_name, s.name as supplier_name 
                  FROM " . $this->table_name . " m 
                  LEFT JOIN works w ON m.work_id = w.id 
                  LEFT JOIN expense_types et ON m.expense_type_id = et.id
                  LEFT JOIN suppliers s ON m.supplier_id = s.id
                  ORDER BY m.purchase_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByWorkId($work_id)
    {
        $query = "SELECT m.*, et.name as expense_type_name, s.name as supplier_name 
                  FROM " . $this->table_name . " m 
                  LEFT JOIN expense_types et ON m.expense_type_id = et.id
                  LEFT JOIN suppliers s ON m.supplier_id = s.id
                  WHERE m.work_id = :work_id 
                  ORDER BY m.purchase_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
            (work_id, name, expense_type_id, supplier_id, amount, purchase_date, is_paid) 
            VALUES 
            (:work_id, :name, :expense_type_id, :supplier_id, :amount, :purchase_date, :is_paid)";

        $stmt = $this->conn->prepare($query);

        $is_paid = isset($data['is_paid']) && $data['is_paid'] ? '1' : '0';
        $expense_type_id = isset($data['expense_type_id']) && $data['expense_type_id'] ? $data['expense_type_id'] : 1;
        $supplier_id = isset($data['supplier_id']) && $data['supplier_id'] ? $data['supplier_id'] : 1; // Default to 1

        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':expense_type_id', $expense_type_id);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':purchase_date', $data['purchase_date']);
        $stmt->bindParam(':is_paid', $is_paid, PDO::PARAM_BOOL);

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
        return $stmt->execute();
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
            SET name=:name, expense_type_id=:expense_type_id, supplier_id=:supplier_id, amount=:amount, purchase_date=:purchase_date, is_paid=:is_paid, work_id=:work_id 
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $is_paid = isset($data['is_paid']) && $data['is_paid'] ? '1' : '0';
        $expense_type_id = isset($data['expense_type_id']) && $data['expense_type_id'] ? $data['expense_type_id'] : 1;
        $supplier_id = isset($data['supplier_id']) && $data['supplier_id'] ? $data['supplier_id'] : 1;

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':expense_type_id', $expense_type_id);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':purchase_date', $data['purchase_date']);
        $stmt->bindParam(':is_paid', $is_paid, PDO::PARAM_BOOL);
        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':id', $data['id']);

        return $stmt->execute();
    }

    public function getSummaryByWorkId($work_id)
    {
        $query = "SELECT 
            SUM(CASE WHEN is_paid = TRUE THEN amount ELSE 0 END) as total_paid,
            SUM(CASE WHEN is_paid = FALSE THEN amount ELSE 0 END) as total_pending
            FROM " . $this->table_name . " WHERE work_id = :work_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getGlobalSummary()
    {
        $query = "SELECT 
            SUM(CASE WHEN is_paid = TRUE THEN amount ELSE 0 END) as total_paid,
            SUM(CASE WHEN is_paid = FALSE THEN amount ELSE 0 END) as total_pending
            FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
