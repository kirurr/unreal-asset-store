<?php

namespace UseCases\User;

use DomainException;
use Exception;
use Repositories\User\UserRepositoryInterface;
use RuntimeException;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Review\GetReviewsByUserIdUseCase;

class DeleteUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private GetAllAssetUseCase $getAllAssetUseCase,
        private GetReviewsByUserIdUseCase $getReviewsByUserIdUseCase,
    ) {}

    public function execute(int $id): void
    {
        try {
            $assets = $this->getAllAssetUseCase->execute(user_id: $id);
            if (!empty($assets)) {
                throw new DomainException('User has assets');
            }
            $reviews = $this->getReviewsByUserIdUseCase->execute($id);
            if (!empty($reviews)) {
                throw new DomainException('User has reviews');
            }

            $user = $this->repository->getById($id);
            if (!$user) {
                throw new DomainException('User not found');
            }
            if ($user->role === 'admin') {
                throw new DomainException('Admin cannot be deleted');
            }
            $this->repository->delete($user);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete user: ' . $e->getMessage(), 500, $e);
        }
    }
}
