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

    public function execute(string $name, string $tmp_name, string $asset_id, int $image_order): string
    {
        try {
            $path = $this->filesService->saveImage($name, $tmp_name, $asset_id);
            $this->imageRepository->create($path, $asset_id, $image_order);
			return $path;
        } catch (RuntimeException $e) {
            throw new Exception('Error creating image' . $e->getMessage(), 500, $e);
        }
    }
}
