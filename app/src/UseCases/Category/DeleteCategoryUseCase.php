<?php

namespace UseCases\Category;

use Repositories\Asset\AssetRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class DeleteCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private AssetRepositoryInterface $assetRepository
    ) {
    }

    public function execute(int $id): void
    {
        try {
            $category = $this->repository->getById($id);
            if (!$category) {
                throw new DomainException('Category not found');
            }
            $assets = $this->assetRepository->getByCategoryId($id);
            if ($assets) {
                throw new DomainException('Category has assets');
            }
            $this->repository->delete($id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete category: ' . $e->getMessage(), 500, $e);
        }
    }
}
