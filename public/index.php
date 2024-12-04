<?php
const BASE_PATH = __DIR__ . '/../html/';

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'src/functions.php';

session_start();

use Router\Routes\MainRoutes;
use Router\Router;

$container = require BASE_PATH . 'src/dependencies.php';

$router = new Router($container);

$routes = new MainRoutes($router);
$routes->defineRoutes();

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
