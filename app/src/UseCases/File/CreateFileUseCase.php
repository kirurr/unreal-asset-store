<?php

namespace UseCases\File;

use Exception;
use Repositories\File\FileRepositoryInterface;
use RuntimeException;
use Services\Files\FilesInterface;

class CreateFileUseCase
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
        private FilesInterface $filesService
    ) {
    }

    public function execute(string $asset_id, string $name, string $version, string $description, string $file_name, string $path): void
    {
        try {
            [$newPath, $size] = $this->filesService->saveFile($file_name, $path, $asset_id);
            $this->fileRepository->create($name, $newPath, $version,$description, $asset_id, $size);
        } catch (RuntimeException $e) {
            throw new Exception('Error creating file' . $e->getMessage(), 500, $e);
        }
    }
}
