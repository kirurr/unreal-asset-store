<?php
const BASE_PATH = __DIR__ . '/../html/';

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'src/functions.php';

session_start();

use Core\Router;
use Core\Routes\MainRoutes;

$container = require BASE_PATH . 'src/dependencies.php';

$router = new Router($container);

$routes = new MainRoutes($router);
$routes->defineRoutes();

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
