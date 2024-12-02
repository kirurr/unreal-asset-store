<?php

namespace Repositories\User;

use Entities\User;
use PDO;
## TODO: REMOVE FIELDS FROM HERE
class SQLiteUserRepository implements UserRepositoryInterface
{
	public function __construct(private PDO $pdo) {}

	public function getByEmail(string $email): ?User
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
		$stmt->execute(["email" => $email]);
		$result = $stmt->fetch();

		if ($result) {
			return new User((int) $result['id'], $result['name'], $result['email'], $result['password']);
		}
		return null;
	}

	public function getById(int $id): ?User
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = :id");
		$stmt->execute(["id" => $id]);
		$result = $stmt->fetch();

		if ($result) {
			return new User((int) $result['id'], $result['name'], $result['email'], $result['password']);
		}
		return null;
	}

	public function create(string $name, string $email, string $password): mixed
	{
		
		$user = $this->getByEmail($email);
		if ($user) {
			return [[
				'message' => 'User already exists',
				'fields' => [
					'email'
				]
			], null];
		}

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $this->pdo->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
		$stmt->execute(["name" => $name, "email" => $email, "password" => $password_hash]);

		$newUser = new User($this->pdo->lastInsertId(), $name, $email, $password_hash);

		return [null, $newUser];
	}

	public function authorize(string $email, string $password): mixed
	{
		$user = $this->getByEmail($email);

		if (!$user) {
			return [[
				'message' => 'User not found',
				'fields' => [
					'email'
				]
			], null];
		}

		if ($user->checkPassword($password)) {
			return [null, $user];
		} else {
			return [[
				'message' => 'Invalid email or password',
				'fields' => [
					'email',
					'password'
				]
			], null];
		}
	}
}
