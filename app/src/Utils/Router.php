<?php

namespace Utils;

class Router
{
	public function __construct(private DIContainer $container) {}
	private $routes = [];
	public function get(string $uri, callable $cb): void
	{
		$this->set($uri, $cb, "GET");
	}

	public function route(string $uri, string $method)
	{
		foreach ($this->routes as $route) {
			if (
				$route['uri'] === $uri
				&& $route['method'] === strtoupper($method)
			) {
				$route['cb']($this->container);
			} else {
				echo 'error finding controller' . PHP_EOL;
				die();
			}
		}
	}

	private function set(string $uri, callable $cb, string $method): void
	{
		$this->routes[] = [
			'uri' => $uri,
			'cb' => $cb,
			'method' => $method
		];
	}
}
