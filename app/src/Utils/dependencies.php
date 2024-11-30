<?php

use Utils\DIContainer;
use Controllers\TestController;
use Repositories\SQLiteTestRepository;
use UseCases\GetTestUseCase;

$container = new DIContainer();

try {
	$container->set('PDO', function (DIContainer $container) {
		$dbPath = '/var/www/storage/test.db';
		$pdo = new PDO('sqlite:' . $dbPath);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	});
} catch (Exception $e) {
	echo $e->getMessage();
	die();
}

$container->set('SQLiteTestRepository', function (DIContainer $container) {
	return new SQLiteTestRepository($container->get('PDO'));
});

$container->set('GetTestUseCase', function (DIContainer $container) {
	return new GetTestUseCase($container->get('SQLiteTestRepository'));
});

$container->set('TestController', function (DIContainer $container) {
	return new TestController($container->get('GetTestUseCase'));
});

return $container;
