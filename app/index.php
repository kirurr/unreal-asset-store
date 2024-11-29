<?php
require __DIR__ . "/vendor/autoload.php";

use Database\SQLiteTestDatabase;
use UseCases\GetTestUseCase;
use Controllers\TestController;


try {
	$dbPath = '/var/www/storage/test.db';
	$pdo = new PDO('sqlite:' . $dbPath);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	echo $e->getMessage();
	die();
}

$repository = new SQLiteTestDatabase($pdo);
$getTestUseCase = new GetTestUseCase($repository);
$controller = new TestController($getTestUseCase);

echo $controller->get(1);
