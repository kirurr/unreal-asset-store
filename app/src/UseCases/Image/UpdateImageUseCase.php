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

    public function execute(string $asset_id, int $image_id, string $image_name, string $tmp_name, string $image_order, string $old_image_path): void
    {
        try {
            $this->filesService->deleteImage($old_image_path);
            $newPath = $this->filesService->saveImage($image_name, $tmp_name, $asset_id);
            $this->imageRepository->update(new Image($image_id, $asset_id, $image_order, $newPath));
        } catch (RuntimeException $e) {
            throw new Exception('Error updating image: ' . $e->getMessage(), 500, $e);
        }
    }
}
