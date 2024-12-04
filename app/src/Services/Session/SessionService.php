<?php

namespace Services\Session;

use Core\Errors\Error;
use Core\Errors\ErrorCode;
use Entities\User;

class SessionService implements SessionInterface
{
    public function __construct() {}

    public function setUser(User $user): void
    {
        $_SESSION['user'] = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email];
    }

    public function getUser(): array|Error
    {
        return $_SESSION['user'] ?? new Error('No user found', ErrorCode::USER_NOT_FOUND);
    }

    public function deleteUser(): void
    {
        unset($_SESSION['user']);
    }
}
