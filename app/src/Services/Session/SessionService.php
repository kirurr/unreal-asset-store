<?php

namespace Services\Session;

use Entities\User;

class SessionService implements SessionInterface
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setUser(User $user): void
    {
        $_SESSION['user'] = [
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'role' => $user->role,
		];
    }

	/**
	 * @return array{ id: int, name: string, email: string, role: string }
	 */
    public function getUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function deleteUser(): void
    {
        unset($_SESSION['user']);
    }

    public function hasUser(): bool
    {
        return isset($_SESSION['user']);
    }
}
