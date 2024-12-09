<?php

namespace UseCases\Category;

use Repositories\Category\CategoryRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class EditCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function execute(int $id, string $name, string $description): void
    {
        try {
            $category = $this->repository->getById($id);
            if (!$category) {
                throw new DomainException('Category not found');
            }
            $category->name = $name;
            $category->description = $description;

            $this->repository->update($category);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to edit category: ' . $e->getMessage(), 500, $e);
        }
    }
}
