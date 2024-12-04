<?php

namespace Router;

use Core\ServiceContainer;

class Router
{
    public function __construct(
        private ServiceContainer $container
    ) {}

    private $routes = [];

    public function get(string $uri, callable $cb): void
    {
        $this->add($uri, $cb, 'GET');
    }

    public function post(string $uri, callable $cb): void
    {
        $this->add($uri, $cb, 'POST');
    }

    public function put(string $uri, callable $cb)
    {
        $this->add($uri, $cb, 'PUT');
    }

    public function patch(string $uri, callable $cb)
    {
        $this->add($uri, $cb, 'PATCH');
    }

    public function delete(string $uri, callable $cb)
    {
        $this->add($uri, $cb, 'DELETE');
    }

    public function route(string $uri, string $method)
    {
        [$handler, $params] = $this->matchRoute($uri, $method);

        if ($handler) {
            $handler($this->container, $params);
        } else {
            http_response_code(404);
            echo 'error finding controller' . PHP_EOL;
        }
    }

    private function matchRoute(string $uri, string $method): mixed
    {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
                $params = [];

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }

                return [$route['cb'], $params];
            }
        }
        return [null, null];
    }

    private function add(string $uri, callable $cb, string $method): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'cb' => $cb,
            'method' => $method
        ];
    }
}
