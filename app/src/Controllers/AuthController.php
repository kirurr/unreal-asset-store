<?php

namespace Controllers;

use UseCases\User\SignInUserUseCase;
use UseCases\User\SignOutUserUseCase;
use UseCases\User\SignUpUserUseCase;

class AuthController
{
    public function __construct(
        private SignInUserUseCase $signInUseCase,
        private SignUpUserUseCase $signUpUseCase,
        private SignOutUserUseCase $signOutUseCase
    ) {}

    public function signIn(string $email, string $password): void
    {
		$this->signInUseCase->execute($email, $password);
    }

    public function signUp(string $name, string $email, string $password): void
    {
		$this->signUpUseCase->execute($name, $email, $password);
    }

    public function signOut(): void
    {
        $this->signOutUseCase->execute();
    }
}
