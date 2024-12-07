<?php

namespace UseCases\User;

use Core\Errors\Error;
use Entities\User;
use Repositories\User\UserSQLiteRepository;
use Services\Session\SessionInterface;

class SignUpUserUseCase
{
    public function __construct(
        private UserSQLiteRepository $repository,
        private SessionInterface $session
    ) {}

    public function execute(string $name, string $email, string $password): User|Error
    {
        $result = $this->repository->create($name, $email, $password);

        if ($result instanceof Error) {
            return $result;
        }

        $this->session->setUser($result);
        return $result;
    }
}
