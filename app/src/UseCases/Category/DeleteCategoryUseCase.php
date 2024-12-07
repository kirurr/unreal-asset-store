<?php

namespace UseCases\Category;

use Repositories\Category\CategoryRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class DeleteCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function execute(int $id): void
    {
        try {
            $category = $this->repository->getById($id);
            if (!$category) {
                throw new DomainException('Category not found');
            }
            $this->repository->delete($id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete category: ' . $e->getMessage(), 500, $e);
        }
    }
}
