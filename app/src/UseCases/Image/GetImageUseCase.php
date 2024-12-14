<?php

namespace UseCases\Image;

use DomainException;
use Entities\Image;
use Exception;
use Repositories\Image\ImageRepositoryInterface;
use RuntimeException;
use Services\Files\FilesInterface;

class GetImageUseCase
{
    public function __construct(
        private ImageRepositoryInterface $imageRepository,
        private FilesInterface $filesService
    ) {
    }
    public function execute(int $image_id): Image
    {
        try {
            $image = $this->imageRepository->getById($image_id);
			if (!$image) {
				throw new DomainException('Image not found');
			}
            $image->path = $this->filesService->getImage($image->path);
            return $image;
        } catch (RuntimeException $e) {
            throw new Exception('Error getting image: ' . $e->getMessage(), 500, $e);
        }
    }
}
