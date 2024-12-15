<?php

namespace UseCases\Image;

use Exception;
use Repositories\Image\ImageRepositoryInterface;
use RuntimeException;
use Services\Files\FilesInterface;

class DeleteImageUseCase
{
    public function __construct(
        private ImageRepositoryInterface $imageRepository,
        private FilesInterface $filesService
    ) {
    }

    public function execute(int $id): void
    {
        try {
            $image = $this->imageRepository->getById($id);
            $this->filesService->deleteImage($image->path);
            if ($image) {
                $this->imageRepository->delete($id);
            }
        } catch (RuntimeException $e) {
            throw new Exception('Error deleting image' . $e->getMessage(), 500, $e);
        }
    }
}
