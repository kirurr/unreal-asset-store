<?php

namespace Repositories\Image;

use Entities\Image;
use PDO;
use PDOException;
use RuntimeException;

class SQLiteImageRepository implements ImageRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(string $path, int $asset_id, int $image_order): void
    {
        try {

            $stmt = $this->pdo->prepare("INSERT INTO image (asset_id, image_order, path) VALUES (?, ?, ?)");
            $stmt->execute(
                [
                $asset_id,
                $image_order,
                $path
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function update(Image $image): void
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE image SET path = :path, image_order = :image_order WHERE id = :id');
            $stmt->execute(
                [
                'path' => $image->path,
                'image_order' => $image->image_order,
                'id' => $image->id
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function delete(Image $image): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM image WHERE id = :id');
            $stmt->execute(['id' => $image->id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getForAsset(int $asset_id): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM image WHERE asset_id = :asset_id ORDER BY image_order ASC');
            $stmt->execute(['asset_id' => $asset_id]);
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$images) {
                return [];
            }
            $result = [];
            foreach ($images as $image) {
                $result[] = new Image($image['id'], $image['asset_id'], $image['image_order'], $image['path']);
            }
            return $result;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }

    public function getById(int $id): ?Image
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM image WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
            return $image
            ? new Image($image['id'], $image['asset_id'], $image['image_order'], $image['path'])
            : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error' . $e->getMessage(), 500, $e);
        }
    }
}

