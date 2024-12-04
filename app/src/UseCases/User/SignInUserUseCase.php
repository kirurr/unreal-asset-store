<?php

namespace UseCases\User;

use Core\Errors\Error;
use Entities\User;
use Services\Auth\AuthInterface;
use Services\Session\SessionInterface;

class SignInUserUseCase
{
    public function __construct(
        private AuthInterface $authorization,
        private SessionInterface $session
    ) {}

    public function execute(string $email, string $password): User|Error
    {
        $result = $this->authorization->authorize($email, $password);

        if ($result instanceof Error) {
            return $result;
        }

        $this->session->setUser($result);
        return $result;
    }
}
