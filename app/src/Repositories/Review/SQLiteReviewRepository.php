<?php

namespace Repositories\Review;

use Entities\Review;
use Entities\User;
use PDO;
use PDOException;
use RuntimeException;

class SQLiteReviewRepository implements ReviewRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function create(string $asset_id, string $user_id, string $title, string $review, string $positive, string $negative, bool $is_positive): void
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO review (asset_id, user_id, title, review, positive, negative, is_positive) VALUES (:asset_id, :user_id, :title, :review, :positive, :negative, :is_positive)");
            $stmt->execute([
                'asset_id' => $asset_id,
                'user_id' => $user_id,
				'title' => $title,
                'review' => $review,
                'positive' => $positive,
                'negative' => $negative,
                'is_positive' => $is_positive
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function delete(string $id): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM review WHERE id = ?');
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function getById(string $id): ?Review
    {
        try {
            $stmt = $this->pdo->prepare("
\t\t\t\tSELECT review.*,
\t\t\t\tuser.id as user_id,
\t\t\t\tuser.name as user_name,
\t\t\t\tuser.email as user_email,
\t\t\t\tuser.password as user_password,
\t\t\t\tuser.role as user_role
\t\t\t\tFROM review JOIN user ON review.user_id = user.id WHERE review.id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result
                ? new Review(
                    $result['id'],
                    $result['asset_id'],
                    new User(
                        $result['user_id'],
                        $result['user_name'],
                        $result['user_email'],
                        $result['user_password'],
                        $result['user_role']
                    ),
					$result['title'],
                    $result['review'],
                    $result['positive'] ?? '',
                    $result['negative'] ?? '',
                    $result['created_at'],
                    $result['is_positive'],
                )
                : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function getAllByAssetId(string $asset_id): array
    {
        try {
            $stmt = $this->pdo->prepare("
\t\t\t\tSELECT review.*,
\t\t\t\tuser.id as user_id,
\t\t\t\tuser.name as user_name,
\t\t\t\tuser.email as user_email,
\t\t\t\tuser.password as user_password,
\t\t\t\tuser.role as user_role
\t\t\t\tFROM review JOIN user ON review.user_id = user.id WHERE review.asset_id = ?");
            $stmt->execute([$asset_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            }

            return array_map(function ($item) {
                return new Review(
                    $item['id'],
                    $item['asset_id'],
                    new User(
                        $item['user_id'],
                        $item['user_name'],
                        $item['user_email'],
                        $item['user_password'],
                        $item['user_role']
                    ),
					$item['title'],
                    $item['review'],
                    $item['positive'] ?? '',
                    $item['negative'] ?? '',
                    $item['created_at'],
                    $item['is_positive'],
                );
            }, $result);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function getAllByUserId(string $user_id): array
    {
        try {
            $stmt = $this->pdo->prepare("
\t\t\t\tSELECT review.*,
\t\t\t\tuser.id as user_id,
\t\t\t\tuser.name as user_name,
\t\t\t\tuser.email as user_email,
\t\t\t\tuser.password as user_password,
\t\t\t\tuser.role as user_role
\t\t\t\tFROM review JOIN user ON review.user_id = user.id WHERE review.user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            }

            return array_map(function ($item) {
                return new Review(
                    $item['id'],
                    $item['asset_id'],
                    new User(
                        $item['user_id'],
                        $item['user_name'],
                        $item['user_email'],
                        $item['user_password'],
                        $item['user_role']
                    ),
					$item['title'],
                    $item['review'],
                    $item['positive'] ?? '',
                    $item['negative'] ?? '',
                    $item['created_at'],
                    $item['is_positive'],
                );
            }, $result);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->prepare("
\t\t\t\tSELECT review.*,
\t\t\t\tuser.id as user_id,
\t\t\t\tuser.name as user_name,
\t\t\t\tuser.email as user_email,
\t\t\t\tuser.password as user_password,
\t\t\t\tuser.role as user_role
\t\t\t\tFROM review JOIN user ON review.user_id = user.id");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            }

            return array_map(function ($item) {
                return new Review(
                    $item['id'],
                    $item['asset_id'],
                    new User(
                        $item['user_id'],
                        $item['user_name'],
                        $item['user_email'],
                        $item['user_password'],
                        $item['user_role']
                    ),
					$item['title'],
                    $item['review'],
                    $item['positive'] ?? '',
                    $item['negative'] ?? '',
                    $item['created_at'],
                    $item['is_positive'],
                );
            }, $result);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function update(Review $review): void
    {
        try {
            $this
                ->pdo
                ->prepare('UPDATE review SET title = ?, review = ?, positive = ?, negative = ?, is_positive = ? WHERE id = ?')
                ->execute([
					$review->title,
                    $review->review,
                    $review->positive,
                    $review->negative,
                    $review->is_positive,
                    $review->id
                ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage());
        }
    }
}
