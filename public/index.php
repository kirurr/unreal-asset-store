<?php
require __DIR__ . "/../vendor/autoload.php";

use Utils\Router;

$container = require __DIR__ . "/../src/Utils/dependencies.php";

$router = new Router($container);

$routes = require __DIR__ . "/../src/Utils/routes.php";

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
