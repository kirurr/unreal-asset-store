<?php

namespace Repositories\File;

use Entities\File;
use PDO;
use PDOException;
use RuntimeException;

class SQLiteFileRepository implements FileRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }
    public function create(string $name, string $path, string $version, string $description, string $asset_id, int $size): void
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO file (name, path, version, description, asset_id, size) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(
                [
                $name,
                $path,
                $version,
                $description,
                $asset_id,
                $size
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function update(File $file): void
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE file SET name = :name, path = :path, version = :version, description = :description, size = :size WHERE id = :id');
            $stmt->execute(
                [
                'name' => $file->name,
                'path' => $file->path,
                'version' => $file->version,
                'description' => $file->description,
                'size' => $file->size,
                'id' => $file->id
                ]
            );
        }
        catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function delete(string $id): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM file WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function findById(string $id): ?File
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM file WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $file = $stmt->fetch(PDO::FETCH_ASSOC);
            return $file
            ? new File(
                $file['id'],
                $file['name'],
                $file['path'],
                $file['version'],
                $file['asset_id'],
                $file['description'],
                $file['size'],
                $file['created_at'],
            )
            : null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function findAllByAssetId(string $asset_id): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM file WHERE asset_id = :asset_id');
            $stmt->execute(['asset_id' => $asset_id]);
            $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$files) {
                return [];
            }
            return array_map(
                fn($file) => new File(
                    $file['id'],
                    $file['name'],
                    $file['path'],
                    $file['version'],
                    $file['asset_id'],
                    $file['description'],
                    $file['size'],
                    $file['created_at'],
                ),
                $files
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database error: ' . $e->getMessage(), 500, $e);
        }
    }
}
