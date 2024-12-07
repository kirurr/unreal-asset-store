<?php

namespace UseCases\User;

use Repositories\User\UserSQLiteRepository;
use Services\Session\SessionInterface;
use DomainException;
use RuntimeException;

class SignUpUserUseCase
{
    public function __construct(
        private UserSQLiteRepository $repository,
        private SessionInterface $session
    ) {}

    public function execute(string $name, string $email, string $password): void
    {
        try {
            $prevUser = $this->repository->getByEmail($email);
            if ($prevUser) {
                throw new DomainException('User already exists');
            }
            $user = $this->repository->create($name, $email, $password);

            $this->session->setUser($user);
        } catch (RuntimeException $e) {
            throw new RuntimeException('Unable to sign up user: ' . $e->getMessage(), 500, $e);
        }
    }
}
