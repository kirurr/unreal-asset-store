<?php

use Router\Routes\AdminRoutes;
use Router\Routes\AuthRoutes;
use Router\Routes\MainRoutes;
use Router\Router;

$router = new Router();

(new MainRoutes($router))->defineRoutes();
(new AuthRoutes($router))->defineRoutes();
(new AdminRoutes($router))->defineRoutes('/admin');

return $router;
