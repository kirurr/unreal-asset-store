<?php

use Controllers\AuthController;
use Controllers\MainPageController;
use Controllers\TestController;
use Core\ServiceContainer;
use Repositories\User\SQLiteUserRepository;
use Repositories\SQLiteTestRepository;
use UseCases\User\SignInUserUseCase;
use UseCases\User\SignOutUserUseCase;
use UseCases\User\SignUpUserUseCase;
use UseCases\GetTestUseCase;

$container = new ServiceContainer();

try {
    $container->set('PDO', function (ServiceContainer $container) {
        $dbPath = '/var/www/storage/test.db';
        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    });
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

$container->set('SQLiteTestRepository', function (ServiceContainer $container) {
    return new SQLiteTestRepository($container->get('PDO'));
});

$container->set('GetTestUseCase', function (ServiceContainer $container) {
    return new GetTestUseCase($container->get('SQLiteTestRepository'));
});

$container->set('TestController', function (ServiceContainer $container) {
    return new TestController($container->get('GetTestUseCase'));
});

$container->set('MainPageController', function () {
    return new MainPageController();
});

$container->set('SQLiteUserRepository', function (ServiceContainer $container) {
    return new SQLiteUserRepository($container->get('PDO'));
});

$container->set('SignInUserUseCase', function (ServiceContainer $container) {
    return new SignInUserUseCase($container->get('SQLiteUserRepository'));
});

$container->set('SignUpUserUseCase', function (ServiceContainer $container) {
    return new SignUpUserUseCase($container->get('SQLiteUserRepository'));
});

$container->set('SignOutUserUseCase', function (ServiceContainer $container) {
    return new SignOutUserUseCase($container->get('SQLiteUserRepository'));
});

$container->set('AuthController', function (ServiceContainer $container) {
    return new AuthController(
        $container->get('SignInUserUseCase'),
        $container->get('SignUpUserUseCase'),
        $container->get('SignOutUserUseCase')
    );
});

return $container;
