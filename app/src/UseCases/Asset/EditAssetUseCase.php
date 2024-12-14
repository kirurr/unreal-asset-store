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
    public function execute(string $id, string $name = null, string $info = null, string $description = null, string $preview_image = null, int $price = null, int $engine_version = null, int $category_id = null): void
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }
            
            $asset->name = $name ?? $asset->name;
            $asset->info = $info ?? $asset->info;
            $asset->description = $description ?? $asset->description;
            $asset->preview_image = $preview_image ?? $asset->preview_image;
            $asset->price = $price ?? $asset->price;
            $asset->engine_version = $engine_version ?? $asset->engine_version;
            $asset->category_id = $category_id ?? $asset->category_id;

            $this->repository->update($asset);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to edit asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
