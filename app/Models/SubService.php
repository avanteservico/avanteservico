<?php



class SubService
{
    private $conn;
    private $table_name = "sub_services";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllByServiceId($service_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE service_id = :service_id ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':service_id', $service_id);
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
            (service_id, name, percentage_service, value, executed_percentage) 
            VALUES 
            (:service_id, :name, :percentage_service, :value, :executed_percentage)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':service_id', $data['service_id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':percentage_service', $data['percentage_service']);
        $stmt->bindParam(':value', $data['value']);
        $stmt->bindParam(':executed_percentage', $data['executed_percentage']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // TODO: Update e Delete se necessário
    public function update($data)
    {
        $query = "UPDATE " . $this->table_name . " 
            SET name=:name, percentage_service=:percentage_service, 
                value=:value, executed_percentage=:executed_percentage 
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':percentage_service', $data['percentage_service']);
        $stmt->bindParam(':value', $data['value']);
        $stmt->bindParam(':executed_percentage', $data['executed_percentage']);
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

    public function recalculateByService($service_id, $new_service_value)
    {
        $subServices = $this->getAllByServiceId($service_id);

        foreach ($subServices as $sub) {
            $newValue = ($new_service_value * $sub['percentage_service']) / 100;

            $query = "UPDATE " . $this->table_name . " SET value = :value WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':value', $newValue);
            $stmt->bindParam(':id', $sub['id']);
            $stmt->execute();
        }
    }
}
