<?php

namespace Repositories\Asset;

use Entities\Asset;
use PDO;
use PDOException;
use RuntimeException;

class AssetSQLiteRepository implements AssetRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function getByCategoryId(int $category_id): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM asset WHERE category_id = :category_id');
            $stmt->execute(['category_id' => $category_id]);
            $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$assets) {
                return [];
            }
            $result = [];
            foreach ($assets as $asset) {
                $images = json_decode($asset['images']);
                $result[] = new Asset(
                    $asset['id'],
                    $asset['name'],
                    $asset['info'],
                    $asset['description'],
                    $images,
                    $asset['price'],
                    $asset['engine_version'],
                    $asset['category_id'],
                    $asset['user_id'],
                    $asset['created_at'],
                    $asset['purchase_count']
                );
            }
            return $result;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getById(int $id): ?Asset
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM asset WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $asset = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$asset) {
                return null;
            }
            $images = json_decode($asset['images']);
            return new Asset(
                $asset['id'],
                $asset['name'],
                $asset['info'],
                $asset['description'],
                $images,
                $asset['price'],
                $asset['engine_version'],
                $asset['category_id'],
                $asset['user_id'],
                $asset['created_at'],
                $asset['purchase_count']
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM asset');
            $stmt->execute();
            $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$assets) {
                return [];
            }
            $result = [];
            foreach ($assets as $asset) {
                $images = json_decode($asset['images']);
                $result[] = new Asset(
                    $asset['id'],
                    $asset['name'],
                    $asset['info'],
                    $asset['description'],
                    $images,
                    $asset['price'],
                    $asset['engine_version'],
                    $asset['category_id'],
                    $asset['user_id'],
                    $asset['created_at'],
                    $asset['purchase_count']
                );
            }
            return $result;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function create(string $name, string $info, string $description, array $images, int $price, int $engine_version, int $category_id, int $user_id): void
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO asset (name, info, description, images, price, engine_version, category_id, user_id)
				VALUES (:name, :info, :description, :images, :price, :engine_version, :category_id, :user_id)'
            );
            $stmt->execute(
                [
                'name' => $name,
                'info' => $info,
                'description' => $description,
                'images' => json_encode($images),
                'price' => $price,
                'engine_version' => $engine_version,
                'category_id' => $category_id,
                'user_id' => $user_id,
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function update(Asset $asset): void
    {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE asset SET name = :name, info = :info, description = :description, images = :images, price = :price, engine_version = :engine_version, category_id = :category_id
				WHERE id = :id'
            );
            $stmt->execute(
                [
                'name' => $asset->name,
                'info' => $asset->info,
                'description' => $asset->description,
                'images' => json_encode($asset->images),
                'price' => $asset->price,
                'engine_version' => $asset->engine_version,
                'category_id' => $asset->category_id,
                'id' => $asset->id,
                ]
            );
        }
        catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function delete(int $id): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM asset WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }
}