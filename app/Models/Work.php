<?php



class Work
{
    private $conn;
    private $table_name = "works";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActive()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = 'active' ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSummary()
    {
        $query = "SELECT 
            COUNT(*) as total_works,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_works,
            SUM(total_value) as total_value
            FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
            (name, address, reference_point, total_value, start_date, end_date_prediction) 
            VALUES 
            (:name, :address, :reference_point, :total_value, :start_date, :end_date_prediction)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':reference_point', $data['reference_point']);
        $stmt->bindParam(':total_value', $data['total_value']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date_prediction', $data['end_date_prediction']);

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
            SET name=:name, address=:address, reference_point=:reference_point, 
                total_value=:total_value, start_date=:start_date, end_date_prediction=:end_date_prediction, status=:status 
            WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':reference_point', $data['reference_point']);
        $stmt->bindParam(':total_value', $data['total_value']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date_prediction', $data['end_date_prediction']);
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

    public function getSuppliers($work_id)
    {
        $query = "SELECT s.* FROM suppliers s
                  JOIN work_suppliers ws ON s.id = ws.supplier_id
                  WHERE ws.work_id = :work_id
                  ORDER BY s.name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSupplier($work_id, $supplier_id)
    {
        $query = "INSERT IGNORE INTO work_suppliers (work_id, supplier_id) VALUES (:work_id, :supplier_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->bindParam(':supplier_id', $supplier_id);
        return $stmt->execute();
    }

    public function removeSupplier($work_id, $supplier_id)
    {
        $query = "DELETE FROM work_suppliers WHERE work_id = :work_id AND supplier_id = :supplier_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->bindParam(':supplier_id', $supplier_id);
        return $stmt->execute();
    }

    public function getAllSuppliersWithWorks()
    {
        $query = "(SELECT s.name as supplier_name, w.name as work_name, s.id as supplier_id, w.id as work_id, 'Vínculo Direto' as type
                  FROM suppliers s
                  JOIN work_suppliers ws ON s.id = ws.supplier_id
                  JOIN works w ON ws.work_id = w.id)
                  UNION
                  (SELECT DISTINCT s.name as supplier_name, w.name as work_name, s.id as supplier_id, w.id as work_id, 'Via Despesa' as type
                  FROM suppliers s
                  JOIN materials m ON s.id = m.supplier_id
                  JOIN works w ON m.work_id = w.id)
                  ORDER BY work_name ASC, supplier_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
