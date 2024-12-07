<?php

namespace Controllers;

use UseCases\User\SignInUserUseCase;
use UseCases\User\SignOutUserUseCase;
use UseCases\User\SignUpUserUseCase;
use DomainException;
use Exception;

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
        try {
            $this->signInUseCase->execute($email, $password);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView('auth/signin', [
                'errorMessage' => $e->getMessage(),
                'previousData' => [
                    'email' => $email,
                    'password' => $password
                ],
                'fields' => ['email', 'password']
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        header('Location: /', true, 303);
    }

    public function signUp(string $name, string $email, string $password): void
    {
        try {
            $this->signUpUseCase->execute($name, $email, $password);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView('auth/signup', [
                'errorMessage' => $e->getMessage(),
                'previousData' => [
                    'email' => $email,
                    'password' => $password,
                    'name' => $name
                ],
                'fields' => ['email']
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        header('Location: /', true, 303);
    }

    public function signOut(): void
    {
        $this->signOutUseCase->execute();

        header('Location: /', true, 303);
    }
}
