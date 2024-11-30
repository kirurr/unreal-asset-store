<?php

namespace Utils;

use Exception;

class DIContainer
{
	private array $definitions = [];

	public function set(string $key, callable $factory): void
	{
		$this->definitions[$key] = $factory;
	}

	public function get(string $key)
	{
		if (!isset($this->definitions[$key])) {
			throw new Exception("No definition found for {$key}");
		}
		return $this->definitions[$key]($this);
	}
}
