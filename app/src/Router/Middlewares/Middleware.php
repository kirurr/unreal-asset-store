<?php

namespace Router\Middlewares;

use Core\Errors\Error;

abstract class Middleware
{
    public function __construct(
        private string $name
    ) {}

    abstract public function __invoke(): ?Error;
}
