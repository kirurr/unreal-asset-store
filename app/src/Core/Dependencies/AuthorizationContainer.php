<?php

namespace Core\Dependencies;

use Controllers\AuthController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\User\UserSQLiteRepository;
use Services\Auth\AuthService;
use Services\PasswordHasher\PasswordHasherService;
use Services\Session\SessionService;
use UseCases\User\SignInUserUseCase;
use UseCases\User\SignOutUserUseCase;
use UseCases\User\SignUpUserUseCase;

class AuthorizationContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(AuthService::class, function () {
            return new AuthService($this->get(UserSQLiteRepository::class), $this->get(PasswordHasherService::class));
        });

        $this->set(SignInUserUseCase::class, function () {
            return new SignInUserUseCase($this->get(AuthService::class), $this->get(SessionService::class));
        });

        $this->set(SignUpUserUseCase::class, function () {
            return new SignUpUserUseCase($this->get(UserSQLiteRepository::class), $this->get(SessionService::class));
        });

        $this->set(SignOutUserUseCase::class, function () {
            return new SignOutUserUseCase($this->get(SessionService::class));
        });

        $this->set(AuthController::class, function () {
            return new AuthController(
                $this->get(SignInUserUseCase::class),
                $this->get(SignUpUserUseCase::class),
                $this->get(SignOutUserUseCase::class)
            );
        });
    }
}
