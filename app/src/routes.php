<?php

use Utils\DIContainer;

$router->get("/", function (DIContainer $container) {
	$variable = 1;

	$container->get('TestController')->get($variable);
});

$router->get("/about", function () {
	echo 'pisi';
});

$router->get("/{id}", function (DIContainer $container, $params) {
	var_dump($params);
});
