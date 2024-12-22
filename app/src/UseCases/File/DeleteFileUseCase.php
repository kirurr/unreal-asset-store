<?php

namespace UseCases\File;

use DomainException;
use Exception;
use Services\Files\FilesInterface;
use Repositories\File\FileRepositoryInterface;

class DeleteFileUseCase
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
        private FilesInterface $filesService
    ) {
    }
    public function execute(string $id): void
    {
        try {
            $file = $this->fileRepository->getById($id);
            if (!$file) {
                throw new DomainException('File not found');
            }
            $this->filesService->deleteFile($file->path);
            $this->fileRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception('Unable to delete file: ' . $e->getMessage(), 500, $e);
        }
    }
}
