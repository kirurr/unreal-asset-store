<?php

namespace UseCases\Category;

use Entities\Category;
use Repositories\Category\CategoryRepositoryInterface;
use RuntimeException;

class GetTrendingCategoriesUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    /**
     * @return Category[]
     */
    public function execute(): array
    {
        try {
            return $this->categoryRepository->getAll(true, 5);
        } catch (RuntimeException $e) {
            throw new RuntimeException('Cannot get trending categories', 500, $e);
        }
    }
}
