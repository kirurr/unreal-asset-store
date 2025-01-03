<?php

namespace Router;

use Core\Errors\Error;
use Core\Errors\MiddlewareException;
use Router\Middlewares\Middleware;
use DomainException;

class Router
{
    private $routes = [];

    /**
     * @param callable(): mixed $cb
     * @param array<Middleware> $middlewares
     */
    public function get(string $uri, callable $cb, array $middlewares = []): void
    {
        $this->add($uri, $cb, 'GET', $middlewares);
    }

    /**
     * @param callable(): mixed $cb
     * @param array<Middleware> $middlewares
     */
    public function post(string $uri, callable $cb, array $middlewares = []): void
    {
        $this->add($uri, $cb, 'POST', $middlewares);
    }

    /**
     * @param callable(): mixed $cb
     * @param array<Middleware> $middlewares
     */
    public function put(string $uri, callable $cb, array $middlewares = []): void
    {
        $this->add($uri, $cb, 'PUT', $middlewares);
    }

    /**
     * @param callable(): mixed $cb
     * @param array<Middleware> $middlewares
     */
    public function patch(string $uri, callable $cb, array $middlewares = []): void
    {
        $this->add($uri, $cb, 'PATCH', $middlewares);
    }

    /**
     * @param callable(): mixed $cb
     * @param array<Middleware> $middlewares
     */
    public function delete(string $uri, callable $cb, array $middlewares = []): void
    {
        $this->add($uri, $cb, 'DELETE', $middlewares);
    }

    public function route(string $uri, string $method): void
    {
        [$route, $slug] = $this->matchRoute($uri, $method);

        if ($route) {
            $middlewareError = null;
            try {
                $this->handleMiddlewares($slug, ...$route['middlewares']);
            } catch (MiddlewareException $e) {
                $middlewareError = $e;
            }
            $route['cb']($slug, $middlewareError);
        } else {
            throw new DomainException('Error finding controller for uri: ' . $uri);
        }
    }

    private function handleMiddlewares(array $slug, Middleware ...$middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $result = $middleware($slug);
        }
    }

    private function matchRoute(string $uri, string $method): mixed
    {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
                $slug = [];

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $slug[$key] = $value;
                    }
                }

                return [$route, $slug];
            }
        }
        return [null, null];
    }

    /**
     * @param callable(): mixed $cb
     * @param array<Middleware> $middlewares
     */
    private function add(string $uri, callable $cb, string $method, array $middlewares = []): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'cb' => $cb,
            'method' => $method,
            'middlewares' => $middlewares
        ];
    }
}
