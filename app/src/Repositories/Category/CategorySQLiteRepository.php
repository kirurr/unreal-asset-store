<?php

namespace Repositories\Category;

use Entities\Category;
use PDO;
use PDOException;
use RuntimeException;

class CategorySQLiteRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function getByName(string $name): ?Category
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM category WHERE name = :name');
            $stmt->execute(['name' => $name]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category
                ? new Category($category['id'], $category['name'], $category['description'], $category['asset_count'])
                : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getById(int $id): ?Category
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM category WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category
                ? new Category($category['id'], $category['name'], $category['description'], $category['asset_count'])
                : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getAll(): ?array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM category');
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$categories) {
                return [];
            }
            $result = [];
            foreach ($categories as $category) {
                $result[] = new Category($category['id'], $category['name'], $category['description'], $category['asset_count']);
            }
            return $result;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function create(string $name, string $description): void
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO category (name, description) VALUES (:name, :description)');
            $stmt->execute(['name' => $name, 'description' => $description]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function update(Category $category): void
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE category SET name = :name, description = :description WHERE id = :id');
            $stmt->execute([
                'name' => $category->name,
                'description' => $category->description,
                'id' => $category->id
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function delete(int $id): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM category WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

	public function incrementAssetCount(int $id): void
	{
		try {
			$stmt = $this->pdo->prepare('UPDATE category SET asset_count = asset_count + 1 WHERE id = :id');
			$stmt->execute(['id' => $id]);
		} catch (PDOException $e) {
			throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
		}
	}

	public function decrementAssetCount(int $id): void
	{
		try {
			$stmt = $this->pdo->prepare('UPDATE category SET asset_count = asset_count - 1 WHERE id = :id');
			$stmt->execute(['id' => $id]);
		} catch (PDOException $e) {
			throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
		}
	}
}
