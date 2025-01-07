<?php

namespace Router\Middlewares;

abstract class Middleware
{
    /**
     * @param array<string,mixed> $slug
     */
    abstract public function __invoke(array $slug): void;
}
