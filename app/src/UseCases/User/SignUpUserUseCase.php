<?php

namespace UseCases\User;

use Repositories\User\UserSQLiteRepository;
use DomainException;
use RuntimeException;
use Services\Session\SessionService;

class SignUpUserUseCase
{
    public function __construct(
        private UserSQLiteRepository $repository,
    ) {}

    public function execute(string $name, string $email, string $password): void
    {
        try {
            $prevUser = $this->repository->getByEmail($email);
            if ($prevUser) {
                throw new DomainException('User already exists');
            }
            $user = $this->repository->create($name, $email, $password);

			$session = SessionService::getInstance();
            $session->setUser($user);
        } catch (RuntimeException $e) {
            throw new RuntimeException('Unable to sign up user: ' . $e->getMessage(), 500, $e);
        }
    }
}
