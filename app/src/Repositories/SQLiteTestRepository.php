<?php

namespace Repositories;

use PDO;
use Entities\Test;
use Repositories\TestRepositoryInterface;

class SQLiteTestRepository implements TestRepositoryInterface
{
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getById(int $id): Test
	{
		$stmt = $this->pdo->prepare("SELECT * FROM test WHERE id = :id");
		$stmt->execute(["id" => $id]);
		$result = $stmt->fetch();

		if ($result) {
			return new Test((int) $result['id'], $result['text']);
		}
		return null;
	}
}
