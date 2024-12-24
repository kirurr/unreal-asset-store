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

    public function getByCategoryId(string $category_id): array
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

    public function getByUserId(string $user_id): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM asset WHERE user_id = :user_id');
            $stmt->execute(['user_id' => $user_id]);
            $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$assets) {
                return [];
            }
            $result = [];
            foreach ($assets as $asset) {
                $result[] = new Asset(
                    $asset['id'],
                    $asset['name'],
                    $asset['info'],
                    $asset['description'],
                    [],
					$asset['preview_image'],
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

    public function getById(string $id): ?Asset
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM asset WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $asset = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$asset) {
                return null;
            }
            return new Asset(
                $asset['id'],
                $asset['name'],
                $asset['info'],
                $asset['description'],
                [],
				$asset['preview_image'],
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
                $result[] = new Asset(
                    $asset['id'],
                    $asset['name'],
                    $asset['info'],
                    $asset['description'],
                    [],
					$asset['preview_image'],
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

    public function create(string $id, string $name, string $info, string $description, string $preview_image, int $price, string $engine_version, int $category_id, int $user_id): void
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO asset (id, name, info, description, preview_image, price, engine_version, category_id, user_id)
				VALUES (:id, :name, :info, :description, :preview_image, :price, :engine_version, :category_id, :user_id)'
            );
            $stmt->execute(
                [
                'id' => $id,
                'name' => $name,
                'info' => $info,
                'description' => $description,
                'preview_image' => $preview_image,
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
                'UPDATE asset SET name = :name, info = :info, description = :description, preview_image = :preview_image, price = :price, engine_version = :engine_version, category_id = :category_id
				WHERE id = :id'
            );
            $stmt->execute(
                [
                'name' => $asset->name,
                'info' => $asset->info,
                'description' => $asset->description,
				'preview_image' => $asset->preview_image,
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

    public function delete(string $id): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM asset WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

	public function incrementPurchasedCount(string $id): void
	{
		try {
			$stmt = $this->pdo->prepare('UPDATE asset SET purchase_count = purchase_count + 1 WHERE id = :id');
			$stmt->execute(['id' => $id]);
		} catch (PDOException $e) {
			throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
		}
	}

	public function decrementPurchasedCount(string $id): void
	{
		try {
			$stmt = $this->pdo->prepare('UPDATE asset SET purchase_count = purchase_count - 1 WHERE id = :id');
			$stmt->execute(['id' => $id]);
		} catch (PDOException $e) {
			throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
		}
	}
}
