<?php

namespace Repositories\Purchase;

use Entities\Purchase;
use PDO;
use PDOException;
use RuntimeException;

class SQLitePurchaseRepository implements PurchaseRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function create(string $asset_id, int $user_id): void
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO purchase (asset_id, user_id) VALUES (?, ?)');
            $stmt->execute(
                [
                    $asset_id,
                    $user_id
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function delete(string $id): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM purchase WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getById(string $id): ?Purchase
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM purchase WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $purchase = $stmt->fetch(PDO::FETCH_ASSOC);
            return $purchase
                ? new Purchase($purchase['id'], $purchase['asset_id'], $purchase['user_id'], $purchase['purchase_date'])
                : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getAllByAssetId(string $asset_id): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM purchase WHERE asset_id = :asset_id');
            $stmt->execute(['asset_id' => $asset_id]);
            $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$purchases) {
                return [];
            }

            return array_map(function ($purchase) {
                return new Purchase(
                    $purchase['id'],
                    $purchase['asset_id'],
                    $purchase['user_id'],
                    $purchase['purchase_date'],
                );
            }, $purchases);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getAllByUserId(int $user_id): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM purchase WHERE user_id = :user_id');
            $stmt->execute(['user_id' => $user_id]);
            $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$purchases) {
                return [];
            }

            return array_map(function ($purchase) {
                return new Purchase(
                    $purchase['id'],
                    $purchase['asset_id'],
                    $purchase['user_id'],
                    $purchase['purchase_date'],
                );
            }, $purchases);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM purchase');
            $stmt->execute();
            $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$purchases) {
                return [];
            }

            return array_map(function ($purchase) {
                return new Purchase(
                    $purchase['id'],
                    $purchase['asset_id'],
                    $purchase['user_id'],
                    $purchase['purchase_date'],
                );
            }, $purchases);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }
}
