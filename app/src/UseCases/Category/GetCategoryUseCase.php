<?php

namespace UseCases\Category;

use Entities\Category;
use Repositories\Category\CategoryRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class GetCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function execute(int $id): Category
    {
        try {
            $category = $this->repository->getById($id);
            if (!$category) {
                throw new DomainException('Category not found');
            }
            return $category;
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get category: ' . $e->getMessage(), 500, $e);
        }
    }
}
