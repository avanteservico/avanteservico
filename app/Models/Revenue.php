<?php

require_once '../app/Config/Database.php';

class Revenue
{
    private $conn;
    private $table_name = "revenues";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT r.*, w.name as work_name 
                  FROM " . $this->table_name . " r 
                  LEFT JOIN works w ON r.work_id = w.id 
                  ORDER BY r.received_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByWorkId($work_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE work_id = :work_id ORDER BY received_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
            (work_id, service_id, description, amount, received_date, status) 
            VALUES 
            (:work_id, :service_id, :description, :amount, :received_date, :status)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':service_id', $data['service_id']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':received_date', $data['received_date']);
        $stmt->bindParam(':status', $data['status']);

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
            SET description=:description, amount=:amount, received_date=:received_date, status=:status, work_id=:work_id, service_id=:service_id 
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':received_date', $data['received_date']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':service_id', $data['service_id']);
        $stmt->bindParam(':id', $data['id']);

        return $stmt->execute();
    }

    public function getSummaryByWorkId($work_id)
    {
        $query = "SELECT 
            SUM(CASE WHEN status = 'received' THEN amount ELSE 0 END) as total_received,
            SUM(CASE WHEN status = 'to_receive' THEN amount ELSE 0 END) as total_to_receive
            FROM " . $this->table_name . " WHERE work_id = :work_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getGlobalSummary()
    {
        $query = "SELECT 
            SUM(CASE WHEN status = 'received' THEN amount ELSE 0 END) as total_received,
            SUM(CASE WHEN status = 'to_receive' THEN amount ELSE 0 END) as total_to_receive
            FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByServiceId($service_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE service_id = :service_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function syncFromService($serviceData)
    {
        $existing = $this->findByServiceId($serviceData['id']);

        if ($serviceData['paid_value'] <= 0) {
            if ($existing) {
                return $this->delete($existing['id']);
            }
            return true;
        }

        $revData = [
            'work_id' => $serviceData['work_id'],
            'service_id' => $serviceData['id'],
            'description' => "Recebimento: " . $serviceData['name'],
            'amount' => $serviceData['paid_value'],
            'received_date' => date('Y-m-d'),
            'status' => 'received'
        ];

        if ($existing) {
            $revData['id'] = $existing['id'];
            return $this->update($revData);
        } else {
            return $this->create($revData);
        }
    }
}
