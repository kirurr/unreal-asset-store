<?php

namespace Core\Dependencies;

use Controllers\AuthController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Services\Auth\AuthService;
use UseCases\User\SignInUserUseCase;
use UseCases\User\SignOutUserUseCase;
use UseCases\User\SignUpUserUseCase;

class AuthorizationContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set('AuthService', function () {
            return new AuthService($this->get('SQLiteUserRepository'), $this->get('PasswordHasherService'));
        });

        $this->set('SignInUserUseCase', function () {
            return new SignInUserUseCase($this->get('AuthService'), $this->get('SessionService'));
        });

        $this->set('SignUpUserUseCase', function () {
            return new SignUpUserUseCase($this->get('SQLiteUserRepository'), $this->get('SessionService'));
        });

        $this->set('SignOutUserUseCase', function () {
            return new SignOutUserUseCase($this->get('SessionService'));
        });

        $this->set('AuthController', function () {
            return new AuthController(
                $this->get('SignInUserUseCase'),
                $this->get('SignUpUserUseCase'),
                $this->get('SignOutUserUseCase')
            );
        });
    }
}
