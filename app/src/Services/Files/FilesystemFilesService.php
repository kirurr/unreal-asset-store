<?php

namespace Services\Files;

use Exception;
use RuntimeException;

class FilesystemFilesService implements FilesInterface
{
    public function saveImage(string $path, array $file, int $asset_id): string
    {
        try {
            $uploadDir = __DIR__ . '/../public/assets/' . $asset_id . '/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
        
			$newFileName = uniqid() . '-' . $file['name'];
            $filePath = $uploadDir . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                return $filePath;
            } 
            throw new RuntimeException('Error saving image');

        } catch (Exception $e) {
            throw new RuntimeException('Error saving image' . $e->getMessage(), 500, $e);
        }
    }

	public function getImage(string $path): string
	{
		if(is_file($path)) {
			return $path;
		}
		throw new RuntimeException('Image not found');
	}

    public function deleteImage(string $path): void
    {
        unlink($path);
    }
}
