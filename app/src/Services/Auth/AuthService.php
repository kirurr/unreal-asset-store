<?php

namespace Services\Auth;

use Core\Errors\Error;
use Core\Errors\ErrorCode;
use Entities\User;
use Repositories\User\UserRepositoryInterface;
use Services\PasswordHasher\PasswordHasherInterface;

class AuthService implements AuthInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PasswordHasherInterface $hasher
    ) {}

    public function authorize(string $email, string $password): Error|User
    {
        $user = $this->repository->getByEmail($email);

        if ($user instanceof Error || !$this->hasher->check($password, $user->password)) {
            return new Error('Invalid credentials', ErrorCode::INVALID_CREDENTIALS);
        }

        return $user;
    }
}
