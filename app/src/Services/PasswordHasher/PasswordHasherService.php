<?php

namespace Services\PasswordHasher;

class PasswordHasherService implements PasswordHasherInterface
{
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function check(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
