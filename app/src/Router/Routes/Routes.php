<?php

namespace Router\Routes;

use Exception;
use Router\Router;

interface RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void;
}

abstract class Routes
{
    public function __construct(
        protected Router $router
    ) {
    }

    protected function handleException(Exception $e): void
    {
        http_response_code(500);
        renderView('error', ['error' => $e->getMessage()]);
    }
}
