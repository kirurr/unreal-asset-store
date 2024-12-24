<?php

namespace Controllers;

use UseCases\Asset\GetAllAssetUseCase;
use UseCases\User\DeleteUserUseCase;
use UseCases\User\GetAllUserUseCase;
use UseCases\User\GetUserUseCase;
use UseCases\User\UpdateUserUseCase;

class UserController
{
    public function __construct(
        private GetAllUserUseCase $getAllUseCase,
        private GetUserUseCase $getUserUseCase,
        private UpdateUserUseCase $updateUserUseCase,
        private DeleteUserUseCase $deleteUserUseCase,
        private GetAllAssetUseCase $getAllAssetUseCase
    ) {
    }

    /**
     * @return array{ users: User[] }
     */
    public function getUsersPageData(): array
    {
            return ['users' => $this->getAllUseCase->execute()];
    }

    /**
     * @return array{user: User, assets: Asset[]}
     */
    public function getEditPageData(int $id): array
    {
        return [
        'user' => $this->getUserUseCase->execute($id),
        'assets' => $this->getAllAssetUseCase->execute(user_id: $id)
        ];
    }

    public function update(int $id, string $name, string $email, string $role, ?string $password): void
    {
        $this->updateUserUseCase->execute($id, $name, $email, $role, $password);
    }

    public function delete(int $id): void
    {
        $this->deleteUserUseCase->execute($id);
    }
}
