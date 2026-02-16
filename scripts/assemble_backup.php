<?php

$backupDir = __DIR__ . '/../backups';
$filename = 'backup_completo_' . date('Y-m-d_H-i') . '.sql';
$filepath = $backupDir . '/' . $filename;

$dataFiles = [
    'people' => 'C:/Users/docil/.gemini/antigravity/brain/ed533a8c-b288-41b1-ba2d-e18a86c08fd4/.system_generated/steps/437/output.txt',
    'person_payments' => 'C:/Users/docil/.gemini/antigravity/brain/ed533a8c-b288-41b1-ba2d-e18a86c08fd4/.system_generated/steps/442/output.txt',
    'materials' => 'C:/Users/docil/.gemini/antigravity/brain/ed533a8c-b288-41b1-ba2d-e18a86c08fd4/.system_generated/steps/455/output.txt',
    'tasks' => 'C:/Users/docil/.gemini/antigravity/brain/ed533a8c-b288-41b1-ba2d-e18a86c08fd4/.system_generated/steps/458/output.txt',
    'services' => 'C:/Users/docil/.gemini/antigravity/brain/ed533a8c-b288-41b1-ba2d-e18a86c08fd4/.system_generated/steps/466/output.txt'
];

$sql = "-- AVANTE SERVIÇO - BACKUP COMPLETO (MCP EXTRACTION)\n";
$sql .= "-- Gerado em: " . date('d/m/Y H:i:s') . "\n\n";

$tables = [
    'expense_types',
    'suppliers',
    'works',
    'people',
    'services',
    'materials',
    'person_payments',
    'revenues',
    'sub_services',
    'tasks',
    'users',
    'user_permissions',
    'work_suppliers'
];

foreach ($tables as $table) {
    $sql .= "DROP TABLE IF EXISTS \"$table\" CASCADE;\n";
}
$sql .= "\n";

$sql .= "CREATE TABLE expense_types (id SERIAL PRIMARY KEY, created_at TIMESTAMPTZ DEFAULT NOW(), name VARCHAR NOT NULL);\n";
$sql .= "CREATE TABLE suppliers (id SERIAL PRIMARY KEY, observations TEXT, created_at TIMESTAMPTZ DEFAULT NOW(), name VARCHAR NOT NULL, phone VARCHAR, contact_name VARCHAR, contact_phone VARCHAR);\n";
$sql .= "CREATE TABLE works (id SERIAL PRIMARY KEY, total_value NUMERIC DEFAULT 0.00, name VARCHAR NOT NULL, address TEXT, reference_point TEXT, status TEXT DEFAULT 'active', created_at TIMESTAMPTZ DEFAULT NOW(), end_date_prediction DATE, start_date DATE);\n";
$sql .= "CREATE TABLE people (id SERIAL PRIMARY KEY, role VARCHAR, description TEXT, service_type TEXT DEFAULT 'daily', phone VARCHAR, nickname VARCHAR, name VARCHAR NOT NULL, created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE services (id SERIAL PRIMARY KEY, work_id INTEGER NOT NULL, name VARCHAR NOT NULL, percentage_work NUMERIC DEFAULT 0.00, value NUMERIC DEFAULT 0.00, executed_percentage NUMERIC DEFAULT 0.00, status TEXT DEFAULT 'pendente', paid_value NUMERIC DEFAULT 0.00, created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE materials (id SERIAL PRIMARY KEY, work_id INTEGER NOT NULL, supplier_id INTEGER, name VARCHAR NOT NULL, expense_type_id INTEGER, amount NUMERIC NOT NULL, purchase_date DATE NOT NULL, is_paid BOOLEAN DEFAULT FALSE, created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE person_payments (id SERIAL PRIMARY KEY, person_id INTEGER NOT NULL, work_id INTEGER, amount NUMERIC NOT NULL, payment_date DATE NOT NULL, description VARCHAR, is_paid BOOLEAN DEFAULT FALSE, created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE revenues (id SERIAL PRIMARY KEY, work_id INTEGER NOT NULL, service_id INTEGER, description VARCHAR NOT NULL, amount NUMERIC NOT NULL, received_date DATE NOT NULL, status TEXT DEFAULT 'to_receive', created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE sub_services (id SERIAL PRIMARY KEY, service_id INTEGER NOT NULL, name VARCHAR NOT NULL, percentage_service NUMERIC DEFAULT 0.00, value NUMERIC DEFAULT 0.00, executed_percentage NUMERIC DEFAULT 0.00, created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE tasks (id SERIAL PRIMARY KEY, work_id INTEGER NOT NULL, responsible_id INTEGER, title VARCHAR NOT NULL, description TEXT, status TEXT DEFAULT 'todo', priority TEXT DEFAULT 'medium', deadline DATE, column_index INTEGER DEFAULT 0, created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE users (id SERIAL PRIMARY KEY, name VARCHAR NOT NULL, email VARCHAR NOT NULL, password VARCHAR NOT NULL, role TEXT DEFAULT 'user', must_change_password BOOLEAN DEFAULT FALSE, created_at TIMESTAMPTZ DEFAULT NOW());\n";
$sql .= "CREATE TABLE user_permissions (id SERIAL PRIMARY KEY, user_id INTEGER NOT NULL, resource VARCHAR NOT NULL, can_list BOOLEAN DEFAULT FALSE, can_create BOOLEAN DEFAULT FALSE, can_read BOOLEAN DEFAULT FALSE, can_update BOOLEAN DEFAULT FALSE, can_delete BOOLEAN DEFAULT FALSE);\n";
$sql .= "CREATE TABLE work_suppliers (id SERIAL PRIMARY KEY, work_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, created_at TIMESTAMPTZ DEFAULT NOW());\n\n";

function jsonToSql($tableName, $rawContent)
{
    if (!$rawContent)
        return "";

    // Tentar encontrar o JSON dentro da string
    $start = strpos($rawContent, '[');
    $end = strrpos($rawContent, ']');

    if ($start === false || $end === false) {
        // Talvez seja uma string JSON-encoded que precisa ser decodificada primeiro
        $decoded = json_decode($rawContent, true);
        if (is_string($decoded)) {
            $start = strpos($decoded, '[');
            $end = strrpos($decoded, ']');
            if ($start !== false && $end !== false) {
                $rawContent = substr($decoded, $start, $end - $start + 1);
            }
        } else {
            return "-- Erro: Marcadores JSON não encontrados para $tableName\n";
        }
    } else {
        $rawContent = substr($rawContent, $start, $end - $start + 1);
    }

    // Limpar escapes se for uma string JSON vinda do view_file literal
    $rawContent = stripslashes($rawContent);
    // Mas stripslashes pode quebrar JSON. Vamos tentar json_decode direto.

    $data = json_decode($rawContent, true);
    if (!is_array($data)) {
        // Tentar sanitizar: remover aspas iniciais/finais se for string JSON
        $sanitized = trim($rawContent, '"');
        $sanitized = str_replace('\\"', '"', $sanitized);
        $data = json_decode($sanitized, true);

        if (!is_array($data)) {
            return "-- Erro ao decodificar JSON para $tableName ($rawContent)\n";
        }
    }

    $inserts = "";
    foreach ($data as $row) {
        $cols = array_keys($row);
        $vals = array_map(function ($v) {
            if ($v === null)
                return "NULL";
            if (is_bool($v))
                return $v ? "TRUE" : "FALSE";
            if (is_numeric($v))
                return $v;
            return "'" . str_replace("'", "''", $v) . "'";
        }, array_values($row));

        $inserts .= "INSERT INTO \"$tableName\" (\"" . implode('", "', $cols) . "\") VALUES (" . implode(", ", $vals) . ");\n";
    }
    return $inserts . "\n";
}

$sql .= "-- Dados: expense_types\n" . jsonToSql('expense_types', '[{"id":1,"name":"Diversos","created_at":"2026-02-09 22:10:02+00"},{"id":2,"name":"Combustível","created_at":"2026-02-09 22:28:59+00"},{"id":3,"name":"Instalação de Rufos","created_at":"2026-02-10 22:33:34+00"},{"id":4,"name":"Areia","created_at":"2026-02-10 22:35:54+00"},{"id":5,"name":"Forro PVC","created_at":"2026-02-15 01:36:58.250585+00"},{"id":6,"name":"Telhas","created_at":"2026-02-15 13:32:06.768359+00"},{"id":7,"name":"Argamassa","created_at":"2026-02-15 16:17:58.611028+00"},{"id":8,"name":"Marmita","created_at":"2026-02-15 16:24:56.78294+00"},{"id":9,"name":"Madeira","created_at":"2026-02-15 16:28:41.578098+00"},{"id":10,"name":"Tinta","created_at":"2026-02-15 17:26:17.198277+00"}]');
$sql .= "-- Dados: suppliers\n" . jsonToSql('suppliers', '[{"id":1,"name":"Construtora silva","phone":"","contact_name":"","contact_phone":"","observations":"Loja de Material de Construção","created_at":"2026-02-09 21:49:25+00"},{"id":2,"name":"Diversos Jerri","phone":"","contact_name":"Jerrie","contact_phone":"","observations":"","created_at":"2026-02-09 22:28:04+00"},{"id":3,"name":"Diversos Nei","phone":"","contact_name":"Nei","contact_phone":"","observations":"","created_at":"2026-02-09 22:29:35+00"},{"id":4,"name":"Alan Calhas","phone":"","contact_name":"Alan","contact_phone":"","observations":"","created_at":"2026-02-10 22:32:52+00"},{"id":5,"name":"Rouge Areia","phone":"","contact_name":"Rouge","contact_phone":"","observations":"","created_at":"2026-02-10 22:35:01+00"},{"id":6,"name":"Perimetral acabamento - Diversos","phone":"","contact_name":"Carol","contact_phone":"","observations":"Loja de Material de Construção","created_at":"2026-02-15 01:33:51.466953+00"},{"id":7,"name":"Pessoal de retroescavadeira","phone":"","contact_name":"Geral","contact_phone":"","observations":"","created_at":"2026-02-15 01:47:45.619849+00"},{"id":8,"name":"Glassfer Vidros","phone":"","contact_name":"Glassfer","contact_phone":"","observations":"Vidraçaria","created_at":"2026-02-15 01:54:37.99236+00"},{"id":9,"name":"Madeireira Santo Antônio","phone":"","contact_name":"Rafael","contact_phone":"","observations":"","created_at":"2026-02-15 13:31:10.652079+00"},{"id":10,"name":"Zacharias Almoço","phone":"","contact_name":"Zacharias","contact_phone":"","observations":"Restaurante - Marmitas","created_at":"2026-02-15 16:09:25.614675+00"},{"id":11,"name":"Digital ID","phone":"","contact_name":"Digital","contact_phone":"","observations":"Impressão","created_at":"2026-02-15 16:12:54.2386+00"},{"id":12,"name":"Tenda Material de Construção","phone":"","contact_name":"Assuero","contact_phone":"","observations":"Material de Construção","created_at":"2026-02-15 16:15:34.84725+00"},{"id":13,"name":"Mega Laje","phone":"","contact_name":"Robson","contact_phone":"","observations":"Areia e Brita","created_at":"2026-02-15 16:58:26.326909+00"},{"id":14,"name":"Casa cor","phone":"","contact_name":"carioca","contact_phone":"","observations":"Tintas","created_at":"2026-02-15 17:25:33.595841+00"},{"id":15,"name":"Eletromix","phone":"","contact_name":"Eletromix","contact_phone":"","observations":"","created_at":"2026-02-15 17:27:39.571979+00"}]');
$sql .= "-- Dados: works\n" . jsonToSql('works', '[{"id":1,"name":"Reforma Escola José de Anchieta","address":"Bairro Várzea Alegre","reference_point":"Várzea Alegre","total_value":"204181.32","start_date":"2025-12-04","end_date_prediction":"2026-02-14","status":"active","created_at":"2026-02-07 18:55:46+00"},{"id":2,"name":"Construção de Quadra Poliesportiva - José de Anchieta","address":"Bairro Várzea Alegre","reference_point":"Escola Municipal José de Anchieta","total_value":"498000.00","start_date":"2026-01-20","end_date_prediction":"2026-07-29","status":"active","created_at":"2026-02-12 15:37:26.350392+00"}]');
$sql .= "-- Dados: revenues\n" . jsonToSql('revenues', '[{"id":2,"work_id":1,"service_id":1,"description":"Recebimento: Revestimento","amount":"40000.00","received_date":"2026-02-08","status":"received","created_at":"2026-02-08 07:36:30+00"},{"id":3,"work_id":1,"service_id":2,"description":"Recebimento: Telhado","amount":"40000.00","received_date":"2026-02-08","status":"received","created_at":"2026-02-08 07:37:10+00"}]');
$sql .= "-- Dados: sub_services\n" . jsonToSql('sub_services', '[{"id":1,"service_id":5,"name":"Instalação de Pia Cozinha","percentage_service":"20.00","value":"4083.63","executed_percentage":"100.00","created_at":"2026-02-07 19:36:22+00"},{"id":2,"service_id":5,"name":"Instalação de Pia - Lava Pano","percentage_service":"15.00","value":"3062.72","executed_percentage":"0.00","created_at":"2026-02-07 19:36:39+00"},{"id":3,"service_id":5,"name":"Revisão de banheiro Masculino e Femino","percentage_service":"40.00","value":"8167.25","executed_percentage":"100.00","created_at":"2026-02-07 19:37:03+00"},{"id":4,"service_id":5,"name":"Revisão Banheiro Administrativo","percentage_service":"15.00","value":"3062.72","executed_percentage":"100.00","created_at":"2026-02-07 19:37:20+00"},{"id":5,"service_id":5,"name":"Instalação de Caixa de Gordura Cozinha","percentage_service":"10.00","value":"2041.81","executed_percentage":"0.00","created_at":"2026-02-07 19:41:09+00"},{"id":6,"service_id":6,"name":"Calçada frente escola","percentage_service":"30.00","value":"6125.44","executed_percentage":"55.00","created_at":"2026-02-07 19:49:36+00"},{"id":7,"service_id":6,"name":"Calçada fundo Escola","percentage_service":"30.00","value":"6125.44","executed_percentage":"60.00","created_at":"2026-02-07 19:49:52+00"},{"id":8,"service_id":6,"name":"Instalação de Grelha Pátio","percentage_service":"20.00","value":"4083.63","executed_percentage":"100.00","created_at":"2026-02-07 19:50:29+00"},{"id":9,"service_id":6,"name":"Instalação de serviços diversos","percentage_service":"20.00","value":"4083.63","executed_percentage":"17.50","created_at":"2026-02-07 19:51:13+00"}]');
$sql .= "-- Dados: users\n" . jsonToSql('users', '[{"id":1,"name":"Administrador","email":"avanteservico@gmail.com","password":"$2y$10$gXQcJI1rBayWKLr5g9.dd.bOeWTwaXFLPxOIeXcWv/eVamYdrQqyi","role":"admin","must_change_password":false,"created_at":"2026-02-07 17:34:54+00"},{"id":2,"name":"Neris Farias","email":"nerisfarias@gmail.com","password":"$2y$10$Btasy3bFD6yAhgBNjT.dEOZ6rOCeonlH5df3ISIjAXTcUt4lnq0NW","role":"user","must_change_password":false,"created_at":"2026-02-07 22:19:59+00"},{"id":3,"name":"Ingrid Docilio","email":"dociliofarias@gmail.com","password":"$2y$10$f3325LYdfnb5ujhq43szh.oeei4W0oEicZvJjRXB44G4SPAcD9Kaa","role":"user","must_change_password":true,"created_at":"2026-02-08 15:52:58+00"}]');
$sql .= "-- Dados: work_suppliers\n" . jsonToSql('work_suppliers', '[{"id":1,"work_id":1,"supplier_id":1,"created_at":"2026-02-09 22:06:17+00"},{"id":2,"work_id":1,"supplier_id":4,"created_at":"2026-02-10 22:48:59+00"}]');

foreach ($dataFiles as $table => $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $sql .= "-- Dados extraídos para $table via arquivo\n";
        $sql .= jsonToSql($table, $content);
    }
}

foreach ($tables as $table) {
    $sql .= "SELECT setval(pg_get_serial_sequence('\"$table\"', 'id'), (SELECT MAX(id) FROM \"$table\"));\n";
}

file_put_contents($filepath, $sql);
echo "Backup finalizado: $filename\n";
