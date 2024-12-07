<?php

namespace UseCases\Category;

use Repositories\Category\CategoryRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class GetAllCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function execute(): array
    {
        try {
            return $this->repository->getAll();
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get all categories: ' . $e->getMessage(), 500, $e);
        }
    }
}
