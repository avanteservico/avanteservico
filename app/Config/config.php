<?php

// Configurações do Banco de Dados
define('DB_HOST', getenv('DB_HOST') ?: 'db.rybcmhwcafpzwroyduwz.supabase.co');
define('DB_NAME', getenv('DB_NAME') ?: 'postgres');
define('DB_USER', getenv('DB_USER') ?: 'postgres');
define('DB_PASS', getenv('DB_PASS') ?: 'avante_servico_2026'); // Definido como padrão para facilitar
define('DB_PORT', getenv('DB_PORT') ?: '5432');

// URL Base da Aplicação
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/avante_servico');

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
    session_start();
}
