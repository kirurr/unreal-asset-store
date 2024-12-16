<?php

namespace Controllers\Admin;

use DomainException;
use Exception;
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

    public function show(): void
    {
        try {
            $users = $this->getAllUseCase->execute();
            renderView('admin/users/index', ['users' => $users]);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView(
                'admin/users/index', [
                'errorMessage' => $e->getMessage(),
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
    }

    public function showEdit(int $id): void
    {
        try {
            $user = $this->getUserUseCase->execute($id);
			$assets = $this->getAllAssetUseCase->execute(user_id: $id);
            renderView('admin/users/edit', ['user' => $user, 'assets' => $assets]);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView(
                'admin/users/edit', [
                'errorMessage' => $e->getMessage(),
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
    }

    public function update(int $id, string $name, string $email, string $role, ?string $password): void
    {
        try {
            $this->updateUserUseCase->execute($id, $name, $email, $role, $password);
        } catch (DomainException $e) {
            http_response_code(400);
            $user = $this->getUserUseCase->execute($id);
			$assets = $this->getAllAssetUseCase->execute(user_id: $id);
            renderView(
                'admin/users/edit', [
                'user' => $user,
				'assets' => $assets,
                'errorMessage' => $e->getMessage()
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        header('Location: /admin/users');
        die();
    }

    public function delete(int $id): void
    {
        try {
            $this->deleteUserUseCase->execute($id);
        } catch (DomainException $e) {
            http_response_code(400);
            $user = $this->getUserUseCase->execute($id);
            renderView(
                'admin/users/edit', [
                'user' => $user,
                'errorMessage' => $e->getMessage()
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        header('Location: /admin/users');
        die();
    }
}
