<?php
require_once __DIR__ . '/app/Config/config.php';
require_once __DIR__ . '/app/Config/Database.php';

$database = new Database();
try {
    $conn = $database->getConnection();
    echo "Conexão bem-sucedida!\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
