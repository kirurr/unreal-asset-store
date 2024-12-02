<?php

namespace UseCases\User;

use Repositories\User\UserRepositoryInterface;

class SignInUserUseCase 
{
	public function __construct(private UserRepositoryInterface $repository) {}

	public function execute(string $email, string $password): mixed
	{
		return $this->repository->authorize($email, $password);
	}
}
