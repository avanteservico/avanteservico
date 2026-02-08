<?php
// Script de Instalação Rápida (Executa o seed)
require_once '../app/Config/config.php';
require_once '../app/Config/Database.php';

// Autoload simples (repetido do index, idealmente extrair para bootstrap.php)
spl_autoload_register(function ($class_name) {
    $directories = [
        '../app/Controllers/',
        '../app/Models/',
        '../app/Helpers/',
        '../app/Config/'
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once '../app/Controllers/AuthController.php';

$auth = new AuthController();
$auth->seed();
