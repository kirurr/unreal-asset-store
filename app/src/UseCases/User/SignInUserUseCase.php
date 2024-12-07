<?php

namespace UseCases\User;

use Repositories\User\UserRepositoryInterface;
use Services\Session\SessionInterface;
use DomainException;
use Exception;
use RuntimeException;

class SignInUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private SessionInterface $session
    ) {}

    public function execute(string $email, string $password): void
    {
        try {
            $user = $this->repository->getByEmail($email);
            if (!$user) {
                throw new DomainException('Invalid credentials');
            }
            if (!$user->checkPassword($password)) {
                throw new DomainException('Invalid credentials');
            }
            $this->session->setUser($user);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to sign in user: ' . $e->getMessage(), 500, $e);
        }
    }
}
