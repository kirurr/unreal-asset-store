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

    /**
     * @return ?Asset[]
     */
    public function getAssets(
        int $category_id = null,
        int $user_id = null,
		string $search = null,
		string $engine_version = null,
        int $interval = null,
        bool $byNew = null,
        bool $byPopular = null,
        bool $asc = null,
        int $minPrice = null,
        int $maxPrice = null,
        int $limit = null
    ): array {
        $query = "SELECT * FROM asset";
        $conditions = [];

		if ($search) {
			$conditions[] = "name LIKE :search OR info LIKE :search OR description LIKE :search";
		}
		if ($engine_version) {
			$conditions[] = "engine_version = :engine_version";
		}
        if ($category_id) {
            $conditions[] = "category_id = :category_id";
        }
        if ($user_id) {
            $conditions[] = "user_id = :user_id";
        }
        if ($interval) {
            $conditions[] = "created_at >= strftime('%s', 'now', '-$interval days') AND created_at < strftime('%s', 'now')";
        }
        if ($minPrice) {
            $conditions[] = "price >= :minPrice";
        }
        if ($maxPrice) {
            $conditions[] = "price <= :maxPrice";
        }

        if ($conditions) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        if ($byNew && $byPopular) {
            $query .= " ORDER BY purchase_count" . ($asc ? " ASC" : " DESC") . ", created_at" . ($asc ? " ASC" : " DESC");
        } elseif ($byNew) {
            $query .= " ORDER BY created_at" . ($asc ? " ASC" : " DESC");
        } elseif ($byPopular) {
            $query .= " ORDER BY purchase_count" . ($asc ? " ASC" : " DESC");
        }

        if ($limit) {
            $query .= " LIMIT :limit";
        }

        try {

                $stmt = $this->pdo->prepare($query);
            if ($category_id) {
                $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            }
            if ($user_id) {
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            }
			if ($search) {
				$searchWildcard = '%' . $search . '%';
				$stmt->bindParam(':search', $searchWildcard, PDO::PARAM_STR);
			}
			if ($engine_version) {
				$stmt->bindParam(':engine_version', $engine_version, PDO::PARAM_STR);
			}
			if ($limit) {
				$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
			}
            if ($minPrice) {
                $stmt->bindParam(':minPrice', $minPrice, PDO::PARAM_INT);
            }
            if ($maxPrice) {
                $stmt->bindParam(':maxPrice', $maxPrice, PDO::PARAM_INT);
            }

            $stmt->execute();
            $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$assets) {
                return [];
            }

            return array_map(
                fn($asset) => new Asset(
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
                ),
                $assets
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
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
