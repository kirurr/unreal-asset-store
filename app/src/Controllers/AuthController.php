<?php

namespace Controllers;

use Core\Errors\Error;
use Core\Errors\ErrorCode;
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

    public function showSignInPage(): void
    {
        renderView('auth/signin', []);
    }

    public function showSignUpPage(): void
    {
        renderView('auth/signup', []);
    }

    public function signIn(string $email, string $password): void
    {
        $result = $this->signInUseCase->execute($email, $password);

        if ($result instanceof Error && $result->code === ErrorCode::INVALID_CREDENTIALS) {
            http_response_code(400);
            renderView('auth/signin', [
                'errorMessage' => $result->message,
                'previousData' => [
                    'email' => $email,
                    'password' => $password
                ],
                'fields' => ['email', 'password']
            ]);
            die();
        }

        header('Location: /');
        die();
    }

    public function signUp(string $name, string $email, string $password): void
    {
        $result = $this->signUpUseCase->execute($name, $email, $password);

        if ($result instanceof Error && $result->code === ErrorCode::USER_ALREADY_EXISTS) {
            http_response_code(400);
            renderView('auth/signup', [
                'errorMessage' => $result->message,
                'previousData' => [
                    'email' => $email,
                    'password' => $password,
                    'name' => $name
                ],
                'fields' => ['email']
            ]);
            die();
        }

        header('Location: /');
        die();
    }

    public function signOut(): void
    {
        $this->signOutUseCase->execute();

        header('Location: /');
    }
}
