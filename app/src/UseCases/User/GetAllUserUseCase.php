<?php

namespace UseCases\User;

use Entities\User;
use Exception;
use Repositories\User\UserRepositoryInterface;
use RuntimeException;

class GetAllUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    /**
     * @return User[]
     */
    public function execute(): array
    {
        try {
            return $this->repository->getAll();
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get users: ' . $e->getMessage(), 500, $e);
        }
    }
}
