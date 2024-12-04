<?php

namespace Repositories\User;

use Core\Errors\Error;
use Core\Errors\ErrorCode;
use Entities\User;
use PDO;

class SQLiteUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function getByEmail(string $email): User|Error
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        if ($result) {
            return new User((int) $result['id'], $result['name'], $result['email'], $result['password']);
        }
        return new Error('User not found', ErrorCode::USER_NOT_FOUND);
    }

    public function getById(int $id): User|Error
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        if ($result) {
            return new User((int) $result['id'], $result['name'], $result['email'], $result['password']);
        }
        return new Error('User not found', ErrorCode::USER_NOT_FOUND);
    }

    public function create(string $name, string $email, string $password): User|Error
    {
        $user = $this->getByEmail($email);
        if ($user instanceof User) {
            return new Error('User already exists', ErrorCode::USER_ALREADY_EXISTS);
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password_hash]);

        return new User($this->pdo->lastInsertId(), $name, $email, $password_hash);
    }
}
