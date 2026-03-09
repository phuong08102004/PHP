<?php
// admin/index.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';


use App\Router;


$router = new Router();

require __DIR__ . '/src/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$projectName = '/honeybee';
if (strpos($uri, $projectName) === 0) {
    $uri = substr($uri, strlen($projectName));
}

if ($uri !== '/') {
    $uri = rtrim($uri, '/');
}

if (empty($uri)) $uri = '/admin';

try {
    
    if (method_exists($router, 'dispatch')) {
        $router->dispatch($uri);
    } else {
        $router->match($uri);
    }
} catch (Exception $e) {
    http_response_code(404);
    echo "<h3>Lỗi Hệ Thống</h3>";
    echo "URI nhận được: <b>" . htmlspecialchars($uri) . "</b><br>";
    echo "Thông báo: " . $e->getMessage();
}