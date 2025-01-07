<?php

namespace UseCases\User;

use Repositories\User\UserRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;
use Services\Session\SessionService;

class SignInUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
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

			$session = SessionService::getInstance();
            $session->setUser($user);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to sign in user: ' . $e->getMessage(), 500, $e);
        }
    }
}
