<?php

namespace Router\Routes;
use Router\Router;

$router = new Router();

(new MainRoutes($router))->defineRoutes();
(new AuthRoutes($router))->defineRoutes();
(new Admin\MainAdminRoutes($router))->defineRoutes('/admin');
(new Admin\CategoriesRoutes($router))->defineRoutes('/admin/categories');
(new Admin\AssetsRoutes($router))->defineRoutes('/admin/assets');
(new Admin\UserRoutes($router))->defineRoutes('/admin/users');

(new Profile\MainProfileRoutes($router))->defineRoutes('/profile');
(new Profile\AssetsRoutes($router))->defineRoutes('/profile/assets');


return $router;
