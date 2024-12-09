<?php

namespace UseCases\Category;

use Repositories\Category\CategoryRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class CreateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function execute(string $name, string $description): void
    {
        try {
            $prev = $this->repository->getByName($name);
            if ($prev) {
                throw new DomainException('Category already exists');
            }
            $this->repository->create($name, $description);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to create category: ' . $e->getMessage(), 500, $e);
        }
    }
}
