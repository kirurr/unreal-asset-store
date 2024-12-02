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
        [$error, $user] = $this->signInUseCase->execute($email, $password);

        if ($error) {
            $message = [
                'data' => $error,
                'type' => 'error'
            ];
            http_response_code(400);
            echo json_encode($message);
            die();
        }

        $_SESSION['user'] = $user->get();

        $message = [
            'type' => 'success'
        ];
        echo json_encode($message);
        die();
    }

    public function signUp(string $name, string $email, string $password): void
    {
        [$error, $user] = $this->signUpUseCase->execute($name, $email, $password);

        if ($error) {
            $message = [
                'data' => $error,
                'type' => 'error'
            ];
            http_response_code(400);
            echo json_encode($message);
            die();
        }

        $_SESSION['user'] = $user->get();

        $message = [
            'type' => 'success'
        ];

        echo json_encode($message);
        die();
    }

    public function signOut(): void
    {
        /* $this->signOutUseCase->execute(); */
        unset($_SESSION['user']);

        header('Location: /');
    }
}
