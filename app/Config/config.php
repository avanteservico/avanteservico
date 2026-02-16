<?php

// Configurações do Banco de Dados
define('DB_HOST', getenv('DB_HOST') ?: 'db.rybcmhwcafpzwroyduwz.supabase.co');
define('DB_NAME', getenv('DB_NAME') ?: 'postgres');
define('DB_USER', getenv('DB_USER') ?: 'postgres');
define('DB_PASS', getenv('DB_PASS') ?: 'avante_servico_2026'); // Definido como padrão para facilitar
define('DB_PORT', getenv('DB_PORT') ?: '5432');
define('DB_PROJECT_REF', getenv('DB_PROJECT_REF') ?: 'rybcmhwcafpzwroyduwz'); // Extraído do host padrão

// URL Base da Aplicação
// URL Base da Aplicação (Detecção Dinâmica)
if (!defined('BASE_URL')) {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $defaultBase = ($host === 'localhost') ? 'http://localhost/avante_servico' : "$protocol://$host";
    define('BASE_URL', getenv('BASE_URL') ?: $defaultBase);
}

// Ambiente (development, production)
define('APP_ENV', getenv('APP_ENV') ?: 'development');

// Configurações de Sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Mude para 1 em produção com HTTPS

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Exibir erros apenas em desenvolvimento
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Iniciar sessão se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    // Carregar dependências necessárias para o manipulador de sessão
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/../Helpers/SessionHelper.php';

    try {
        $handler = new DatabaseSessionHandler();
        session_set_save_handler($handler, true);
        session_start();
    } catch (Exception $e) {
        // Fallback para sessão padrão em caso de erro no banco
        session_start();
    }
}
