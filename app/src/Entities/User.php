<?php

namespace Entities;

class User
{
	public function __construct(private int $id, private string $name, private string $email, private string $password) {}

	/**
	 * @return array<string, mixed>
	 */
	public function get(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
		];
	}
	public function checkPassword(string $password): bool
	{
		return password_verify($password, $this->password);
	}
}
