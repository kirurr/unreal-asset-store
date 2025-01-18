<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface;
use Repositories\Purchase\PurchaseRepositoryInterface;
use DomainException;
use Exception;
use Repositories\Review\ReviewRepositoryInterface;
use RuntimeException;

class DeleteAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository,
        private CategoryRepositoryInterface $categoryRepository,
        private PurchaseRepositoryInterface $purchaseRepository,
        private ReviewRepositoryInterface $reviewRepository
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
            $reviews = $this->reviewRepository->getAllByAssetId($id);
            if (!empty($reviews)) {
                throw new DomainException('Asset has reviews');
            }

            $this->repository->delete($id);
            $this->categoryRepository->decrementAssetCount($asset->category->id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
