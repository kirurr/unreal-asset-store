<?php

namespace Core;

use Exception;

interface ContainerInterface
{
    public function set(string $key, callable $factory): void;
    public static function get(string $key): mixed;
    public function initDependencies(): void;
}

class ServiceContainer
{
    protected static array $definitions = [];

    public function set(string $key, callable $factory): void
    {
        static::$definitions[$key] = $factory;
    }

    public static function get(string $key): mixed
    {
        if (!isset(static::$definitions[$key])) {
            throw new Exception("No definition found for {$key}");
        }
        return static::$definitions[$key]();
    }
}
