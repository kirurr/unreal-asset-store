<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface;
use Repositories\Purchase\PurchaseRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class DeleteAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository,
        private CategoryRepositoryInterface $categoryRepository,
        private PurchaseRepositoryInterface $purchaseRepository
    ) {}

    public function execute(string $id): void
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }
            $purchases = $this->purchaseRepository->getAllByAssetId($id);
            if (!empty($purchases)) {
                throw new DomainException('Asset is purchased by users');
            }
            $this->repository->delete($id);
            $this->categoryRepository->decrementAssetCount($asset->category_id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
