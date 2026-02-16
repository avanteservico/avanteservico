<?php

// Reutilizar configurações e conexões
require_once __DIR__ . '/../app/Config/config.php';
require_once __DIR__ . '/../app/Config/Database.php';

// Definir o caminho do arquivo de backup
$backupDir = __DIR__ . '/../backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
$filepath = $backupDir . '/' . $filename;

echo "Iniciando backup em: $filepath\n";

$database = new Database();
$conn = $database->getConnection();

$sqlContent = "-- Backup Avante Serviço\n";
$sqlContent .= "-- Data: " . date('d/m/Y H:i:s') . "\n\n";
$sqlContent .= "SET statement_timeout = 0;\n";
$sqlContent .= "SET client_encoding = 'UTF8';\n";
$sqlContent .= "SET standard_conforming_strings = on;\n";
$sqlContent .= "SET check_function_bodies = false;\n";
$sqlContent .= "SET client_min_messages = warning;\n\n";

// Listar Tabelas
$tablesQuery = "SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                AND table_type = 'BASE TABLE'
                ORDER BY table_name";
$stmt = $conn->query($tablesQuery);
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    echo "Processando tabela: $table...\n";
    $sqlContent .= "-- Tabela: $table\n";

    // Estrutura (DROP e CREATE simplificado para restauração manual)
    $sqlContent .= "DROP TABLE IF EXISTS \"$table\" CASCADE;\n";

    // Obter colunas
    $colsQuery = "SELECT column_name, data_type, is_nullable, column_default, character_maximum_length 
                  FROM information_schema.columns 
                  WHERE table_schema = 'public' AND table_name = '$table'
                  ORDER BY ordinal_position";
    $colsStmt = $conn->query($colsQuery);
    $columns = $colsStmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlContent .= "CREATE TABLE \"$table\" (\n";
    $colDefs = [];
    foreach ($columns as $col) {
        $def = "  \"" . $col['column_name'] . "\" " . $col['data_type'];
        if ($col['character_maximum_length']) {
            $def .= "(" . $col['character_maximum_length'] . ")";
        }
        if ($col['is_nullable'] === 'NO') {
            $def .= " NOT NULL";
        }
        if ($col['column_default']) {
            $def .= " DEFAULT " . $col['column_default'];
        }
        $colDefs[] = $def;
    }

    // Primary Key
    $pkQuery = "SELECT a.attname
                FROM pg_index i
                JOIN pg_attribute a ON a.attrelid = i.indrelid AND a.attnum = ANY(i.indkey)
                WHERE i.indrelid = '\"$table\"'::regclass
                AND i.indisprimary";
    $pkStmt = $conn->query($pkQuery);
    $pks = $pkStmt->fetchAll(PDO::FETCH_COLUMN);
    if (!empty($pks)) {
        $colDefs[] = "  CONSTRAINT \"{$table}_pkey\" PRIMARY KEY (\"" . implode('", "', $pks) . "\")";
    }

    $sqlContent .= implode(",\n", $colDefs) . "\n);\n\n";

    // Dados (INSERTs)
    $dataStmt = $conn->query("SELECT * FROM \"$table\"");
    $rows = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $cols = [];
            $vals = [];
            foreach ($row as $k => $v) {
                $cols[] = "\"$k\"";
                if ($v === null) {
                    $vals[] = "NULL";
                } elseif (is_bool($v)) {
                    $vals[] = $v ? 'TRUE' : 'FALSE';
                } elseif (is_numeric($v)) {
                    $vals[] = $v;
                } else {
                    $vals[] = $conn->quote($v);
                }
            }
            $sqlContent .= "INSERT INTO \"$table\" (" . implode(", ", $cols) . ") VALUES (" . implode(", ", $vals) . ");\n";
        }
        $sqlContent .= "\n";
    }
}

file_put_contents($filepath, $sqlContent);
echo "Backup concluído com sucesso: $filename\n";
