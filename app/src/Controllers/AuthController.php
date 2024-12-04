<?php

namespace Controllers;

use Core\Errors\Error;
use Core\Errors\UserError;
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
        $result = $this->signInUseCase->execute($email, $password);

        if ($result instanceof Error) {
            $error = new UserError($result->message, $result->code, ['email', 'password']);
            http_response_code(400);
            echo json_encode($error->getData());
            die();
        }

        die();
    }

    public function signUp(string $name, string $email, string $password): void
    {
        $result = $this->signUpUseCase->execute($name, $email, $password);

        if ($result instanceof Error) {
            $error = new UserError($result->message, $result->code, ['email']);
            http_response_code(400);
            echo json_encode($error->getData());
            die();
        }

        die();
    }

    public function signOut(): void
    {
        $this->signOutUseCase->execute();

        header('Location: /');
    }
}
