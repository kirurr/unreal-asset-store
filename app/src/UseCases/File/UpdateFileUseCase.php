<?php

namespace UseCases\File;

use DomainException;
use Exception;
use Repositories\File\FileRepositoryInterface;
use Services\Files\FilesInterface;

class UpdateFileUseCase
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
        private FilesInterface $filesService
    ) {
    }
    public function execute(
        string $id,
        string $asset_id,
        string $name = null,
        string $version = null,
        string $description = null,
        string $file_name = null,
        string $path = null,
        string $old_path = null
    ): void {
        try {
            $file = $this->fileRepository->getById($id);
            if (!$file) {
                throw new DomainException('File not found');
            }

            $file->name = $name ?? $file->name;
            $file->version = $version ?? $file->version;
            $file->description = $description ?? $file->description;

            if ($file_name && $path) {
                $this->filesService->deleteFile($old_path);
                [$new_path, $size] = $this->filesService->saveFile($file_name, $path, $asset_id);
                $file->path = $new_path;
                $file->size = $size;
            }

            $this->fileRepository->update($file);
        } catch (Exception $e) {
            throw new Exception('Unable to update file: ' . $e->getMessage(), 500, $e);
        }
    }
}
