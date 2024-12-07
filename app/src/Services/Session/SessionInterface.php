<?php

namespace Services\Session;

use Entities\User;

interface SessionInterface
{
    public function setUser(User $user): void;

    public function getUser(): ?array;

    public function deleteUser(): void;

	public function hasUser(): bool;
}
