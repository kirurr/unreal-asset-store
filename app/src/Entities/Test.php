<?php

namespace Entities;

class Test
{
	public function __construct(private int $id, private string $text) {}

	public function getId(): int
	{
		return $this->id;
	}
	public function getText(): string
	{
		return $this->text;
	}
}
