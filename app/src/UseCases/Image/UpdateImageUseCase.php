<?php

namespace UseCases\Image;

use Entities\Image;
use Exception;
use Repositories\Image\ImageRepositoryInterface;
use RuntimeException;
use Services\Files\FilesInterface;

class UpdateImageUseCase
{
    public function __construct(
        private ImageRepositoryInterface $imageRepository,
        private FilesInterface $filesService
    ) {
    }

    public function execute(int $id, string $path, int $asset_id, int $image_order, array $file): void
    {
        try {
            $this->filesService->deleteImage($path);
            $newPath = $this->filesService->saveImage($path, $file, $asset_id);
            $this->imageRepository->update(new Image($id, $asset_id, $image_order, $newPath));
        } catch (RuntimeException $e) {
            throw new Exception('Error updating image' . $e->getMessage(), 500, $e);
        }
    }
}
