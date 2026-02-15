<?php



class Service
{
    private $conn;
    private $table_name = "services";

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
        // Calcular valor baseado no percentual e valor da obra
        // Preciso buscar o valor da obra primeiro? Sim.
        // Mas o model Service não deve depender do Model Work diretamente para evitar dependência circular se possível,
        // mas aqui é necessário. Ou o controller passa o valor calculado.
        // Vou fazer o controller passar os valores já calculados para manter o Model simples.

        $query = "INSERT INTO " . $this->table_name . " 
            (work_id, name, percentage_work, value, executed_percentage, paid_value, status) 
            VALUES 
            (:work_id, :name, :percentage_work, :value, :executed_percentage, :paid_value, :status)";

        $stmt = $this->conn->prepare($query);

        $status = ($data['executed_percentage'] >= 100) ? 'finalizado' : 'pendente';

        $stmt->bindParam(':work_id', $data['work_id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':percentage_work', $data['percentage_work']);
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
            SET name=:name, percentage_work=:percentage_work, value=:value, 
                executed_percentage=:executed_percentage, paid_value=:paid_value, status=:status 
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $status = ($data['executed_percentage'] >= 100) ? 'finalizado' : 'pendente';

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':percentage_work', $data['percentage_work']);
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

    public function recalculateByWork($work_id, $new_total_value)
    {
        $services = $this->getAllByWorkId($work_id);
        $subServiceModel = new SubService();

        foreach ($services as $service) {
            $newValue = ($new_total_value * $service['percentage_work']) / 100;

            $query = "UPDATE " . $this->table_name . " SET value = :value WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':value', $newValue);
            $stmt->bindParam(':id', $service['id']);
            $stmt->execute();

            // Cascade to sub-services
            $subServiceModel->recalculateByService($service['id'], $newValue);
        }
    }
    public function recalculateProgress($service_id)
    {
        $subServiceModel = new SubService();
        $subServices = $subServiceModel->getAllByServiceId($service_id);

        if (empty($subServices)) {
            return;
        }

        $calculatedProgress = 0;
        foreach ($subServices as $sub) {
            $calculatedProgress += ($sub['executed_percentage'] * $sub['percentage_service']) / 100;
        }

        // Limita a 100% se passar por erro de arredondamento ou inconsistência
        if ($calculatedProgress > 100)
            $calculatedProgress = 100;

        $status = ($calculatedProgress >= 100) ? 'finalizado' : 'pendente';

        $query = "UPDATE " . $this->table_name . " 
            SET executed_percentage = :executed_percentage, status = :status 
            WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':executed_percentage', $calculatedProgress);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $service_id);
        $stmt->execute();
    }
}
