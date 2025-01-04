<?php

use Core\Dependencies\AssetContainer;
use Core\Dependencies\CategoryContainer;
use Core\Dependencies\AuthorizationContainer;
use Core\Dependencies\IndexContainer;
use Core\Dependencies\PurchaseContainer;
use Core\Dependencies\RepositoryContainer;
use Core\Dependencies\ReviewContainer;
use Core\Dependencies\UserContainer;
use Core\Dependencies\ProfileContainer;
use Core\Dependencies\ImageContainer;
use Core\Dependencies\FileContainer;
use Core\ServiceContainer;

$container = new ServiceContainer();

(new IndexContainer())->initDependencies();
(new RepositoryContainer())->initDependencies();

(new UserContainer())->initDependencies();

(new AuthorizationContainer())->initDependencies();

(new AssetContainer())->initDependencies();
(new ImageContainer())->initDependencies();
(new FileContainer())->initDependencies();
(new CategoryContainer())->initDependencies();
(new UserContainer())->initDependencies();
(new PurchaseContainer())->initDependencies();
(new ReviewContainer())->initDependencies();

(new ProfileContainer())->initDependencies();

return $container;
