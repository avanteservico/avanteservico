<?php

require_once __DIR__ . '/../app/Config/config.php';
require_once __DIR__ . '/../app/Config/Database.php';

// Autoload simples
spl_autoload_register(function ($class_name) {
    $directories = [
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Helpers/',
        __DIR__ . '/../app/Config/'
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Suporte para Vercel: Pega a URL do REQUEST_URI ou do parâmetro 'url'
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_param = isset($_GET['url']) ? $_GET['url'] : '';

// Limpa a URL (remove barra inicial e final)
$path = $url_param ?: ltrim($request_uri, '/');
$path = rtrim($path, '/');

// Se estiver vazio, vai para o login
if (empty($path)) {
    $path = 'login';
}

$url = explode('/', $path);

$controllerUri = $url[0];
$method = isset($url[1]) ? $url[1] : 'index';

// Converter metod-com-hifen para camelCase
if (isset($url[1]) && strpos($url[1], '-') !== false) {
    $method = str_replace('-', '', ucwords($url[1], '-'));
    $method = lcfirst($method);
}

$params = array_slice($url, 2);

// Mapa de Rotas
$routes = [
    'dashboard' => 'DashboardController',
    'auth' => 'AuthController',
    'login' => 'AuthController',
    'users' => 'UserController',
    'works' => 'WorkController',
    'tasks' => 'TaskController',
    'people' => 'PersonController',
    'services' => 'ServiceController',
    'materials' => 'MaterialController',
    'revenues' => 'RevenueController',
    'sub_services' => 'ServiceController',
    'financial' => 'FinancialController',
    'suppliers' => 'SupplierController'
];

// Determinar o nome do Controller
if (array_key_exists($controllerUri, $routes)) {
    $controllerName = $routes[$controllerUri];
} else {
    $controllerName = ucfirst($controllerUri) . 'Controller';
}

if (file_exists(__DIR__ . '/../app/Controllers/' . $controllerName . '.php')) {
    $controller = new $controllerName;
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        echo "Erro 404: Método '$method' não encontrado no controller '$controllerName'.";
    }
} else {
    if ($controllerUri == 'login') {
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
    } else {
        echo "Erro 404: Controller '$controllerName' não encontrado. Caminho: /$path";
    }
}
