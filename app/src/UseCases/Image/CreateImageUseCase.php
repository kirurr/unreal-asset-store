<?php

namespace UseCases\Image;

use Exception;
use Repositories\Image\ImageRepositoryInterface;
use RuntimeException;
use Services\Files\FilesInterface;

class CreateImageUseCase
{
    public function __construct(
        private ImageRepositoryInterface $imageRepository,
        private FilesInterface $filesService
    ) {
    }

    public function execute(string $path, int $asset_id, int $image_order, array $file): void
    {
        try {
            $newPath = $this->filesService->saveImage($path, $file, $asset_id);
            $this->imageRepository->create($newPath, $asset_id, $image_order);
        } catch (RuntimeException $e) {
            throw new Exception('Error creating image' . $e->getMessage(), 500, $e);
        }
    }
}
