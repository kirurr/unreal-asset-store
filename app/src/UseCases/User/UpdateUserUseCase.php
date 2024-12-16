<?php

namespace UseCases\User;

use DomainException;
use Exception;
use Repositories\User\UserRepositoryInterface;
use RuntimeException;

class UpdateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(int $id, string $name = null, string $email = null, string $role = null, string $password = null): void
    {
        try {
            $user = $this->repository->getById($id);
            if (!$user) {
                throw new DomainException('User not found');
            }
            $user->name = $name ?? $user->name;
            $user->email = $email ?? $user->email;
            $user->role = $role ?? $user->role;
			if ($password) {
				$user->updatePassword($password);
			}
        
            $this->repository->update($user);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to update user: ' . $e->getMessage(), 500, $e);
        }
    }
}


