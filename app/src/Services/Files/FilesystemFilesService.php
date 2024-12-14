<?php

namespace Services\Files;

use Exception;
use RuntimeException;

class FilesystemFilesService implements FilesInterface
{
    private const UPLOAD_DIR = BASE_PATH . '../public/assets/';
    public function saveImage(string $name, string $tmp_name, string $asset_id): string
    {
        try {
            $uploadDir = $this::UPLOAD_DIR . $asset_id . '/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
        
            $newFileName = uniqid() . '-' . $name;
            $filePath = $uploadDir . $newFileName;

            if (move_uploaded_file($tmp_name, $filePath)) {
                return "/assets/$asset_id/$newFileName";
            } 
            throw new RuntimeException('Error saving image');

        } catch (Exception $e) {
            throw new RuntimeException('Error saving image' . $e->getMessage(), 500, $e);
        }
    }

    public function getImage(string $path): string
    {
        return $path;
    }

    public function deleteImage(string $path): void
    {
        if (substr($path, 0, 1) === '/') {
            $path = substr($path, 1);
        }
        $path_to_delete = BASE_PATH . '../public/' . $path;
        if (file_exists($path_to_delete)) {
            unlink($path_to_delete);
        }
    }
}
