<?php

use Utils\DIContainer;

$router->get("/", function (DIContainer $container) {
	$variable = 1;

	$container->get('TestController')->get($variable);
});
