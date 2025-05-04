<?php

// Подключаем конфигурацию базы данных
$pdo = require_once __DIR__.'/config/database.php';

// Включаем отображение ошибок только в режиме разработки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Получаем путь запроса
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

// Удаляем начальный слеш и разбиваем путь на части
$path = trim($path, '/');
$pathParts = explode('/', $path);

// Карта маршрутов
$map = [
    'products' => 'ProductController',
    'orders' => 'OrderController',
    'users' => 'UserController',
    'auth' => 'AuthController',
    // ... другие маршруты
];

$key = strtolower($pathParts[0] ?? '');
$controllerName = isset($map[$key]) ? $map[$key] : 'ProductController';
$action = $pathParts[1] ?? 'list';

// Подключаем контроллер
$controllerFile = __DIR__ . "/controllers/{$controllerName}.php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName($pdo);
    $controller->handleRequest();
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Страница не найдена";
}

var_dump($controllerName, $controllerFile, file_exists($controllerFile));
exit;

