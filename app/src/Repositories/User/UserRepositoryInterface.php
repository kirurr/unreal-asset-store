<?php

namespace Repositories\User;

use Core\Errors\Error;
use Entities\User;

interface UserRepositoryInterface
{
    public function getById(int $id): User|Error;
    public function getByEmail(string $email): User|Error;
    public function create(string $name, string $email, string $password): User|Error;
}
