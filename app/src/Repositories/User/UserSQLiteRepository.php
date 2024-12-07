<?php

namespace Repositories\User;

use Entities\User;
use PDO;
use PDOException;
use RuntimeException;

class UserSQLiteRepository implements UserRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function getByEmail(string $email): ?User
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM user WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? new User(
                (int) $user['id'],
                $user['name'],
                $user['email'],
                $user['password'],
                $user['role']
            ) : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function getById(int $id): ?User
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch();

            return $result ? new User(
                (int) $result['id'],
                $result['name'],
                $result['email'],
                $result['password'],
                $result['role']
            ) : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function create(string $name, string $email, string $password): User
    {
        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password_hash]);

            return new User($this->pdo->lastInsertId(), $name, $email, $password_hash, 'user');
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }
}
