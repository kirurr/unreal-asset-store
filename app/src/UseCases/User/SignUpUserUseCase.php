<?php

namespace UseCases\User;

use Repositories\User\UserRepositoryInterface;

class SignUpUserUseCase
{
	public function __construct(private UserRepositoryInterface $repository) {}

	public function execute(string $name, string $email, string $password): mixed
	{
		return $this->repository->create($name, $email, $password);

	}
}
