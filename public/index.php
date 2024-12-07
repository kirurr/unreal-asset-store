<?php
const BASE_PATH = __DIR__ . '/../html/';

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'src/functions.php';

$container = require BASE_PATH . 'src/dependencies.php';

$router = require BASE_PATH . 'src/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
if (substr($uri, -1) !== '/') {
    $uri .= '/';
}
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
