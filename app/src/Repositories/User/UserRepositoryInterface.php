<?php

namespace Repositories\User;

use Entities\User;

interface UserRepositoryInterface
{
	public function getById(int $id): ?User;
	public function getByEmail(string $email): ?User;
	public function authorize(string $email, string $password): mixed;
	public function create(string $name, string $email, string $password): mixed;
}
