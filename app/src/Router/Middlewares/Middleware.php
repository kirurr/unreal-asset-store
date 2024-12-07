<?php

namespace Router\Middlewares;

abstract class Middleware
{
    public function __construct(
        private string $name
    ) {}

    abstract public function __invoke(): void;
}
