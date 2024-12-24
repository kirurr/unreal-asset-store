<?php

namespace Core\Dependencies;
use Controllers\UserController;
use Core\ContainerInterface;
use Repositories\User\UserSQLiteRepository;
use Core\ServiceContainer;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\User\DeleteUserUseCase;
use UseCases\User\GetAllUserUseCase;
use UseCases\User\GetUserUseCase;
use UseCases\User\UpdateUserUseCase;

class UserContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {

        $this->set(
            GetAllUserUseCase::class, function () {
                return new GetAllUserUseCase($this::get(UserSQLiteRepository::class));
            }
        );
        $this->set(
            DeleteUserUseCase::class, function () {
                return new DeleteUserUseCase($this::get(UserSQLiteRepository::class), $this::get(GetAllAssetUseCase::class));
            }
        );
        $this->set(
            UpdateUserUseCase::class, function () {
                return new UpdateUserUseCase($this::get(UserSQLiteRepository::class));
            }
        );

        $this->set(
            GetUserUseCase::class, function () {
                return new GetUserUseCase($this::get(UserSQLiteRepository::class));
            }
        );

        $this->set(
            UserController::class, function () {
                return new UserController(
                    $this::get(GetAllUserUseCase::class),
                    $this::get(GetUserUseCase::class),
                    $this::get(UpdateUserUseCase::class),
                    $this::get(DeleteUserUseCase::class),
                    $this::get(GetAllAssetUseCase::class)
                );
            }
        );
    }
}
