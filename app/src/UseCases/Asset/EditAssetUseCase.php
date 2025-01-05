<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use DomainException;
use Exception;
use Repositories\Category\CategoryRepositoryInterface;
use RuntimeException;

class EditAssetUseCase
{
    public function __construct(
		private AssetRepositoryInterface $repository,
		private CategoryRepositoryInterface $categoryRepository
    ) {
    }
    /**
     * @param array<string> $images
     */
    public function execute(string $id, string $name = null, string $info = null, string $description = null, string $preview_image = null, int $price = null, string $engine_version = null, int $category_id = null): void
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }

			if ($category_id) {
				$category = $this->categoryRepository->getById($category_id);
				if (!$category) {
					throw new DomainException('Category not found');
				}
			} else {
				$category = $asset->category;
			}
            
            $asset->name = $name ?? $asset->name;
            $asset->info = $info ?? $asset->info;
            $asset->description = $description ?? $asset->description;
            $asset->preview_image = $preview_image ?? $asset->preview_image;
            $asset->price = $price ?? $asset->price;
            $asset->engine_version = $engine_version ?? $asset->engine_version;
            $asset->category = $category;

            $this->repository->update($asset);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to edit asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
