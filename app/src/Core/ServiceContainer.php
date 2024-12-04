<?php

namespace Core;

use Exception;

interface ContainerInterface
{
    public function set(string $key, callable $factory): void;
    public function get(string $key): mixed;
    public function initDependencies(): void;
}

class Container
{
    protected static array $definitions = [];
}

class ServiceContainer extends Container
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function set(string $key, callable $factory): void
    {
        parent::$definitions[$key] = $factory;
    }

    public function get(string $key): mixed
    {
        if (!isset(parent::$definitions[$key])) {
            throw new Exception("No definition found for {$key}");
        }
        return parent::$definitions[$key]($this);
    }
}
