<?php

class DatabaseSessionHandler implements SessionHandlerInterface
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function open($path, $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read($id): string|false
    {
        try {
            $stmt = $this->db->prepare("SELECT data FROM sessions WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['data'] : '';
        } catch (PDOException $e) {
            return '';
        }
    }

    public function write($id, $data): bool
    {
        try {
            $timestamp = time();
            $stmt = $this->db->prepare("
                INSERT INTO sessions (id, data, timestamp)
                VALUES (:id, :data, :timestamp)
                ON CONFLICT (id) DO UPDATE SET data = EXCLUDED.data, timestamp = EXCLUDED.timestamp
            ");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':timestamp', $timestamp);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function gc($max_lifetime): int|false
    {
        try {
            $old = time() - $max_lifetime;
            $stmt = $this->db->prepare("DELETE FROM sessions WHERE timestamp < :old");
            $stmt->bindParam(':old', $old);
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
