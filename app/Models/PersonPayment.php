<?php

require_once '../app/Config/Database.php';

class PersonPayment
{
    private $conn;
    private $table_name = "person_payments";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getByPersonId($person_id)
    {
        $query = "SELECT pp.*, w.name as work_name 
                  FROM " . $this->table_name . " pp
                  LEFT JOIN works w ON pp.work_id = w.id
                  WHERE person_id = :person_id 
                  ORDER BY payment_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':person_id', $person_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
            (person_id, work_id, amount, payment_date, description, is_paid) 
            VALUES 
            (:person_id, :work_id, :amount, :payment_date, :description, :is_paid)";

        $stmt = $this->conn->prepare($query);

        $is_paid = isset($data['is_paid']) && $data['is_paid'] ? '1' : '0';

        $stmt->bindParam(':person_id', $data['person_id']);
        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':payment_date', $data['payment_date']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':is_paid', $is_paid, PDO::PARAM_BOOL);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSummaryByPerson($person_id)
    {
        $query = "SELECT 
            SUM(CASE WHEN is_paid = TRUE THEN amount ELSE 0 END) as total_paid,
            SUM(CASE WHEN is_paid = FALSE THEN amount ELSE 0 END) as total_pending
            FROM " . $this->table_name . " WHERE person_id = :person_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':person_id', $person_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function getAllSummaries()
    {
        $query = "SELECT person_id,
            SUM(CASE WHEN is_paid = TRUE THEN amount ELSE 0 END) as total_paid,
            SUM(CASE WHEN is_paid = FALSE THEN amount ELSE 0 END) as total_pending
            FROM " . $this->table_name . " 
            GROUP BY person_id";
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

    public function update($data)
    {
        $query = "UPDATE " . $this->table_name . " 
            SET work_id=:work_id, amount=:amount, payment_date=:payment_date, description=:description, is_paid=:is_paid 
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $is_paid = isset($data['is_paid']) && $data['is_paid'] ? '1' : '0';

        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':payment_date', $data['payment_date']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':is_paid', $is_paid, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $data['id']);

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
