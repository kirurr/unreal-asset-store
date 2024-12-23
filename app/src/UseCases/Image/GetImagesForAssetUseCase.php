<?php

namespace UseCases\Image;

use Exception;
use Repositories\Image\ImageRepositoryInterface;
use RuntimeException;
use Services\Files\FilesInterface;

class GetImagesForAssetUseCase
{
    public function __construct(
        private ImageRepositoryInterface $imageRepository,
        private FilesInterface $filesService
    ) {
    }
    /**
     * @return array<Image> - return paths to images
     */
    public function execute(string $asset_id): array
    {
        try {
            $images = $this->imageRepository->getForAsset($asset_id);
            $result = [];
            foreach ($images as $image) {
                $image->path = $this->filesService->getImage($image->path);
            }
            return $images;
        } catch (RuntimeException $e) {
            throw new Exception('Error getting images for asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
