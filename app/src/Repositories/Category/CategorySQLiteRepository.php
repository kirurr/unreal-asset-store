<?php

namespace Repositories\Category;

use DomainException;
use PDO;
use PDOException;
use RuntimeException;

class CategorySQLiteRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function getByName(string $name): array|false
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM category WHERE name = :name');
            $stmt->execute(['name' => $name]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM category WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category ?? null;
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
            return $categories ?? null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function create(string $name, string $description, string $image): void
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO category (name, description, image) VALUES (:name, :description, :image)');
            $stmt->execute(['name' => $name, 'description' => $description, 'image' => $image]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function update(int $id, string $name, string $description, string $image): void
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE category SET name = :name, description = :description, image = :image WHERE id = :id');
            $stmt->execute(['name' => $name, 'description' => $description, 'image' => $image, 'id' => $id]);
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
}
