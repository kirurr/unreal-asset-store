<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class EditAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {
    }
    /**
     * @param array<string> $images
     */
    public function execute(int $id, string $name, string $info, string $description, array $images, int $price, int $engine_version, int $category_id): void
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }
            
            $asset->name = $name;
            $asset->info = $info;
            $asset->description = $description;
            $asset->images = $images;
            $asset->price = $price;
            $asset->engine_version = $engine_version;
            $asset->category_id = $category_id;

            $this->repository->update($asset);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to edit asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
