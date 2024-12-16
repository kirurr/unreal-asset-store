<?php

namespace Entities;

class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        private string $password,
        public string $role
    ) {}

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

	public function updatePassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
	
	public function getPassword(): string
	{
		return $this->password;
	}
}
