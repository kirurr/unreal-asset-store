<?php

namespace Core;

use Exception;

class ServiceContainer
{
	private array $definitions = [];

	public function set(string $key, callable $factory): void
	{
		$this->definitions[$key] = $factory;
	}

	public function get(string $key): mixed
	{
		if (!isset($this->definitions[$key])) {
			throw new Exception("No definition found for {$key}");
		}
		return $this->definitions[$key]($this);
	}
}
