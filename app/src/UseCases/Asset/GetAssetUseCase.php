<?php

namespace UseCases\Asset;

use Entities\Asset;
use DomainException;
use Exception;
use Repositories\Asset\AssetRepositoryInterface;
use Repositories\Image\ImageRepositoryInterface;
use RuntimeException;

class GetAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository,
        private ImageRepositoryInterface $imageRepository
    ) {
    }

    public function execute(string $id): Asset
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }

            $images = $this->imageRepository->getForAsset($id);
            $asset->images = $images;
            return $asset;
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get Asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
