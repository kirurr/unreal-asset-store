<?php
session_start();
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new Exception($errstr, $errno);
}, E_ALL);

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
} catch (DomainException $e) {
    http_response_code(404);
    redirect('/');
} catch (Throwable $e) {
    // renderView('error', ['error' => $e->getMessage()]);
    renderView('error', ['error' => "500 Internal Server Error"]);
    // throw $e;
}
restore_error_handler();
