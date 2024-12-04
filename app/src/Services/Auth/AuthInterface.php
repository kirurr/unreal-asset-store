<?php

namespace Services\Auth;

use Core\Errors\Error;
use Entities\User;

interface AuthInterface
{
    public function authorize(string $email, string $password): User | Error;
}
