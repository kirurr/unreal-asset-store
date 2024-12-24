<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use DomainException;
use Exception;
use Repositories\Category\CategoryRepositoryInterface;
use RuntimeException;

class DeleteAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository,
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function execute(string $id): void
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }
            $this->repository->delete($id);
            $this->categoryRepository->decrementAssetCount($asset->category_id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
