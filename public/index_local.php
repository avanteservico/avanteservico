<?php

require_once '../app/Config/config.php';
require_once '../app/Config/Database.php';

// Autoload simples
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

// Roteamento Básico
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'login';
$url = explode('/', $url);

$controllerUri = $url[0];
$method = isset($url[1]) ? $url[1] : 'index';

// Converter metod-com-hifen para camelCase (ex: change-password -> changePassword)
if (isset($url[1]) && strpos($url[1], '-') !== false) {
    $method = str_replace('-', '', ucwords($url[1], '-'));
    $method = lcfirst($method);
}

$params = array_slice($url, 2);

// Mapa de Rotas (Plural URL -> Singular Controller)
$routes = [
    'dashboard' => 'DashboardController',
    'auth' => 'AuthController',
    'login' => 'AuthController', // Atalho
    'users' => 'UserController',
    'works' => 'WorkController',
    'tasks' => 'TaskController',
    'people' => 'PersonController',
    'services' => 'ServiceController',
    'materials' => 'MaterialController',
    'revenues' => 'RevenueController',
    'sub_services' => 'ServiceController', // Talvez precise de controller próprio ou não
    'setup' => 'AuthController', // Opcional
    'financial' => 'FinancialController',
    'suppliers' => 'SupplierController',
    'additives' => 'AdditiveController'
];

// Determinar o nome do Controller
if (array_key_exists($controllerUri, $routes)) {
    $controllerName = $routes[$controllerUri];
} else {
    // Tenta convenção padrão: Primeira letra maiúscula + Controller
    $controllerName = ucfirst($controllerUri) . 'Controller';
}

if (file_exists('../app/Controllers/' . $controllerName . '.php')) {
    $controller = new $controllerName;
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        // Método não encontrado - Fallback para 'index' se não houver segundo parâmetro, ou 404
        // Mas a lógica acima já define $method.
        echo "Erro 404: Método '$method' não encontrado no controller '$controllerName'.";
    }
} else {
    // Controller não encontrado
    if ($controllerUri == 'login') {
        require_once '../app/Controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
    } else {
        echo "Erro 404: Controller '$controllerName' não encontrado. Verifique a URL.";
    }
}
