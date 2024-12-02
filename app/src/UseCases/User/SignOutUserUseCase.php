<?php

namespace UseCases\User;

use Repositories\User\UserRepositoryInterface;

class SignOutUserUseCase
{
	public function __construct(private UserRepositoryInterface $repository) {}

	public function execute(): void { }
}
