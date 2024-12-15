<?php

use Core\Dependencies\Admin\AssetContainer;
use Core\Dependencies\Admin\CategoryContainer;
use Core\Dependencies\AuthorizationContainer;
use Core\Dependencies\IndexContainer;
use Core\Dependencies\UserContainer;
use Core\ServiceContainer;

$container = new ServiceContainer();

(new IndexContainer())->initDependencies();

(new UserContainer())->initDependencies();

(new AuthorizationContainer())->initDependencies();

(new AssetContainer())->initDependencies();
(new CategoryContainer())->initDependencies();

return $container;
