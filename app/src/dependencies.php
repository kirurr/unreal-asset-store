<?php

use Core\Dependencies\AssetContainer;
use Core\Dependencies\CategoryContainer;
use Core\Dependencies\AuthorizationContainer;
use Core\Dependencies\IndexContainer;
use Core\Dependencies\UserContainer;
use Core\Dependencies\ProfileContainer;
use Core\ServiceContainer;

$container = new ServiceContainer();

(new IndexContainer())->initDependencies();

(new UserContainer())->initDependencies();

(new AuthorizationContainer())->initDependencies();

(new AssetContainer())->initDependencies();
(new CategoryContainer())->initDependencies();
(new UserContainer())->initDependencies();

(new ProfileContainer())->initDependencies();

return $container;
