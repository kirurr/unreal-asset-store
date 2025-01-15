<?php

namespace Repositories\Asset;

use Entities\Asset;
use Entities\AssetFilters;
use Entities\Category;
use Entities\Review;
use Entities\User;
use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

class AssetSQLiteRepository implements AssetRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function getById(string $id): ?Asset
    {
        try {
            $query = "SELECT asset.*, \tcategory.id as category_id, category.name as category_name, category.description as category_description, category.asset_count as category_asset_count, \tuser.id as user_id, user.name as user_name, user.email as user_email, user.password as user_password, user.role as user_role FROM asset JOIN category ON asset.category_id = category.id JOIN user ON asset.user_id = user.id WHERE asset.id = :id";
            $stmt = $this->pdo->prepare($query);
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
                new Category($asset['category_id'], $asset['category_name'], $asset['category_description'], $asset['category_asset_count']),
                new User($asset['user_id'], $asset['user_name'], $asset['user_email'], $asset['user_password'], $asset['user_role']),
                $asset['created_at'],
                $asset['purchase_count']
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function buildQuery(AssetFilters $filters, bool $isCount = false): PDOStatement
    {
        if (!$isCount) {
            $query = "SELECT asset.*, \tcategory.id as category_id, category.name as category_name, category.description as category_description, category.asset_count as category_asset_count, \tuser.id as user_id, user.name as user_name, user.email as user_email, user.password as user_password, user.role as user_role FROM asset JOIN category ON asset.category_id = category.id JOIN user ON asset.user_id = user.id";
        } else {
            $query = 'SELECT COUNT(*) FROM asset';
        }
        $conditions = [];

        if ($filters->search) {
            $conditions[] = 'name LIKE :search OR info LIKE :search OR description LIKE :search';
        }
        if ($filters->engine_version) {
            $conditions[] = 'engine_version = :engine_version';
        }
        if ($filters->category_id) {
            $conditions[] = 'category_id = :category_id';
        }
        if ($filters->user_id) {
            $conditions[] = 'user_id = :user_id';
        }
        if ($filters->interval) {
            $conditions[] = "created_at >= strftime('%s', 'now', '-$filters->interval days') AND created_at < strftime('%s', 'now')";
        }
        if ($filters->byFree) {
            $conditions[] = 'price <= 0';
        } else {
            if ($filters->minPrice) {
                $conditions[] = 'price >= :minPrice';
            }

            if ($filters->maxPrice) {
                $conditions[] = 'price <= :maxPrice';
            }
        }

        if ($conditions) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        if ($filters->byNew && $filters->byPopular) {
            $query .= ' ORDER BY purchase_count' . ($filters->asc ? ' ASC' : ' DESC') . ', created_at' . ($filters->asc ? ' ASC' : ' DESC');
        } elseif ($filters->byNew) {
            $query .= ' ORDER BY created_at' . ($filters->asc ? ' ASC' : ' DESC');
        } elseif ($filters->byPopular) {
            $query .= ' ORDER BY purchase_count' . ($filters->asc ? ' ASC' : ' DESC');
        }

        if ($filters->limit && !$isCount) {
            $query .= ' LIMIT :limit';
        }

        if ($filters->offset && !$isCount) {
            $query .= ' OFFSET :offset';
        }

        try {
            $stmt = $this->pdo->prepare($query);
            if ($filters->category_id) {
                $stmt->bindParam(':category_id', $filters->category_id, PDO::PARAM_INT);
            }
            if ($filters->user_id) {
                $stmt->bindParam(':user_id', $filters->user_id, PDO::PARAM_INT);
            }
            if ($filters->search) {
                $searchWildcard = '%' . $filters->search . '%';
                $stmt->bindParam(':search', $searchWildcard, PDO::PARAM_STR);
            }
            if ($filters->engine_version) {
                $stmt->bindParam(':engine_version', $filters->engine_version, PDO::PARAM_STR);
            }
            if ($filters->limit && !$isCount) {
                $stmt->bindParam(':limit', $filters->limit, PDO::PARAM_INT);
            }
            if ($filters->offset && !$isCount) {
                $stmt->bindParam(':offset', $filters->offset, PDO::PARAM_INT);
            }

            if (!$filters->byFree) {
                if ($filters->minPrice) {
                    $stmt->bindParam(':minPrice', $filters->minPrice, PDO::PARAM_INT);
                }
                if ($filters->maxPrice) {
                    $stmt->bindParam(':maxPrice', $filters->maxPrice, PDO::PARAM_INT);
                }
            }

            return $stmt;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function countAssets(PDOStatement $stmt): int
    {
        try {
            $stmt->execute();
            return $stmt->fetch()[0];
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    /**
     * @return ?Asset[]
     */
    public function getAssets(PDOStatement $stmt): array
    {
        try {
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
                    new Category($asset['category_id'], $asset['category_name'], $asset['category_description'], $asset['category_asset_count']),
                    new User($asset['user_id'], $asset['user_name'], $asset['user_email'], $asset['user_password'], $asset['user_role']),
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
                "INSERT INTO asset (id, name, info, description, preview_image, price, engine_version, category_id, user_id)
\t\t\t\tVALUES (:id, :name, :info, :description, :preview_image, :price, :engine_version, :category_id, :user_id)"
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
                "UPDATE asset SET name = :name, info = :info, description = :description, preview_image = :preview_image, price = :price, engine_version = :engine_version, category_id = :category_id
\t\t\t\tWHERE id = :id"
            );
            $stmt->execute(
                [
                    'name' => $asset->name,
                    'info' => $asset->info,
                    'description' => $asset->description,
                    'preview_image' => $asset->preview_image,
                    'price' => $asset->price,
                    'engine_version' => $asset->engine_version,
                    'category_id' => $asset->category->id,
                    'id' => $asset->id,
                ]
            );
        } catch (PDOException $e) {
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

    public function getAssetsByUserPurchases(int $user_id): array
    {
        $query = "SELECT asset.*,
	category.id as category_id,
	category.name as category_name,
	category.description as category_description,
	category.asset_count as category_asset_count,
	user.id as user_id,
	user.name as user_name,
	user.email as user_email,
	user.password as user_password,
	user.role as user_role
FROM asset
JOIN category ON asset.category_id = category.id JOIN purchase on purchase.asset_id = asset.id JOIN user on asset.user_id = user.id WHERE purchase.user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
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
                new Category($asset['category_id'], $asset['category_name'], $asset['category_description'], $asset['category_asset_count']),
                new User($asset['user_id'], $asset['user_name'], $asset['user_email'], $asset['user_password'], $asset['user_role']),
                $asset['created_at'],
                $asset['purchase_count']
            ),
            $assets
        );
    }

    /** @return array{ array{ asset: Asset, review: Review } } */
    public function getAssetsByUserReviews(int $user_id): array
    {
        $query = "SELECT 
	asset.*,
	category.id as category_id,
	category.name as category_name,
	category.description as category_description,
	category.asset_count as category_asset_count,
	user.id as user_id,
	user.name as user_name,
	user.email as user_email,
	user.password as user_password,
	user.role as user_role,
	review.id as review_id,
	review.is_positive as review_is_positive,
	review.negative as review_negative,
	review.positive as review_positive,
	review.review as review_review,
	review.title as review_title,
	review.created_at as review_created_at
	FROM review
	JOIN asset on asset.id = review.asset_id JOIN user on user.id = review.user_id JOIN category on asset.category_id = category.id WHERE review.user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            return [];
        }

        return array_map(
            fn($item) => [
                new Asset(
                    $item['id'],
                    $item['name'],
                    $item['info'],
                    $item['description'],
                    [],
                    $item['preview_image'],
                    $item['price'],
                    $item['engine_version'],
                    new Category($item['category_id'], $item['category_name'], $item['category_description'], $item['category_asset_count']),
                    new User($item['user_id'], $item['user_name'], $item['user_email'], $item['user_password'], $item['user_role']),
                    $item['created_at'],
                    $item['purchase_count']
                ),
                new Review(
                    $item['review_id'],
                    $item['id'],
                    new User($item['user_id'], $item['user_name'], $item['user_email'], $item['user_password'], $item['user_role']),
                    $item['review_title'],
                    $item['review_review'],
                    $item['review_positive'],
                    $item['review_negative'],
                    $item['review_created_at'],
                    $item['review_is_positive']
                )
            ],
            $result
        );
    }
}
