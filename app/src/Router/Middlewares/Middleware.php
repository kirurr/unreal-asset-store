<?php

namespace Router\Middlewares;

abstract class Middleware
{
    public function __construct(
        private string $name
    ) {}
    /**
     * @param array<string,mixed> $slug
     */
    abstract public function __invoke(array $slug): void;
}
