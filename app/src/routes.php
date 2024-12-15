<?php

use Router\Routes\Admin\AssetsRoutes;
use Router\Routes\Admin\CategoriesRoutes;
use Router\Routes\Admin\MainAdminRoutes;
use Router\Routes\AuthRoutes;
use Router\Routes\MainRoutes;
use Router\Router;

$router = new Router();

(new MainRoutes($router))->defineRoutes();
(new AuthRoutes($router))->defineRoutes();
(new MainAdminRoutes($router))->defineRoutes('/admin');
(new CategoriesRoutes($router))->defineRoutes('/admin/categories');
(new AssetsRoutes($router))->defineRoutes('/admin/assets');

return $router;
