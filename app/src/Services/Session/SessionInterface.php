<?php

namespace Services\Session;

use Core\Errors\Error;
use Entities\User;

interface SessionInterface
{
    public function setUser(User $user): void;

    public function getUser(): User|Error;

    public function deleteUser(): void;
}