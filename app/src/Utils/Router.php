<?php

namespace Utils;

class Router
{
	public function __construct(private DIContainer $container) {}
	private $routes = [];

	public function get(string $uri, callable $cb): void
	{
		$this->add($uri, $cb, "GET");
	}
	public function post(string $uri, callable $cb): void
	{
		$this->add($uri, $cb, "POST");
	}

	public function put(string $uri, callable $cb)
	{
		$this->add($uri, $cb, "PUT");
	}

	public function patch(string $uri, callable $cb)
	{
		$this->add($uri, $cb, "PATCH");
	}

	public function delete(string $uri, callable $cb)
	{
		$this->add($uri, $cb, "DELETE");
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

	private function add(string $uri, callable $cb, string $method): void
	{
		$this->routes[] = [
			'uri' => $uri,
			'cb' => $cb,
			'method' => $method
		];
	}
}
