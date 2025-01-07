<?php

namespace Core\Dependencies;

use Controllers\AuthController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\User\UserSQLiteRepository;
use UseCases\User\SignInUserUseCase;
use UseCases\User\SignOutUserUseCase;
use UseCases\User\SignUpUserUseCase;

class AuthorizationContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(SignInUserUseCase::class, function () {
            return new SignInUserUseCase($this::get(UserSQLiteRepository::class));
        });

        $this->set(SignUpUserUseCase::class, function () {
            return new SignUpUserUseCase($this::get(UserSQLiteRepository::class));
        });

        $this->set(SignOutUserUseCase::class, function () {
            return new SignOutUserUseCase();
        });

        $this->set(AuthController::class, function () {
            return new AuthController(
                $this::get(SignInUserUseCase::class),
                $this::get(SignUpUserUseCase::class),
                $this::get(SignOutUserUseCase::class)
            );
        });
    }
}
