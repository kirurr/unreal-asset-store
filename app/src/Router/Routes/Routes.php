<?php

namespace Router\Routes;

use Router\Router;

interface RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void;
}

abstract class Routes
{
    public function __construct(
        protected Router $router
    ) {}
}
