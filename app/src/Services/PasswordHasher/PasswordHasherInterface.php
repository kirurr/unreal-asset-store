<?php

namespace Services\PasswordHasher;

interface PasswordHasherInterface
{
    public function hash(string $password): string;

    public function check(string $password, string $hash): bool;
}
