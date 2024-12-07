<?php

use Core\Dependencies\AdminContainer;
use Core\Dependencies\AuthorizationContainer;
use Core\Dependencies\IndexContainer;
use Core\Dependencies\UserContainer;
use Core\ServiceContainer;

$container = new ServiceContainer();

$index = new IndexContainer();
$index->initDependencies();

$user = new UserContainer();
$user->initDependencies();

$authorization = new AuthorizationContainer();
$authorization->initDependencies();

(new AdminContainer())->initDependencies();

return $container;
