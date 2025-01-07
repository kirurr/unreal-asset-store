<?php

namespace Services\Session;

use Entities\User;

class SessionService
{
    private static ?SessionService $instance = null;

    /**
     * @var array{ id: int, name: string, email: string, role: string }
     */
    private ?array $user = null;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

		$this->user = $_SESSION['user'] ?? null;
    }

	public static function getInstance(): SessionService
	{
		if (self::$instance === null) {
			self::$instance = new SessionService();
		}

		return self::$instance;
	}

    public function setUser(User $user): void
    {
		$this->user = [
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'role' => $user->role,
		];

        $_SESSION['user'] = $this->user;
    }

    /**
     * @return array{ id: int, name: string, email: string, role: string }
     */
    public function getUser(): ?array
    {
        return $this->user;
    }

    public function deleteUser(): void
    {
		$this->user = null;
        unset($_SESSION['user']);
    }

    public function hasUser(): bool
    {
        return $this->user !== null;
    }
}
