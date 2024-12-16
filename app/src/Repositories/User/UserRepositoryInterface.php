<?php

namespace Repositories\User;

use Entities\User;

interface UserRepositoryInterface
{
    public function getById(int $id): ?User;
    public function getByEmail(string $email): ?User;
    public function create(string $name, string $email, string $password): User;
	public function update(User $user): void;
	public function delete(User $user): void;
    /**
     * @return User[]
     */
    public function getAll(): array;
}
