<?php

namespace UseCases\User;

use DomainException;
use Entities\User;
use Exception;
use Repositories\User\UserRepositoryInterface;
use RuntimeException;

class GetUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(int $id): User
    {
        try {
            $user = $this->userRepository->getById($id);
            if ($user === null) {
                throw new DomainException('User not found');
            }
            return $user;
        } catch (RuntimeException$e) {
            throw new Exception('failed to get user: ' . $e->getMessage(), 500, $e);
        }
    }
}    
